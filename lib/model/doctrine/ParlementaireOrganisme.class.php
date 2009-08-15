<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ParlementaireOrganisme extends BaseParlementaireOrganisme
{
    public static function defImportance($fonction) {
      if (preg_match('`^(président|président)`i', $fonction)) return 100;
      if (preg_match('`(président|président)`i', $fonction)) return 90;
      if (preg_match('`(rapporteur|secretaire|secrétaire)`i', $fonction)) return 80;
      if (preg_match('`questeur`i', $fonction)) {
          if (preg_match('`membre`i', $fonction)) return 70;
          return 60;
      }
      if (preg_match('`membre`i', $fonction)) {
          if (preg_match('`(suppleant|suppléant)`i', $fonction)) return 30;
          if ($fonction == "membre") return 40;
          return 50;
      }
      if (preg_match('`apparent`i', $fonction)) return 20;
      if (preg_match('`reprise`i', $fonction)) return 10;
      return 0;
  }

  public function getNom() {
    return $this->getOrganisme()->getNom();
  }
  public function getType() {
    return $this->getOrganisme()->getType();
  }
  public function getSlug() {
    return $this->getOrganisme()->getSlug();
  }
}