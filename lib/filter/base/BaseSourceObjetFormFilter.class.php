<?php

/**
 * SourceObjet filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSourceObjetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_type'         => new sfWidgetFormFilterInput(),
      'code'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'type'            => new sfValidatorPass(array('required' => false)),
      'id_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'code'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('source_objet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SourceObjet';
  }

  public function getFields()
  {
    return array(
      'id_source_objet' => 'Number',
      'type'            => 'Text',
      'id_type'         => 'Number',
      'code'            => 'Text',
    );
  }
}
