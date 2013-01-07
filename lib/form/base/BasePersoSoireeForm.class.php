<?php

/**
 * PersoSoiree form base class.
 *
 * @method PersoSoiree getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersoSoireeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_perso_soiree' => new sfWidgetFormInputHidden(),
      'id_perso'        => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => false)),
      'id_statut_perso' => new sfWidgetFormPropelChoice(array('model' => 'RefStatutPerso', 'add_empty' => false)),
      'id_statut_admin' => new sfWidgetFormPropelChoice(array('model' => 'RefStatutPerso', 'add_empty' => false)),
      'id_soiree'       => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => false)),
      'id_role'         => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => true)),
      'pts_soiree'      => new sfWidgetFormInputText(),
      'pts_loot'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_perso_soiree' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdPersoSoiree()), 'empty_value' => $this->getObject()->getIdPersoSoiree(), 'required' => false)),
      'id_perso'        => new sfValidatorPropelChoice(array('model' => 'Perso', 'column' => 'id_perso')),
      'id_statut_perso' => new sfValidatorPropelChoice(array('model' => 'RefStatutPerso', 'column' => 'id_ref_statut_perso')),
      'id_statut_admin' => new sfValidatorPropelChoice(array('model' => 'RefStatutPerso', 'column' => 'id_ref_statut_perso')),
      'id_soiree'       => new sfValidatorPropelChoice(array('model' => 'Soiree', 'column' => 'id_soiree')),
      'id_role'         => new sfValidatorPropelChoice(array('model' => 'Role', 'column' => 'id_role', 'required' => false)),
      'pts_soiree'      => new sfValidatorString(array('required' => false)),
      'pts_loot'        => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perso_soiree[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersoSoiree';
  }

}
