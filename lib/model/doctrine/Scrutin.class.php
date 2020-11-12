<?php

class Scrutin extends BaseScrutin
{
  public function getLinkSource() {
    return "http://www2.assemblee-nationale.fr/scrutins/detail/(legislature)/"
         . myTools::getLegislature()
         . "/(num)/"
         . $this->numero;
  }

  public function setSeance($id_jo) {
    $seance = Doctrine::getTable('Seance')->findOneByIDJO($id_jo);
    if (!$seance) {
      throw new Exception("Aucune séance trouvée avec l'id JO $id_jo");
    }

    $ret = $this->_set('seance_id', $seance->id)
        && $this->_set('date', $seance->date)
        && $this->_set('numero_semaine', $seance->numero_semaine)
        && $this->_set('annee', $seance->annee);

    $seance->free();
    return $ret;
  }

  // Recherche de l'intervention avec un tableau de votants qui correspond
  public function tagIntervention() {
    // Listing des interventions avec un tableau de scrutin
    $inters = Doctrine::getTable('Intervention')
                      ->createQuery('i')
                      ->where('i.seance_id = ?', $this->seance_id)
                      ->andWhere("i.intervention LIKE '%nombre de votants%suffrages exprimés%pour%contre%' OR i.intervention LIKE '%Majorité requise pour l\'adoption%pour l\'adoption%'")
                      // ->andWhere("i.intervention LIKE '%table class=\"scrutin\"%'")
                      ->orderBy('i.timestamp')
                      ->execute();

    $found = FALSE;
    $info = "votants: {$this->nombre_votants}, pour: {$this->nombre_pours}, contre: {$this->nombre_contres}";
    $source = "";

    foreach ($inters as $inter) {
      // Extraction des votants/pours/contres
      $text = $inter->intervention;
      if (!$source) $source = $inter->source;
      $mv = preg_match_all('/nombre de votants(?:<\/td><td>|[,\s]*)(\d+)/i', $text, $match_votant);
      $mp = preg_match_all('/pour l\'(?:adoption|approbation)(?:<\/td><td>|[,\s]*)(\d+)\D/i', $text, $match_pour);
      $mc = preg_match_all('/contre(?:<\/td><td>|[,\s]*)(\d+)/i', $text, $match_contre);

      if (preg_match("/Majorité requise pour l'adoption/", $text) && $mp != 0 && intval(end($match_pour[1])) == $this->nombre_votants && intval(end($match_pour[1])) == $this->nombre_pours) {
        $found = TRUE;
        $inter->addTag("scrutin:numero={$this->numero}");
        break;
      } elseif ($mv == 0 || $mp == 0 || $mc == 0) {
        echo "WARNING: décomptes intervention {$inter->id} incomplets $mv $mp $mc :\n$text\n";
      } elseif (intval(end($match_votant[1])) != $this->nombre_votants
             || intval(end($match_pour[1])) != $this->nombre_pours
             || intval(end($match_contre[1])) != $this->nombre_contres) {
        $info .= "\n  inter {$inter->id} différente (v:".end($match_votant[1]).", p:".end($match_pour[1]).", c:".end($match_contre[1]).")";
      } else {
        $found = TRUE;
        $inter->addTag("scrutin:numero={$this->numero}");
        break;
      }
    }

    if (!$found) {
      $seance = $this->Seance;
      throw new Exception(
          "Scrutin {$this->numero} non trouvé dans les interventions "
        . "de la séance {$seance->id} du {$seance->date} {$seance->moment}\n"
        . "{$source}\n"
        . "$info"
      );
    }
  }

  public function setDemandeurs($demandeurs) {
    $ret = $this->_set('demandeurs', join("|", $demandeurs));
    $gpes = array();
    foreach($demandeurs as $d) {
      if (preg_match('/^Président\S* du groupe [^A-ZÉ]*(.*)$/', $d, $match)) {
        $gpe_acro = myTools::findGroupeAcronyme($match[1]);
        if (!$gpe_acro)
          print("WARNING: no groupe acronyme found for $d");
        else $gpes[] = $gpe_acro;
      } else if (! preg_match('/^((Conférence des )?Présidents?|Gouvernement|Commission)/', $d))
        print("WARNING: unidentified kind of demandeur: $d");
    }
    if ($gpes) {
      $this->_set('demandeurs_groupes_acronymes', join("|", $gpes));
    }
    return $ret;
  }

  public function getDemandeurs() {
    return explode("|", $this->_get('demandeurs'));
  }

  public function getDemandeursGroupesAcronymes() {
    return explode("|", $this->_get('demandeurs_groupes_acronymes'));
  }

  public function setTitre($titre) {
    // TODO? clean title
    return $this->_set('titre', $titre);
  }

