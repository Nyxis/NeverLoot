<?php

/**
 * Compte filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCompteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'login'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nb_raids'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nb_loot'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'priorite'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_ref_acces' => new sfWidgetFormPropelChoice(array('model' => 'RefAcces', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'login'        => new sfValidatorPass(array('required' => false)),
      'password'     => new sfValidatorPass(array('required' => false)),
      'nb_raids'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'nb_loot'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'priorite'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'id_ref_acces' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RefAcces', 'column' => 'id_ref_acces')),
    ));

    $this->widgetSchema->setNameFormat('compte_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Compte';
  }

  public function getFields()
  {
    return array(
      'id_compte'    => 'Number',
      'login'        => 'Text',
      'password'     => 'Text',
      'nb_raids'     => 'Number',
      'nb_loot'      => 'Number',
      'priorite'     => 'Number',
      'id_ref_acces' => 'ForeignKey',
    );
  }
}
