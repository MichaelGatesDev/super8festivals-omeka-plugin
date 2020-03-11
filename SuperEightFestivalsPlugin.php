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

        // sample data
//        $this->add_sample_data();
        // all defaults used in the website
        $this->add_default_data();
    }

    function add_default_data()
    {
        $defaultCountriesFile = __DIR__ . "/__res/default-countries.txt";
        if (file_exists($defaultCountriesFile)) {
            $fn = fopen($defaultCountriesFile, "r");
            while (!feof($fn)) {
                $result = fgets($fn);
                list($countryName, $lat, $long) = explode(",", $result);
                add_country($countryName, $lat, $long);
            }
            fclose($fn);
        }

        $defaultCitiesFile = __DIR__ . "/__res/default-cities.txt";
        if (file_exists($defaultCitiesFile)) {
            $fn = fopen($defaultCitiesFile, "r");
            while (!feof($fn)) {
                $result = fgets($fn);
                list($countryName, $cityName, $lat, $long) = explode(",", $result);
                add_city(get_country_by_name($countryName)->id, $cityName, $lat, $long);
            }
            fclose($fn);
        }
    }

    function add_sample_data()
    {
        // add country
        $country_a = add_country("Example Country");
        // add country banner
        copy(__DIR__ . "/__res/example-country-banner.jpg", $country_a->get_dir() . "/banner_default.jpg");
        add_country_banner($country_a->id, "banner_default.jpg");
        $city = add_city_by_country_name($country_a->name, "Lorem Ipsum", 0, 0);
        $city = add_city_by_country_name($country_a->name, "Dolor Sit Amet", 0, 0);

        add_contributor("example", "person", "my cool org", "email@domain.ext");
    }

    public function hookInitialize()
    {
        $countries = get_all_countries();
        foreach ($countries as $country) {
            $activeBanner = get_active_country_banner($country->id);
            if ($activeBanner == null) {
                $banners = get_country_banners($country->id);
                if (count($banners) > 0) {
                    $banners[0]->active = true;
                    $banners[0]->save();
                }
            }
        }
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
        $nav = array_filter($nav, function ($k) {
            $itemLabel = $k['label'];
            return !in_array(strtolower($itemLabel), array(
                "items",
                "collections",
                "item types",
                "items",
                "tags",
            ));
        });
        $nav[] = array(
            'label' => __('Super 8 Festivals'),
            'uri' => url('super-eight-festivals'),
        );
        return $nav;
    }

    function addRecordRoute($router, $recordNameSingular, $recordNamePlural, $fullRoute, $parameterName)
    {
        $router->addRoute("super_eight_festivals_" . $recordNamePlural, new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "index"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $recordNameSingular . "_single", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "single"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $recordNameSingular . "_add", new Zend_Controller_Router_Route(
                "$fullRoute/add",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "add"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $recordNameSingular . "_edit", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName/edit",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "edit"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $recordNameSingular . "_delete", new Zend_Controller_Router_Route(
                "$fullRoute/:$parameterName/delete",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $recordNamePlural,
                    'action' => "delete"
                ))
        );
    }

    function add_public_static_route($router, $id, $fullRoute, $action)
    {
        $router->addRoute(
            $id,
            new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => "public",
                    "action" => $action,
                )
            )
        );
    }

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
            $this->addRecordRoute($router, "contributor", "contributors", ":module/contributors", "contributorID");
            $this->addRecordRoute($router, "country", "countries", ":module/countries", "countryName");
            $this->addRecordRoute($router, "city", "cities", ":module/countries/:countryName/cities", "cityName");
            $this->addRecordRoute($router, "banner", "banners", ":module/countries/:countryName/banners", "bannerID");
            $this->addRecordRoute($router, "festival", "festivals", ":module/countries/:countryName/cities/:cityName/festivals", "festivalID");
            $this->addRecordRoute($router, "filmCatalog", "filmCatalogs", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/film-catalogs", "filmCatalogID");
            $this->addRecordRoute($router, "filmmaker", "filmmakers", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/filmmakers", "filmmakerID");
            $this->addRecordRoute($router, "film", "films", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/films", "filmID");
            $this->addRecordRoute($router, "memorabilia", "memorabilia", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/memorabilia", "memorabiliaID");
            $this->addRecordRoute($router, "printMedia", "printMedia", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/print-media", "printMediaID");
            $this->addRecordRoute($router, "photo", "photos", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/photos", "photoID");
            $this->addRecordRoute($router, "poster", "posters", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/posters", "posterID");
        } else {
//            $this->add_public_static_route($router, "index", "", "index"); // commented out because the theme should handle the index
            $this->add_public_static_route($router, "search", "search", "search");
            $this->add_public_static_route($router, "about", "about", "about");
            $this->add_public_static_route($router, "contact", "contact", "contact");
            $this->add_public_static_route($router, "submit", "submit", "submit");
            $this->add_public_static_route($router, "federation", "federation", "federation");
            $this->add_public_static_route($router, "history", "history", "history");
            $this->add_public_static_route($router, "filmmakers", "filmmakers", "filmmakers");
            $this->add_public_static_route($router, "countries", "countries", "countries");
            $this->add_public_static_route($router, "country", "countries/:countryName", "country");
            $this->add_public_static_route($router, "cities", "countries/:countryName/cities", "cities");
            $this->add_public_static_route($router, "city", "countries/:countryName/cities/:cityName", "city");
        }
    }

}