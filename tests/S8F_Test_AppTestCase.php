<?php

class S8F_Test_AppTestCase extends Omeka_Test_AppTestCase
{
    const PLUGIN_NAME = 'SuperEightFestivals';

    protected $_isAdminTest = false;

    protected $_view;

    public function setUp(): void
    {
        parent::setUp();

        $this->_view = get_view();
//        $this->_view->addHelperPath(PLUGIN_DIR . '/SuperEightFestivals/views/helpers', self::PLUGIN_NAME . '_View_Helper_');

        $pluginHelper = new Omeka_Test_Helper_Plugin;
        $pluginHelper->setUp(self::PLUGIN_NAME);

        // Add constraints if derivatives have been added in the config file.
        $fileDerivatives = Zend_Registry::get('bootstrap')->getResource('Config')->fileDerivatives;
        if (!empty($fileDerivatives) && !empty($fileDerivatives->paths)) {
            foreach ($fileDerivatives->paths->toArray() as $type => $path) {
                set_option($type . '_constraint', 1);
            }
        }

        $this->_reloadRoutes();
    }

    protected function _reloadRoutes()
    {
        $plugin = new SuperEightFestivalsPlugin;
        $plugin->hookDefineRoutes(array('router' => Zend_Controller_Front::getInstance()->getRouter()));
    }
}
