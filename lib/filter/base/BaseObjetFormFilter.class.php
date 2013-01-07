<?php

/**
 * Objet filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseObjetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ilevel'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'heroique'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nom_fr'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_en'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'classes'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'json_source'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_source_objet' => new sfWidgetFormPropelChoice(array('model' => 'SourceObjet', 'add_empty' => true)),
      'id_armor_type'   => new sfWidgetFormFilterInput(),
      'id_slot1'        => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => true)),
      'id_slot2'        => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'ilevel'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'heroique'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nom_fr'          => new sfValidatorPass(array('required' => false)),
      'nom_en'          => new sfValidatorPass(array('required' => false)),
      'image'           => new sfValidatorPass(array('required' => false)),
      'classes'         => new sfValidatorPass(array('required' => false)),
      'json_source'     => new sfValidatorPass(array('required' => false)),
      'id_source_objet' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SourceObjet', 'column' => 'id_source_objet')),
      'id_armor_type'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_slot1'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Slot', 'column' => 'id_slot')),
      'id_slot2'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Slot', 'column' => 'id_slot')),
    ));

    $this->widgetSchema->setNameFormat('objet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Objet';
  }

  public function getFields()
  {
    return array(
      'id_objet'        => 'Number',
      'ilevel'          => 'Number',
      'heroique'        => 'Boolean',
      'nom_fr'          => 'Text',
      'nom_en'          => 'Text',
      'image'           => 'Text',
      'classes'         => 'Text',
      'json_source'     => 'Text',
      'id_source_objet' => 'ForeignKey',
      'id_armor_type'   => 'Number',
      'id_slot1'        => 'ForeignKey',
      'id_slot2'        => 'ForeignKey',
    );
  }
}
