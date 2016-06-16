<?php

class Meanbee_HomePagePerTheme_Model_Observer_HomePagePerTheme extends Varien_Event_Observer
{
    /**
     * @var Meanbee_HomePagePerTheme_Helper_Config
     */
    protected $helper;

    public function _construct()
    {
        parent::_construct();

        $this->helper = Mage::helper('meanbee_homepagepertheme/config');
    }

    /**
     *
     * @param Varien_Event_Observer $observer
     */
    public function run($observer)
    {
        /** @var Mage_Core_Controller_Front_Action $controller */
        $controller = $observer->getEvent()->getData('controller_action');

        /** @var Mage_Cms_Model_Page $homepageForCurrentTheme */
        if ($homepageForCurrentTheme = $this->helper->getHomepage()) {
            $controller->setFlag('', $controller::FLAG_NO_DISPATCH, true);

            /** @var Mage_Core_Controller_Request_Http $request */
            $request = $controller->getRequest();
            $request
                ->initForward()
                ->setParam('page_id', $homepageForCurrentTheme->getData('page_id'))
                ->setControllerName('page')
                ->setActionName('view')
                ->setDispatched(false);
        }
    }
}
