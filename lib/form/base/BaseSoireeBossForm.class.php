<?php

/**
 * SoireeBoss form base class.
 *
 * @method SoireeBoss getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSoireeBossForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_soiree_boss' => new sfWidgetFormInputHidden(),
      'id_boss'        => new sfWidgetFormPropelChoice(array('model' => 'Boss', 'add_empty' => false)),
      'id_soiree'      => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => false)),
      'dead'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id_soiree_boss' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdSoireeBoss()), 'empty_value' => $this->getObject()->getIdSoireeBoss(), 'required' => false)),
      'id_boss'        => new sfValidatorPropelChoice(array('model' => 'Boss', 'column' => 'id_boss')),
      'id_soiree'      => new sfValidatorPropelChoice(array('model' => 'Soiree', 'column' => 'id_soiree')),
      'dead'           => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('soiree_boss[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SoireeBoss';
  }

}
