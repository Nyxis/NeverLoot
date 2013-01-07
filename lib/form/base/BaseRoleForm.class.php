<?php

/**
 * Role form base class.
 *
 * @method Role getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRoleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_role' => new sfWidgetFormInputHidden(),
      'code'    => new sfWidgetFormInputText(),
      'libelle' => new sfWidgetFormInputText(),
      'image'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_role' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdRole()), 'empty_value' => $this->getObject()->getIdRole(), 'required' => false)),
      'code'    => new sfValidatorString(array('max_length' => 45)),
      'libelle' => new sfValidatorString(array('max_length' => 45)),
      'image'   => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('role[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Role';
  }

}
