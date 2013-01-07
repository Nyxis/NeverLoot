<?php

/**
 * Raid form base class.
 *
 * @method Raid getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRaidForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_raid' => new sfWidgetFormInputHidden(),
      'id_zone' => new sfWidgetFormInputText(),
      'nom_fr'  => new sfWidgetFormInputText(),
      'nom_en'  => new sfWidgetFormInputText(),
      'image'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_raid' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdRaid()), 'empty_value' => $this->getObject()->getIdRaid(), 'required' => false)),
      'id_zone' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'nom_fr'  => new sfValidatorString(array('max_length' => 45)),
      'nom_en'  => new sfValidatorString(array('max_length' => 45)),
      'image'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('raid[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Raid';
  }

}
