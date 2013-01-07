<?php

/**
 * Role filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRoleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'libelle' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'code'    => new sfValidatorPass(array('required' => false)),
      'libelle' => new sfValidatorPass(array('required' => false)),
      'image'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('role_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Role';
  }

  public function getFields()
  {
    return array(
      'id_role' => 'Number',
      'code'    => 'Text',
      'libelle' => 'Text',
      'image'   => 'Text',
    );
  }
}
