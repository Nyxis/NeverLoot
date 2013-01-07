<?php

/**
 * Classe filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseClasseFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_armor_type' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'code'          => new sfValidatorPass(array('required' => false)),
      'nom'           => new sfValidatorPass(array('required' => false)),
      'id_armor_type' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'image'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classe';
  }

  public function getFields()
  {
    return array(
      'id_classe'     => 'Number',
      'code'          => 'Text',
      'nom'           => 'Text',
      'id_armor_type' => 'Number',
      'image'         => 'Text',
    );
  }
}
