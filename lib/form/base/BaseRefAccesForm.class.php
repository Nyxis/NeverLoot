<?php

/**
 * RefAcces form base class.
 *
 * @method RefAcces getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRefAccesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ref_acces' => new sfWidgetFormInputHidden(),
      'code_acces'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_ref_acces' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdRefAcces()), 'empty_value' => $this->getObject()->getIdRefAcces(), 'required' => false)),
      'code_acces'   => new sfValidatorString(array('max_length' => 10)),
    ));

    $this->widgetSchema->setNameFormat('ref_acces[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefAcces';
  }

}
