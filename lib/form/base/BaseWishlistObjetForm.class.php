<?php

/**
 * WishlistObjet form base class.
 *
 * @method WishlistObjet getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWishlistObjetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_wishlist_objet' => new sfWidgetFormInputHidden(),
      'id_wishlist'       => new sfWidgetFormPropelChoice(array('model' => 'Wishlist', 'add_empty' => false)),
      'id_slot'           => new sfWidgetFormPropelChoice(array('model' => 'Slot', 'add_empty' => false)),
      'id_attribution'    => new sfWidgetFormPropelChoice(array('model' => 'Attribution', 'add_empty' => true)),
      'id_objet'          => new sfWidgetFormPropelChoice(array('model' => 'Objet', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id_wishlist_objet' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdWishlistObjet()), 'empty_value' => $this->getObject()->getIdWishlistObjet(), 'required' => false)),
      'id_wishlist'       => new sfValidatorPropelChoice(array('model' => 'Wishlist', 'column' => 'id_wishlist')),
      'id_slot'           => new sfValidatorPropelChoice(array('model' => 'Slot', 'column' => 'id_slot')),
      'id_attribution'    => new sfValidatorPropelChoice(array('model' => 'Attribution', 'column' => 'id_attribution', 'required' => false)),
      'id_objet'          => new sfValidatorPropelChoice(array('model' => 'Objet', 'column' => 'id_objet', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('wishlist_objet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'WishlistObjet';
  }

}
