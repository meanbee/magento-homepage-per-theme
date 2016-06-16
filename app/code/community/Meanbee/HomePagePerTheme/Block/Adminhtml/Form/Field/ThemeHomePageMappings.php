<?php

class Meanbee_HomePagePerTheme_Block_Adminhtml_Form_Field_ThemeHomePageMappings extends
    Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{

    const THEMES_COLUMN_NAME = "themes";
    const PAGES_COLUMN_NAME = "pages";

    /**
     * @var Mage_Adminhtml_Block_Html_Select
     */
    protected $themesRenderer;

    /**
     * @var Mage_Adminhtml_Block_Html_Select
     */
    protected $pageRenderer;

    protected function _prepareToRender()
    {
        /** @var Meanbee_HomePagePerTheme_Helper_Data $helper */
        $helper = Mage::helper('meanbee_homepagepertheme');

        $this->addColumn(static::THEMES_COLUMN_NAME, array(
            'label' => $helper->__('Theme'),
            'renderer' => $this->getThemeRenderer()
        ));
        $this->addColumn(static::PAGES_COLUMN_NAME, array(
            'label' => $helper->__('CMS Home Page'),
            'renderer' => $this->getCMSPageRenderer()
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = $helper->__('Add Home Page');
    }

    /**
     * Set current option on themes and pages dropdown.
     *
     * @param Varien_Object $row
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        $themeData = $row->getData(static::THEMES_COLUMN_NAME);
        $row->setData(
            'option_extra_attr_' . $this->getThemeRenderer()->calcOptionHash($themeData),
            'selected="selected"'
        );

        $pagesData = $row->getData(static::PAGES_COLUMN_NAME);
        $row->setData(
            'option_extra_attr_' . $this->getCMSPageRenderer()->calcOptionHash($pagesData),
            'selected="selected"'
        );
    }

    /**
     * Return a block to render the select element for Themes.
     *
     * @return Mage_Adminhtml_Block_Html_Select
     */
    protected function getThemeRenderer()
    {
        if (!$this->themesRenderer) {
            /** @var Mage_Core_Block_Html_Select $renderer */
            $renderer = $this->getLayout()->createBlock('meanbee_homepagepertheme/adminhtml_form_field_html_select', '', array(
                'is_render_to_js_template' => true
            ));

            $themeOptionsArray = Mage::getSingleton('core/design_source_design')
                ->getAllOptions();
            $renderer->setOptions($themeOptionsArray);
            $renderer->setExtraParams('style="width:120px"');

            $this->themesRenderer = $renderer;
        }

        return $this->themesRenderer;
    }

    /**
     * Return a block to render the select element for CMS Pages.
     *
     * @return Mage_Adminhtml_Block_Html_Select
     */
    protected function getCMSPageRenderer()
    {
        if (!$this->pageRenderer) {
            /** @var Mage_Core_Block_Html_Select $renderer */
            $renderer = $this->getLayout()->createBlock('meanbee_homepagepertheme/adminhtml_form_field_html_select', '', array(
                'is_render_to_js_template' => true
            ));

            $pageOptionsArray = Mage::getSingleton('adminhtml/system_config_source_cms_page')
                ->toOptionArray();

            $renderer->setOptions($pageOptionsArray);
            $renderer->setExtraParams('style="width:120px"');

            $this->pageRenderer= $renderer;
        }

        return $this->pageRenderer;
    }
}
