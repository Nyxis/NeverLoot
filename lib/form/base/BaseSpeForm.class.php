<?php

/**
 * Spe form base class.
 *
 * @method Spe getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSpeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_spe'    => new sfWidgetFormInputHidden(),
      'nom'       => new sfWidgetFormInputText(),
      'image'     => new sfWidgetFormInputText(),
      'id_classe' => new sfWidgetFormPropelChoice(array('model' => 'Classe', 'add_empty' => false)),
      'id_role'   => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_spe'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdSpe()), 'empty_value' => $this->getObject()->getIdSpe(), 'required' => false)),
      'nom'       => new sfValidatorString(array('max_length' => 45)),
      'image'     => new sfValidatorString(array('max_length' => 255)),
      'id_classe' => new sfValidatorPropelChoice(array('model' => 'Classe', 'column' => 'id_classe')),
      'id_role'   => new sfValidatorPropelChoice(array('model' => 'Role', 'column' => 'id_role')),
    ));

    $this->widgetSchema->setNameFormat('spe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Spe';
  }

}
