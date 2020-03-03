<?php

require_once dirname(__FILE__) . '/DatabaseManager.php';
require_once dirname(__FILE__) . '/DatabaseHelper.php';
require_once dirname(__FILE__) . '/helpers/IOFunctions.php';
require_once dirname(__FILE__) . '/helpers/SuperEightFestivalsFunctions.php';
require_once dirname(__FILE__) . '/helpers/ImageFunctions.php';

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
        'define_routes', // to add our custom routes
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
        // create directories
        create_plugin_directories();

        // Create tables
        $this->databaseHelper->createTables();

        // add example data
        add_country("Example Country");
        add_city_by_country_name("example country", "example city", 0, 0);

        add_contributor("example", "person", "my cool org", "email@domain.ext");
    }

    public function hookInitialize()
    {
    }

    function hookUninstall()
    {
        // Drop tables
        $this->databaseHelper->dropTables();

        // delete files
        delete_plugin_directories();
    }

    public function filterAdminNavigationMain($nav)
    {
        $nav[] = array(
            'label' => __('Super 8 Festivals'),
            'uri' => url('super-eight-festivals'),
        );
        return $nav;
    }

    function addRoute($router, $routeID, $route, $controller, $id = null)
    {
        $router->addRoute(
            $routeID,
            new Zend_Controller_Router_Route(
                $route,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controller,
                    'id' => $id,
                )
            )
        );
    }

    function addRecordRoute($router, $recordNameSingular, $recordNamePlural, $fullRoute, $parameterName)
    {
        $router->addRoute($recordNamePlural, new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "index"
                ))
        );
        $router->addRoute($recordNameSingular . "_single", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "single"
                ))
        );
        $router->addRoute($recordNameSingular . "_add", new Zend_Controller_Router_Route(
                "$fullRoute/add",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "add"
                ))
        );
        $router->addRoute($recordNameSingular . "_edit", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName/edit",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "edit"
                ))
        );
        $router->addRoute($recordNameSingular . "_delete", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName/delete",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "delete"
                ))
        );
    }

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
            $this->addRecordRoute($router, "country", "countries", ":module/countries", "countryName");
            $this->addRecordRoute($router, "city", "cities", ":module/countries/:countryName/cities", "cityName");
            $this->addRecordRoute($router, "banner", "banners", ":module/countries/:countryName/banners", "bannerID");
        } else {
            // override search
            $this->addRoute($router, 'search', 'search', 'search');

            $this->addRoute($router, 'about', 'about', 'about');
            $this->addRoute($router, 'contact', 'contact', 'contact');
            $this->addRoute($router, 'submit', 'submit', 'submit');

            $this->addRoute($router, 'federation', 'federation', 'federation');
            $this->addRoute($router, 'history', 'history', 'history');
            $this->addRoute($router, 'filmmakers', 'filmmakers', 'filmmakers');

            $this->addRoute($router, 'countries', 'countries', 'countries-list');

            // country routes
            $countries = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
            foreach ($countries as $country) {
                $this->addRoute($router, 'super_eight_festivals_country_' . $country->id, "countries/" . str_replace(" ", "-", strtolower($country->name)), 'country', $country->id);
            }
        }
    }

}