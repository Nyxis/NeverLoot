<?php

/**
 * Slot form base class.
 *
 * @method Slot getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSlotForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_slot'      => new sfWidgetFormInputHidden(),
      'type_slot'    => new sfWidgetFormInputText(),
      'code_mrrobot' => new sfWidgetFormInputText(),
      'libelle'      => new sfWidgetFormInputText(),
      'image'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_slot'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdSlot()), 'empty_value' => $this->getObject()->getIdSlot(), 'required' => false)),
      'type_slot'    => new sfValidatorString(array('max_length' => 45)),
      'code_mrrobot' => new sfValidatorString(array('max_length' => 45)),
      'libelle'      => new sfValidatorString(array('max_length' => 45)),
      'image'        => new sfValidatorString(array('max_length' => 45)),
    ));

    $this->widgetSchema->setNameFormat('slot[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Slot';
  }

}
