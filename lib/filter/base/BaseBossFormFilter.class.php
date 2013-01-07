<?php

/**
 * Boss filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseBossFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_raid'    => new sfWidgetFormPropelChoice(array('model' => 'Raid', 'add_empty' => true)),
      'nom_fr'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_en'     => new sfWidgetFormFilterInput(),
      'ordre'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cadavre_fr' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cadavre_en' => new sfWidgetFormFilterInput(),
      'image'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_raid'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Raid', 'column' => 'id_raid')),
      'nom_fr'     => new sfValidatorPass(array('required' => false)),
      'nom_en'     => new sfValidatorPass(array('required' => false)),
      'ordre'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cadavre_fr' => new sfValidatorPass(array('required' => false)),
      'cadavre_en' => new sfValidatorPass(array('required' => false)),
      'image'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('boss_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Boss';
  }

  public function getFields()
  {
    return array(
      'id_boss'    => 'Number',
      'id_raid'    => 'ForeignKey',
      'nom_fr'     => 'Text',
      'nom_en'     => 'Text',
      'ordre'      => 'Number',
      'cadavre_fr' => 'Text',
      'cadavre_en' => 'Text',
      'image'      => 'Text',
    );
  }
}
