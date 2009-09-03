<?php
class InscriptionmailForm extends CitoyenForm
{
  public function configure()
  {
    $this->widgetSchema->setNameFormat('citoyen[%s]');
    
    // Enleve les widgets qu'on ne veut pas montrer
    unset(
      $this['id'], 
      $this['email'],
      $this['activite'],
      $this['naissance'],
      $this['sexe'],
      $this['employe_an'],
      $this['travail_pour'],
      $this['nom_circo'],
      $this['num_circo'],
      $this['photo'],
      $this['is_active'],
      $this['activation_id'],
      $this['role'],
      $this['last_login'],
      $this['created_at'],
      $this['updated_at'],
      $this['slug']
    );
    
    $this->widgetSchema['login'] = new sfWidgetFormInput();
    $this->validatorSchema['login']->setOption('required', true);
    $this->widgetSchema['pass'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['pass']->setOption('required', true);

    // Les labels
    $this->widgetSchema->setLabels(array(
      'login' => 'Nom d\'utilisateur *',
      'pass' => 'Mot de passe *'
    ));
  }
}
?>