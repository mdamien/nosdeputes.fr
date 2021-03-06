<?php

class updateAmdmtsTask extends sfBaseTask {
  protected function configure() {
    $this->namespace = 'update';
    $this->name = 'Amdmts';
    $this->briefDescription = 'Update Amendements data to set auteur_id';
    $this->addOption('env', null, sfCommandOption::PARAMETER_OPTIONAL, 'Changes the environment this task is run in', 'prod');
    $this->addOption('app', null, sfCommandOption::PARAMETER_OPTIONAL, 'Changes the environment this task is run in', 'frontend');
    $this->addOption('max', null, sfCommandOption::PARAMETER_OPTIONAL, 'Changes the environment this task is run in', '3');
  }

  protected function execute($arguments = array(), $options = array()) {
    // your code here
    $dir = dirname(__FILE__).'/../../batch/amendements/OpenDataAN/';
    $to_load_file = dirname(__FILE__).'/../../batch/amendements/json/OpenData_missing.json';
    $this->configuration = sfProjectConfiguration::getApplicationConfiguration($options['app'], $options['env'], true);
    $manager = new sfDatabaseManager($this->configuration);
    $nb_json_files = 0;

    if (is_dir($dir)) {
      if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) != false) {
          if (substr($file, 0, 12) != 'amendements_') continue;
          print "$file\n";
          $nb_json_files++;
          if ($nb_json_files > $options['max'])
            break;
          $ct_lines = 0;
          $ct_lus = 0;
          $ct_crees = 0;
          foreach(file($dir.$file) as $line) {
            $ct_lines++;
            $json = json_decode($line);
            if (!$json) {
              echo "ERROR json : $line";
              continue;
            }
            if (!$json->legislature || !$json->numero || !$json->loi || !$json->sujet || !isset($json->rectif)) {
              echo "ERROR mandatory arg missing (source|legis|numero|loi|sujet|texte|date|rectif): $line\n";
              continue;
            }
            $amdmt = Doctrine::getTable('Amendement')->findLastOneByLegisLoiNum($json->legislature, $json->loi, $json->numero);
            if (!$amdmt) {
              #echo "WARNING: amdmt from OpenData AN missing from ND data: ".$json->source."\n";
              file_put_contents($to_load_file, $line, FILE_APPEND | LOCK_EX);
              $ct_crees++;
              continue;
            }
            $save = False;
            if ($json->sort != "Indéfini" && $amdmt->sort == "Indéfini") {
              $amdmt->sort = $json->sort;
              $save = True;
            }
            if ($json->auteur_reel && !$amdmt->auteur_id) {
              $parl = Doctrine::getTable('Parlementaire')->findOneByIdAn($json->auteur_reel);
              if ($parl) {
                $amdmt->setFirstAuteur($parl);
                $save = True;
              } else {
                echo "ERROR, cannot find auteur from AN ID: $line\n";
              }
            }
            if ($save) {
              $ct_lus++;
              $amdmt->save();
            }
            $amdmt->free();
          }
          if ($ct_lines) echo $ct_lines." amendements lus : ".$ct_lus." mis à jour et ".$ct_crees." nouveaux trouvés.\n";
          unlink($dir.$file);
        }
        closedir($dh);
      }
    }
  }
}
