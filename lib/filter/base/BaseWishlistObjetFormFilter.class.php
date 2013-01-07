<?php

/**
 * WishlistObjet filter form base class.
 *
 * @package    NeverLoot
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseWishlistObjetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_wishlist'       => new sfWidgetFormPropelChoice(array('model' => 'Wishlist', 'add_empty' => true)),
      'id_slot'           => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => true)),
      'id_attribution'    => new sfWidgetFormPropelChoice(array('model' => 'Attribution', 'add_empty' => true)),
      'id_objet'          => new sfWidgetFormPropelChoice(array('model' => 'Objet', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_wishlist'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Wishlist', 'column' => 'id_wishlist')),
      'id_slot'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Slot', 'column' => 'id_slot')),
      'id_attribution'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Attribution', 'column' => 'id_attribution')),
      'id_objet'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Objet', 'column' => 'id_objet')),
    ));

    $this->widgetSchema->setNameFormat('wishlist_objet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WishlistObjet';
  }

  public function getFields()
  {
    return array(
      'id_wishlist_objet' => 'Number',
      'id_wishlist'       => 'ForeignKey',
      'id_slot'           => 'ForeignKey',
      'id_attribution'    => 'ForeignKey',
      'id_objet'          => 'ForeignKey',
    );
  }
}
