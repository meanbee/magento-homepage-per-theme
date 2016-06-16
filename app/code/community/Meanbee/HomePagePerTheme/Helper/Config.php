<?php

class Meanbee_HomePagePerTheme_Helper_Config extends Mage_Core_Helper_Abstract
{
    const XML_PATH_HOMEPAGE_PER_THEME = 'web/default/cms_home_page_per_theme';

    /**
     * Return the map of home pages to themes.
     *
     * @param int|Mage_Core_Model_Store $store
     *
     * @return array
     */
    public function getHomepagePerThemeMappings($store = null)
    {
        $map = unserialize(Mage::getStoreConfig(static::XML_PATH_HOMEPAGE_PER_THEME, $store));

        return (is_array($map)) ? $map : array();
    }

    /**
     * Get custom homepage if set for a theme.
     *
     *
     * @param null $packageTheme - package/theme or uses current theme by default
     * @return null|Mage_Cms_Model_Page - Homepage key if custom one set otherwise null.
     */
    public function getHomepage($packageTheme = null)
    {
        $homepagePerThemeMappings = $this->getHomepagePerThemeMappings();

        if (is_null($packageTheme)) {
            $design = Mage::getDesign();
            $currentPackage = $design->getPackageName();
            $currentTheme = $design->getTheme('default') ? $design->getTheme('default') : $design::DEFAULT_THEME;
            $packageTheme = $currentPackage . '/' . $currentTheme;
        }

        foreach ($homepagePerThemeMappings as $homepageTheme) {
            if ($homepageTheme[Meanbee_HomePagePerTheme_Block_Adminhtml_Form_Field_ThemeHomePageMappings::THEMES_COLUMN_NAME]
                == $packageTheme
            ) {

                $id = $homepageTheme[Meanbee_HomePagePerTheme_Block_Adminhtml_Form_Field_ThemeHomePageMappings::PAGES_COLUMN_NAME];

                if ($page = Mage::getModel('cms/page')->load($id, 'identifier')) {
                    return $page;
                }
            }
        }

        return null;
    }
}
