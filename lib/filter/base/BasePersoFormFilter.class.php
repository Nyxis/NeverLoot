<?php

/**
 * Perso filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePersoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_main'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'id_compte' => new sfWidgetFormPropelChoice(array('model' => 'Compte', 'add_empty' => true)),
      'id_classe' => new sfWidgetFormPropelChoice(array('model' => 'Classe', 'add_empty' => true)),
      'id_spe1'   => new sfWidgetFormPropelChoice(array('model' => 'Spe', 'add_empty' => true)),
      'id_spe2'   => new sfWidgetFormPropelChoice(array('model' => 'Spe', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'       => new sfValidatorPass(array('required' => false)),
      'is_main'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'id_compte' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Compte', 'column' => 'id_compte')),
      'id_classe' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Classe', 'column' => 'id_classe')),
      'id_spe1'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Spe', 'column' => 'id_spe')),
      'id_spe2'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Spe', 'column' => 'id_spe')),
    ));

    $this->widgetSchema->setNameFormat('perso_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Perso';
  }

  public function getFields()
  {
    return array(
      'id_perso'  => 'Number',
      'nom'       => 'Text',
      'is_main'   => 'Boolean',
      'id_compte' => 'ForeignKey',
      'id_classe' => 'ForeignKey',
      'id_spe1'   => 'ForeignKey',
      'id_spe2'   => 'ForeignKey',
    );
  }
}
