<?php

/**
 * Slot filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSlotFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_slot'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'code_mrrobot' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'libelle'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'type_slot'    => new sfValidatorPass(array('required' => false)),
      'code_mrrobot' => new sfValidatorPass(array('required' => false)),
      'libelle'      => new sfValidatorPass(array('required' => false)),
      'image'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('slot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Slot';
  }

  public function getFields()
  {
    return array(
      'id_slot'      => 'Number',
      'type_slot'    => 'Text',
      'code_mrrobot' => 'Text',
      'libelle'      => 'Text',
      'image'        => 'Text',
    );
  }
}
