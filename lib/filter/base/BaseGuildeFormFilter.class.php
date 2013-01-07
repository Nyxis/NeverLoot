<?php

/**
 * Guilde filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseGuildeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_guilde' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom'       => new sfWidgetFormFilterInput(),
      'serveur'   => new sfWidgetFormFilterInput(),
      'site'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'id_guilde' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nom'       => new sfValidatorPass(array('required' => false)),
      'serveur'   => new sfValidatorPass(array('required' => false)),
      'site'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('guilde_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Guilde';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'id_guilde' => 'Number',
      'nom'       => 'Text',
      'serveur'   => 'Text',
      'site'      => 'Text',
    );
  }
}
