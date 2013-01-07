<?php

/**
 * Attribution filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseAttributionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tmp'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'prix'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_objet'       => new sfWidgetFormPropelChoice(array('model' => 'Objet', 'add_empty' => true)),
      'id_soiree'      => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => true)),
      'id_perso'       => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'tmp'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'prix'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'id_objet'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Objet', 'column' => 'id_objet')),
      'id_soiree'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Soiree', 'column' => 'id_soiree')),
      'id_perso'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Perso', 'column' => 'id_perso')),
    ));

    $this->widgetSchema->setNameFormat('attribution_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attribution';
  }

  public function getFields()
  {
    return array(
      'id_attribution' => 'Number',
      'tmp'            => 'Boolean',
      'prix'           => 'Number',
      'id_objet'       => 'ForeignKey',
      'id_soiree'      => 'ForeignKey',
      'id_perso'       => 'ForeignKey',
    );
  }
}
