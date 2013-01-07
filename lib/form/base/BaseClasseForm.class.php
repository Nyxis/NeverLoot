<?php

/**
 * Classe form base class.
 *
 * @method Classe getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseClasseForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_classe'     => new sfWidgetFormInputHidden(),
      'code'          => new sfWidgetFormInputText(),
      'nom'           => new sfWidgetFormInputText(),
      'id_armor_type' => new sfWidgetFormInputText(),
      'image'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_classe'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdClasse()), 'empty_value' => $this->getObject()->getIdClasse(), 'required' => false)),
      'code'          => new sfValidatorString(array('max_length' => 45)),
      'nom'           => new sfValidatorString(array('max_length' => 45)),
      'id_armor_type' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'image'         => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('classe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classe';
  }

}
