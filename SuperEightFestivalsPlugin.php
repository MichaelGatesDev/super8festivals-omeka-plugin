<?php

require_once dirname(__FILE__) . '/DatabaseManager.php';
require_once dirname(__FILE__) . '/DatabaseHelper.php';

class SuperEightFestivalsPlugin extends Omeka_Plugin_AbstractPlugin
{
    /**
     * @var DatabaseManager|null For all operations related to the database
     */
    private $databaseHelper = null;

    protected $_hooks = array(
        'install', // when the plugin is installed
        'uninstall', // when the plugin is uninstalled
        'initialize', // when the plugin starts up
    );
    protected $_filters = array(
        'admin_navigation_main', // admin sidebar
    );
    protected $_options = array();


    public function __construct()
    {
        $this->databaseHelper = new DatabaseHelper(new DatabaseManager());
    }

    public function hookInstall()
    {
        // Create tables
        $this->databaseHelper->createTables();

        // Save an example country.
        $country = new SuperEightFestivalsCountry();
        $country->name = "Test Country";
        $country->latitude = -1.337;
        $country->longitude = -1.337;
        $country->save();

        // Save an example page.
        $city = new SuperEightFestivalsCity();
        $city->name = "Test City";
        $city->latitude = -1.337;
        $city->longitude = -1.337;
        $city->country_id = $country->id;
        $city->save();
    }

    public function hookInitialize()
    {
    }

    function hookUninstall()
    {
        // Drop tables
        $this->databaseHelper->dropTables();
    }

    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Super 8 Festivals'),
            'uri' => url('super-eight-festivals'),
        );
        return $nav;
    }
}

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}