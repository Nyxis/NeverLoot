<?php

/**
 * Attribution form base class.
 *
 * @method Attribution getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAttributionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_attribution' => new sfWidgetFormInputHidden(),
      'tmp'            => new sfWidgetFormInputCheckbox(),
      'prix'           => new sfWidgetFormInputText(),
      'id_objet'       => new sfWidgetFormPropelChoice(array('model' => 'Objet', 'add_empty' => false)),
      'id_soiree'      => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => false)),
      'id_perso'       => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_attribution' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdAttribution()), 'empty_value' => $this->getObject()->getIdAttribution(), 'required' => false)),
      'tmp'            => new sfValidatorBoolean(),
      'prix'           => new sfValidatorNumber(),
      'id_objet'       => new sfValidatorPropelChoice(array('model' => 'Objet', 'column' => 'id_objet')),
      'id_soiree'      => new sfValidatorPropelChoice(array('model' => 'Soiree', 'column' => 'id_soiree')),
      'id_perso'       => new sfValidatorPropelChoice(array('model' => 'Perso', 'column' => 'id_perso')),
    ));

    $this->widgetSchema->setNameFormat('attribution[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attribution';
  }

}
