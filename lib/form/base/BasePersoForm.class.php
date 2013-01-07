<?php

/**
 * Perso form base class.
 *
 * @method Perso getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_perso'  => new sfWidgetFormInputHidden(),
      'nom'       => new sfWidgetFormInputText(),
      'is_main'   => new sfWidgetFormInputCheckbox(),
      'id_compte' => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => false)),
      'id_classe' => new sfWidgetFormPropelChoice(array('model' => 'Classe', 'add_empty' => false)),
      'id_spe1'   => new sfWidgetFormPropelChoice(array('model' => 'Spe', 'add_empty' => false)),
      'id_spe2'   => new sfWidgetFormPropelChoice(array('model' => 'Spe', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_perso'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdPerso()), 'empty_value' => $this->getObject()->getIdPerso(), 'required' => false)),
      'nom'       => new sfValidatorString(array('max_length' => 45)),
      'is_main'   => new sfValidatorBoolean(),
      'id_compte' => new sfValidatorPropelChoice(array('model' => 'Compte', 'column' => 'id_compte')),
      'id_classe' => new sfValidatorPropelChoice(array('model' => 'Classe', 'column' => 'id_classe')),
      'id_spe1'   => new sfValidatorPropelChoice(array('model' => 'Spe', 'column' => 'id_spe')),
      'id_spe2'   => new sfValidatorPropelChoice(array('model' => 'Spe', 'column' => 'id_spe')),
    ));

    $this->widgetSchema->setNameFormat('perso[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Perso';
  }

}
