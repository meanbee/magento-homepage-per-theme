<?php

/**
 * We need a custom select class when using in array configuration forms
 * because setInputName is called on a renderer.  We actually want this value
 * on the name data attribute.
 *
 * Class Meanbee_HomePagePerTheme_Block_Adminhtml_Form_Field_Html_Select
 */
class Meanbee_HomePagePerTheme_Block_Adminhtml_Form_Field_Html_Select
    extends Mage_Adminhtml_Block_Html_Select
{

    /**
     * @param $value
     * @return mixed
     */
    public function setInputName($value) {
        return $this->setName($value);
    }
}