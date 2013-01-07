<?php

/**
 * Wishlist filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWishlistFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'      => new sfWidgetFormFilterInput(),
      'ilevel_min'       => new sfWidgetFormFilterInput(),
      'ilevel_max'       => new sfWidgetFormFilterInput(),
      'id_perso'         => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => true)),
      'id_type_wishlist' => new sfWidgetFormPropelChoice(array('model' => 'TypeWishlist', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'              => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'ilevel_min'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ilevel_max'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'id_perso'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Perso', 'column' => 'id_perso')),
      'id_type_wishlist' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'TypeWishlist', 'column' => 'id_type_wishlist')),
    ));

    $this->widgetSchema->setNameFormat('wishlist_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Wishlist';
  }

  public function getFields()
  {
    return array(
      'id_wishlist'      => 'Number',
      'nom'              => 'Text',
      'description'      => 'Text',
      'ilevel_min'       => 'Number',
      'ilevel_max'       => 'Number',
      'id_perso'         => 'ForeignKey',
      'id_type_wishlist' => 'ForeignKey',
    );
  }
}
