<?php

/**
 * Raid filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRaidFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_zone' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_fr'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_en'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'   => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_zone' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nom_fr'  => new sfValidatorPass(array('required' => false)),
      'nom_en'  => new sfValidatorPass(array('required' => false)),
      'image'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('raid_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Raid';
  }

  public function getFields()
  {
    return array(
      'id_raid' => 'Number',
      'id_zone' => 'Number',
      'nom_fr'  => 'Text',
      'nom_en'  => 'Text',
      'image'   => 'Text',
    );
  }
}
