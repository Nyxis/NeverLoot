<?php

/**
 * PersoSoiree filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePersoSoireeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_perso'        => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => true)),
      'id_statut_perso' => new sfWidgetFormPropelChoice(array('model' => 'RefStatutPerso', 'add_empty' => true)),
      'id_statut_admin' => new sfWidgetFormPropelChoice(array('model' => 'RefStatutPerso', 'add_empty' => true)),
      'id_soiree'       => new sfWidgetFormPropelChoice(array('model' => 'Soiree', 'add_empty' => true)),
      'id_role'         => new sfWidgetFormPropelChoice(array('model' => 'Role', 'add_empty' => true)),
      'pts_soiree'      => new sfWidgetFormFilterInput(),
      'pts_loot'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_perso'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Perso', 'column' => 'id_perso')),
      'id_statut_perso' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RefStatutPerso', 'column' => 'id_ref_statut_perso')),
      'id_statut_admin' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'RefStatutPerso', 'column' => 'id_ref_statut_perso')),
      'id_soiree'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Soiree', 'column' => 'id_soiree')),
      'id_role'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Role', 'column' => 'id_role')),
      'pts_soiree'      => new sfValidatorPass(array('required' => false)),
      'pts_loot'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perso_soiree_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PersoSoiree';
  }

  public function getFields()
  {
    return array(
      'id_perso_soiree' => 'Number',
      'id_perso'        => 'ForeignKey',
      'id_statut_perso' => 'ForeignKey',
      'id_statut_admin' => 'ForeignKey',
      'id_soiree'       => 'ForeignKey',
      'id_role'         => 'ForeignKey',
      'pts_soiree'      => 'Text',
      'pts_loot'        => 'Text',
    );
  }
}
