<?php

/**
 * RoleSoiree filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRoleSoireeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_soiree' => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => true)),
      'id_perso'  => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => true)),
      'role'      => new sfWidgetFormFilterInput(),
      'etat'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_soiree' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Soiree', 'column' => 'id_soiree')),
      'id_perso'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Perso', 'column' => 'id_perso')),
      'role'      => new sfValidatorPass(array('required' => false)),
      'etat'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('role_soiree_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RoleSoiree';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'id_soiree' => 'ForeignKey',
      'id_perso'  => 'ForeignKey',
      'role'      => 'Text',
      'etat'      => 'Number',
    );
  }
}
