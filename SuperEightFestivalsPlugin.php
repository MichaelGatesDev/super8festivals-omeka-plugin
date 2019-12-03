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

        // add countries
        add_country('argentina');
        add_country('australia');
        add_country('belgium');
        add_country('brazil');
        add_country('canada');
        add_country('colombia');
        add_country('germany');
        add_country('hong kong');
        add_country('iran');
        add_country('italy');
        add_country('japan');
        add_country('mexico');
        add_country('philippines');
        add_country('portugal');
        add_country('puerto rico');
        add_country('spain');
        add_country('tunisia');
        add_country('united states');
        add_country('venezuela');

        // add cities
        add_city('germany', 'berlin', 52.52000, 13.40500);
        add_city('argentina', 'rosario', -32.95870, -60.69300);
        add_city('australia', 'sydney', -33.86880, 151.20930);
        add_city('belgium', 'brussels', 50.85030, 4.35170);
        add_city('brazil', 'sao paulo', -23.55050, -46.63330);
        add_city('spain', 'barcelona', 41.38510, 2.17340);
        add_city('united states', 'chicago', 41.87810, -87.62980);
        add_city('colombia', 'bogota', 4.71100, -74.07210);
        add_city('philippines', 'manila', 14.59950, 120.98420);
        add_city('hong kong', 'hong kong', 22.31930, 114.16940);
        add_city('iran', 'tehran', 35.68920, 51.38900);
        add_city('japan', 'tokyo', 35.67620, 139.65030);
        add_city('japan', 'hiroshima', 34.38530, 132.45531);
        add_city('mexico', 'mexico city', 19.43260, -99.13320);
        add_city('italy', 'montecallini', 39.81840, 18.31290);
        add_city('portugal', 'lisbon', 38.72230, -9.13930);
        add_city('puerto rico', 'san juan', 18.46550, 66.10570);
        add_city('canada', 'montreal', 45.50170, -73.56730);
        add_city('canada', 'toronto', 43.65320, -79.38320);
        add_city('tunisia', 'kelibia', 36.84620, 11.09950);
        add_city('venezuela', 'caracas', 10.48060, -66.90360);


        //============================================================================\\
        //      BELGIUM - THIS IS ONLY TEMPORARY FOR SHOWCASE, WILL BE DYNAMIC SOON
        //============================================================================\\
        // add banner
        $belgiumBanner = new SuperEightFestivalsCountryBanner();
        $belgiumBanner->country_id = get_country_by_name('belgium')->id;
        $belgiumBanner->path = "/files/supereightfestivals/belgium/landing.jpg";
        $belgiumBanner->save();

        // add posters
        $posterA = new SuperEightFestivalsFestivalPoster();
        $posterA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $posterA->path = "/files/supereightfestivals/belgium/posters/aaa.jpg";
        $posterA->title = "Poster A";
        $posterA->description = "This is the description of Poster A.";
        $posterA->save();
        // add posters
        $posterB = new SuperEightFestivalsFestivalPoster();
        $posterB->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $posterB->path = "/files/supereightfestivals/belgium/posters/bbb.jpg";
        $posterB->title = "Poster B";
        $posterB->description = "This is the description of Poster B.";
        $posterB->save();
        // add posters
        $posterC = new SuperEightFestivalsFestivalPoster();
        $posterC->path = "/files/supereightfestivals/belgium/posters/ccc.jpg";
        $posterC->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $posterC->description = "This is the description of Poster C.";
        $posterC->title = "Poster C";
        $posterC->save();
    }

    public function hookInitialize()
    {
        // Create missing tables
//        $this->databaseHelper->createTables();
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

    function hookDefineRoutes($args)
    {
        // Don't add these routes on the admin side to avoid conflicts.
        if (is_admin_theme()) return;

        $router = $args['router'];

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

    function filterPublicNavigationItems($navArray)
    {
//        $navArray[] = array('label' => __('My Plugin Items'),
//            'uri' => url('myplugin/items')
//        );
        return $navArray;
    }


}