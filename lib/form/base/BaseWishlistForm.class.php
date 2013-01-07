<?php

/**
 * Wishlist form base class.
 *
 * @method Wishlist getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseWishlistForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_wishlist'      => new sfWidgetFormInputHidden(),
      'nom'              => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'ilevel_min'       => new sfWidgetFormInputText(),
      'ilevel_max'       => new sfWidgetFormInputText(),
      'id_perso'         => new sfWidgetFormPropelChoice(array('model' => 'Perso', 'add_empty' => false)),
      'id_type_wishlist' => new sfWidgetFormPropelChoice(array('model' => 'TypeWishlist', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id_wishlist'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdWishlist()), 'empty_value' => $this->getObject()->getIdWishlist(), 'required' => false)),
      'nom'              => new sfValidatorString(array('max_length' => 45)),
      'description'      => new sfValidatorString(array('required' => false)),
      'ilevel_min'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'ilevel_max'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_perso'         => new sfValidatorPropelChoice(array('model' => 'Perso', 'column' => 'id_perso')),
      'id_type_wishlist' => new sfValidatorPropelChoice(array('model' => 'TypeWishlist', 'column' => 'id_type_wishlist')),
    ));

    $this->widgetSchema->setNameFormat('wishlist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Wishlist';
  }

}
