<?php

/**
 * Guilde form base class.
 *
 * @method Guilde getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseGuildeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'id_guilde' => new sfWidgetFormInputText(),
      'nom'       => new sfWidgetFormInputText(),
      'serveur'   => new sfWidgetFormInputText(),
      'site'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'id_guilde' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'nom'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'serveur'   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'site'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('guilde[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Guilde';
  }

}
