<?php

/**
 * Spe filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSpeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'id_classe' => new sfWidgetFormPropelChoice(array('model' => 'Classe', 'add_empty' => true)),
      'id_role'   => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'       => new sfValidatorPass(array('required' => false)),
      'image'     => new sfValidatorPass(array('required' => false)),
      'id_classe' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Classe', 'column' => 'id_classe')),
      'id_role'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Role', 'column' => 'id_role')),
    ));

    $this->widgetSchema->setNameFormat('spe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Spe';
  }

  public function getFields()
  {
    return array(
      'id_spe'    => 'Number',
      'nom'       => 'Text',
      'image'     => 'Text',
      'id_classe' => 'ForeignKey',
      'id_role'   => 'ForeignKey',
    );
  }
}
