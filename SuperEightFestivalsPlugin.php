<?php

require_once dirname(__FILE__) . '/DatabaseManager.php';
require_once dirname(__FILE__) . '/DatabaseHelper.php';
require_once dirname(__FILE__) . '/helpers/SuperEightFestivalsFunctions.php';

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
        'public_navigation_main', // main navbar
        'public_navigation_items', // main navbar items
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
        // Create missing tables
        $this->databaseHelper->createTables();
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

    public function filterPublicNavigationMain($nav)
    {
        $nav = array();
        $nav[] = array(
            'label' => 'Home',
            'uri' => url('/')
        );
        $nav[] = array(
            'label' => 'About',
            'uri' => url('/about')
        );
        $nav[] = array(
            'label' => 'Contact',
            'uri' => url('/contact')
        );
        $nav[] = array(
            'label' => 'Submit',
            'uri' => url('/submit')
        );

        // simple pages
        $pages = get_db()->getTable('SimplePagesPage')->findAll();
        foreach ($pages as $page) {
            if (!$page->is_published) continue; // don't show hidden pages
            $nav[] = array(
                'label' => $page->title,
                'uri' => url($page->slug)
            );
        }

        return $nav;
    }

    function hookDefineRoutes($args)
    {
        // Don't add these routes on the admin side to avoid conflicts.
        if (is_admin_theme()) return;

        $router = $args['router'];
        $router->addRoute(
            'about',
            new Zend_Controller_Router_Route(
                "about",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'about',
                )
            )
        );
        $router->addRoute(
            'contact',
            new Zend_Controller_Router_Route(
                "contact",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'contact',
                )
            )
        );
        $router->addRoute(
            'submit',
            new Zend_Controller_Router_Route(
                "submit",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'submit',
                )
            )
        );


        // federation route
        $router->addRoute(
            'federation',
            new Zend_Controller_Router_Route(
                "federation",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'federation',
                )
            )
        );

        // filmmakers route
        $router->addRoute(
            'filmmakers',
            new Zend_Controller_Router_Route(
                "filmmakers",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'filmmakers',
                )
            )
        );

        // countries [list] route
        $router->addRoute(
            'countries',
            new Zend_Controller_Router_Route(
                "countries",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => 'countries-list',
                )
            )
        );

        // country routes
        $countries = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
        foreach ($countries as $country) {
            $router->addRoute(
                'super_eight_festivals_country_' . $country->id,
                new Zend_Controller_Router_Route(
                    "countries/" . str_replace(" ", "-", strtolower($country->name)),
                    array(
                        'module' => 'super-eight-festivals',
                        'controller' => 'country',
                        'id' => $country->id,
                    )
                )
            );
        }


    }

    function filterPublicNavigationItems($navArray)
    {
//        $navArray[] = array('label' => __('My Plugin Items'),
//            'uri' => url('myplugin/items')
//        );
        return $navArray;
    }
}