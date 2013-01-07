<?php

/**
 * RoleSoiree form base class.
 *
 * @method RoleSoiree getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRoleSoireeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'id_soiree' => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => false)),
      'id_perso'  => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => false)),
      'role'      => new sfWidgetFormInputText(),
      'etat'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_soiree' => new sfValidatorPropelChoice(array('model' => 'Soiree', 'column' => 'id_soiree')),
      'id_perso'  => new sfValidatorPropelChoice(array('model' => 'Perso', 'column' => 'id_perso')),
      'role'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'etat'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_soiree[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleSoiree';
  }

}
