<?php

/**
 * SoireeBoss filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSoireeBossFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_boss'        => new sfWidgetFormPropelChoice(array('model' => 'Boss', 'add_empty' => true)),
      'id_soiree'      => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => true)),
      'dead'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'id_boss'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Boss', 'column' => 'id_boss')),
      'id_soiree'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Soiree', 'column' => 'id_soiree')),
      'dead'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('soiree_boss_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SoireeBoss';
  }

  public function getFields()
  {
    return array(
      'id_soiree_boss' => 'Number',
      'id_boss'        => 'ForeignKey',
      'id_soiree'      => 'ForeignKey',
      'dead'           => 'Boolean',
    );
  }
}
