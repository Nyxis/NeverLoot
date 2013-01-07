<?php

/**
 * Soiree filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSoireeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'nom'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gain'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'etat'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_raid'     => new sfWidgetFormPropelChoice(array('model' => 'Raid', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'nom'         => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'gain'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'etat'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_raid'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Raid', 'column' => 'id_raid')),
    ));

    $this->widgetSchema->setNameFormat('soiree_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Soiree';
  }

  public function getFields()
  {
    return array(
      'id_soiree'   => 'Number',
      'date'        => 'Date',
      'nom'         => 'Text',
      'description' => 'Text',
      'gain'        => 'Number',
      'etat'        => 'Number',
      'id_raid'     => 'ForeignKey',
    );
  }
}
