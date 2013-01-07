<?php

/**
 * TypeWishlist filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTypeWishlistFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ordre'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'libelle'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'code'             => new sfValidatorPass(array('required' => false)),
      'ordre'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'libelle'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('type_wishlist_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TypeWishlist';
  }

  public function getFields()
  {
    return array(
      'id_type_wishlist' => 'Number',
      'code'             => 'Text',
      'ordre'            => 'Number',
      'libelle'          => 'Text',
    );
  }
}
