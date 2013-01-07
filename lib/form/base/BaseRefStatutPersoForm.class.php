<?php

/**
 * RefStatutPerso form base class.
 *
 * @method RefStatutPerso getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRefStatutPersoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_ref_statut_perso' => new sfWidgetFormInputHidden(),
      'code'                => new sfWidgetFormInputText(),
      'libelle'             => new sfWidgetFormInputText(),
      'coef'                => new sfWidgetFormInputText(),
      'image'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_ref_statut_perso' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdRefStatutPerso()), 'empty_value' => $this->getObject()->getIdRefStatutPerso(), 'required' => false)),
      'code'                => new sfValidatorString(array('max_length' => 45)),
      'libelle'             => new sfValidatorString(array('max_length' => 45)),
      'coef'                => new sfValidatorNumber(),
      'image'               => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('ref_statut_perso[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefStatutPerso';
  }

}
