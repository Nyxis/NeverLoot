<?php

/**
 * Objet form base class.
 *
 * @method Objet getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseObjetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_objet'        => new sfWidgetFormInputHidden(),
      'ilevel'          => new sfWidgetFormInputText(),
      'heroique'        => new sfWidgetFormInputCheckbox(),
      'nom_fr'          => new sfWidgetFormInputText(),
      'nom_en'          => new sfWidgetFormInputText(),
      'image'           => new sfWidgetFormInputText(),
      'classes'         => new sfWidgetFormTextarea(),
      'json_source'     => new sfWidgetFormTextarea(),
      'id_source_objet' => new sfWidgetFormPropelChoice(array('model' => 'SourceObjet', 'add_empty' => true)),
      'id_armor_type'   => new sfWidgetFormInputText(),
      'id_slot1'        => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => true)),
      'id_slot2'        => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_objet'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdObjet()), 'empty_value' => $this->getObject()->getIdObjet(), 'required' => false)),
      'ilevel'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'heroique'        => new sfValidatorBoolean(),
      'nom_fr'          => new sfValidatorString(array('max_length' => 75)),
      'nom_en'          => new sfValidatorString(array('max_length' => 75)),
      'image'           => new sfValidatorString(array('max_length' => 75)),
      'classes'         => new sfValidatorString(),
      'json_source'     => new sfValidatorString(),
      'id_source_objet' => new sfValidatorPropelChoice(array('model' => 'SourceObjet', 'column' => 'id_source_objet', 'required' => false)),
      'id_armor_type'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_slot1'        => new sfValidatorPropelChoice(array('model' => 'Slot', 'column' => 'id_slot', 'required' => false)),
      'id_slot2'        => new sfValidatorPropelChoice(array('model' => 'Slot', 'column' => 'id_slot', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('objet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Objet';
  }

}
