<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PersonnaliteTable extends Doctrine_Table
{
  static $changed = 0;
  static $all = null;
  public function similarTo($str)
  {
    $str = preg_replace('/\(.*\)/', '', $str);
    $word = preg_replace('/^.*\s(\S+)\s*$/i', '\\1', $str);
    $q = $this->createQuery('p')->where('nom LIKE ?', '% '.$word.'%');
    $res = $q->Execute();
    if ($res->count() == 1) {
      return $res[0];
    }
    $q->free();
    $res->free();

    //load parlementaires only once
    if (!$this->all) {
      $this->all = $this->createQuery('p')->fetchArray();
      $this->changed = 0;
    }

    $closest = null;
    $closest_res = -1;
    $champ = 'nom';
    if (!preg_match('/ /', $str))
      $champ = 'nom_de_famille';
    //Compare each parlementaire with the string and keep the best
    foreach ($this->all as $parl) {
      $res = similar_text(preg_replace('/[^a-z]+/i', ' ', $parl[$champ]), preg_replace('/[^a-z]+/i', ' ', $str), $pc);
      if ($res > 0 && $pc > $closest_res) {
	$closest = $parl;
	$closest_res = (strlen($str) - $res < 3) ? 90 : $pc;
      }
    }

#    echo "$str "; echo $closest['nom'];    echo " $closest_res\n";

    //If more than 85% similarities, it is the best
    if ($closest_res > 85)
      return $this->find($closest['id']);
    //If str is the end of the best parlementaire, it is OK (remove non alpha car to avoid preg pb)
    if (preg_match('/'.preg_replace('/[^a-z]/i', '', $str).'$/', preg_replace('/[^a-z]/i', '', $closest['nom'])))
      return $this->find($closest['id']);


    return null;
  }

  public function hasChanged() {
    $this->changed = 1;
  }

}