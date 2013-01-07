<?php

/**
 * TypeWishlist form base class.
 *
 * @method TypeWishlist getObject() Returns the current form's model object
 *
 * @package    NeverLoot
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTypeWishlistForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_type_wishlist' => new sfWidgetFormInputHidden(),
      'code'             => new sfWidgetFormInputText(),
      'ordre'            => new sfWidgetFormInputText(),
      'libelle'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_type_wishlist' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdTypeWishlist()), 'empty_value' => $this->getObject()->getIdTypeWishlist(), 'required' => false)),
      'code'             => new sfValidatorString(array('max_length' => 45)),
      'ordre'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'libelle'          => new sfValidatorString(array('max_length' => 45)),
    ));

    $this->widgetSchema->setNameFormat('type_wishlist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TypeWishlist';
  }

}
