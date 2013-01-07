<?php

/**
 * Boss form base class.
 *
 * @method Boss getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseBossForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_boss'    => new sfWidgetFormInputHidden(),
      'id_raid'    => new sfWidgetFormPropelChoice(array('model' => 'Raid', 'add_empty' => false)),
      'nom_fr'     => new sfWidgetFormInputText(),
      'nom_en'     => new sfWidgetFormInputText(),
      'ordre'      => new sfWidgetFormInputText(),
      'cadavre_fr' => new sfWidgetFormInputText(),
      'cadavre_en' => new sfWidgetFormInputText(),
      'image'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_boss'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdBoss()), 'empty_value' => $this->getObject()->getIdBoss(), 'required' => false)),
      'id_raid'    => new sfValidatorPropelChoice(array('model' => 'Raid', 'column' => 'id_raid')),
      'nom_fr'     => new sfValidatorString(array('max_length' => 75)),
      'nom_en'     => new sfValidatorString(array('max_length' => 75, 'required' => false)),
      'ordre'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'cadavre_fr' => new sfValidatorString(array('max_length' => 75)),
      'cadavre_en' => new sfValidatorString(array('max_length' => 75, 'required' => false)),
      'image'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('boss[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Boss';
  }

}
