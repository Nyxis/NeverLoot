<?php

/**
 * RefStatutPerso filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRefStatutPersoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'libelle'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'coef'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'code'                => new sfValidatorPass(array('required' => false)),
      'libelle'             => new sfValidatorPass(array('required' => false)),
      'coef'                => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'image'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ref_statut_perso_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RefStatutPerso';
  }

  public function getFields()
  {
    return array(
      'id_ref_statut_perso' => 'Number',
      'code'                => 'Text',
      'libelle'             => 'Text',
      'coef'                => 'Number',
      'image'               => 'Text',
    );
  }
}
