<?php

/**
 * SourceObjet form base class.
 *
 * @method SourceObjet getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSourceObjetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_source_objet' => new sfWidgetFormInputHidden(),
      'type'            => new sfWidgetFormInputText(),
      'id_type'         => new sfWidgetFormInputText(),
      'code'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_source_objet' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdSourceObjet()), 'empty_value' => $this->getObject()->getIdSourceObjet(), 'required' => false)),
      'type'            => new sfValidatorString(array('max_length' => 10)),
      'id_type'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'code'            => new sfValidatorString(array('max_length' => 45, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source_objet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SourceObjet';
  }

}
