<?php

/**
 * Compte form base class.
 *
 * @method Compte getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCompteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_compte'    => new sfWidgetFormInputHidden(),
      'login'        => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'nb_raids'     => new sfWidgetFormInputText(),
      'nb_loot'      => new sfWidgetFormInputText(),
      'priorite'     => new sfWidgetFormInputText(),
      'id_ref_acces' => new sfWidgetFormPropelChoice(array('model' => 'RefAcces', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_compte'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdCompte()), 'empty_value' => $this->getObject()->getIdCompte(), 'required' => false)),
      'login'        => new sfValidatorString(array('max_length' => 45)),
      'password'     => new sfValidatorString(array('max_length' => 45)),
      'nb_raids'     => new sfValidatorNumber(),
      'nb_loot'      => new sfValidatorNumber(),
      'priorite'     => new sfValidatorNumber(),
      'id_ref_acces' => new sfValidatorPropelChoice(array('model' => 'RefAcces', 'column' => 'id_ref_acces')),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Compte', 'column' => array('login')))
    );

    $this->widgetSchema->setNameFormat('compte[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Compte';
  }

}