  public function setStats($sort, $nb_votants, $nb_pours, $nb_contres, $nb_abst) {
    return $this->_set('sort', $sort)
        && $this->_set('nombre_votants', $nb_votants)
        && $this->_set('nombre_pours', $nb_pours)
        && $this->_set('nombre_contres', $nb_contres)
        && $this->_set('nombre_abstentions', $nb_abst);
  }

  public function setVotes($parlementaires, $has_delegations) {
    foreach ($parlementaires as $id_an => $data) {
      try {
        $parlscrutin = Doctrine::getTable('ParlementaireScrutin')
                               ->findOneByScrutinIDAN($this->id, $id_an);

        if (!$parlscrutin) {
          $parlscrutin = new ParlementaireScrutin();
          if (!$parlscrutin->setParlementaireByIDAN($id_an)
           || !$parlscrutin->setScrutin($this)) {
            throw new Exception('Could not set ParlId/ScrutinId');
          }
        }

        if (!$parlscrutin->_set('parlementaire_groupe_acronyme', $data->groupe)
         || !$parlscrutin->_set('position', $data->position)
         || !$parlscrutin->_set('position_groupe', $data->position_groupe)
         || !$parlscrutin->_set('par_delegation', $data->par_delegation)
         || !$parlscrutin->_set('mise_au_point_position', $data->mise_au_point_position)) {
          throw new Exception("Could not set vote metadata: {$data}");
        }

        if ($has_delegations || $this->isPartOfDelegationsRanges()) {
          $parlscrutin->updatePresence();
        }

        $parlscrutin->save();
        $parlscrutin->free();
      } catch (Exception $e) {
        echo "ERREUR scrutin {$this->id}, parl $id_an: {$e->getMessage()}\n";
      }
    }
  }

  public function isPartOfDelegationsRanges() {
      $is_part = false;
      foreach(ScrutinTable::getInstance()->getDelegationsRanges() as $range) {
          $is_part |= ($range[ScrutinTable::DELEGATIONS_INDEX_DEBUT] <= $this->Seance->date && $this->Seance->date <= $range[ScrutinTable::DELEGATIONS_INDEX_FIN]);
      }
      return $is_part;
  }

  public function getURLInstitution() {
    return "http://www2.assemblee-nationale.fr/scrutins/detail/(legislature)/".myTools::getLegislature()."/(num)/".$this->numero;
  }

  // https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
  private function titleStartsWith( $needle ) {
    $length = strlen( $needle );
    return substr( $this->titre, 0, $length ) === $needle;
  }

  public function isOnWholeText() {
    if ($this->titleStartsWith("l'ensemble")) {
      return true;
    }
    if ($this->titleStartsWith("l'amendement")) {
      return false;
    }
    if ($this->titleStartsWith("les crédits")) {
      return false;
    }
    if ($this->titleStartsWith("la motion de rejet préalable")) {
      return false;
    }
    if ($this->titleStartsWith("l'article")) {
      return false;
    }
    if ($this->titleStartsWith("la première partie")) {
      return false;
    }
    if ($this->titleStartsWith("le sous-amendement")) {
      return false;
    }
    if ($this->titleStartsWith("le sous-amendment")) { //typo
      return false;
    }
    if ($this->titleStartsWith("la déclaration ")) {
      return true;
    }
    if ($this->titleStartsWith("la declaration")) { //typo
      return true;
    }
    if ($this->titleStartsWith("la motion de censure")) {
      return true;
    }
    if ($this->titleStartsWith("l'opposition à la demande de constitution")) {
      return false;
    }
    if ($this->titleStartsWith("la demande de suspension de séance")) {
      return false;
    }
    if ($this->titleStartsWith("le demande de suspension de séance")) { //typo
      return false;
    }
    if ($this->titleStartsWith("la motion référendaire")) {
      return false;
    }
    if ($this->titleStartsWith("la proposition de résolution")) {
      return true;
    }
    if ($this->titleStartsWith("la motion d'ajournement")) {
      return false;
    }
    if ($this->titleStartsWith("la motion de renvoi en commission")) {
      return false;
    }
    if ($this->titleStartsWith("la motion de renvoi en commision")) { //typo
      return false;
    }
    if ($this->titleStartsWith("les conclusions de rejet")) { // not sure
      return true;
    }
    if ($this->titleStartsWith("la demande de constitution de commission spéciale")) { // not sure
      return false;
    }
  }

  public function getLaw() {
    preg_match_all('/((?:projet|proposition) de (?:loi|résolution) .*?(?:\)|$))/', $this->titre, $matches, PREG_SET_ORDER, 0);
    if ($matches) {
      return $matches[0][0];
    }
  }
}
