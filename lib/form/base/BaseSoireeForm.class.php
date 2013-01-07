<?php

/**
 * Soiree form base class.
 *
 * @method Soiree getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSoireeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_soiree'   => new sfWidgetFormInputHidden(),
      'date'        => new sfWidgetFormDateTime(),
      'nom'         => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'gain'        => new sfWidgetFormInputText(),
      'etat'        => new sfWidgetFormInputText(),
      'id_raid'     => new sfWidgetFormPropelChoice(array('model' => 'Raid', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_soiree'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdSoiree()), 'empty_value' => $this->getObject()->getIdSoiree(), 'required' => false)),
      'date'        => new sfValidatorDateTime(),
      'nom'         => new sfValidatorString(array('max_length' => 45)),
      'description' => new sfValidatorString(),
      'gain'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'etat'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_raid'     => new sfValidatorPropelChoice(array('model' => 'Raid', 'column' => 'id_raid')),
    ));

    $this->widgetSchema->setNameFormat('soiree[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Soiree';
  }

}
