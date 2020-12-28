<?php

ini_set('max_execution_time', 0);

require_once dirname(__FILE__) . '/helpers/MigrationsHelper.php';
require_once dirname(__FILE__) . '/helpers/S8FLogger.php';
require_once dirname(__FILE__) . '/helpers/IOFunctions.php';
require_once dirname(__FILE__) . '/helpers/SuperEightFestivalsFunctions.php';
require_once dirname(__FILE__) . '/helpers/DBFunctions.php';
require_once dirname(__FILE__) . '/helpers/ControllersHelper.php';
require_once dirname(__FILE__) . '/helpers/CountryHelper.php';

class SuperEightFestivalsPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'install', // when the plugin is installed
        'uninstall', // when the plugin is uninstalled
        'initialize', // when the plugin starts up
        'define_routes', // to add our custom routes
        'admin_head', // override admin head to add custom modules
    );
    protected $_filters = array(
        'admin_navigation_main', // admin sidebar
        'public_navigation_main', // admin sidebar
    );
    protected $_options = array();

    public function hookInstall()
    {
        // create directories
        create_plugin_directories();

        // Setup database
        drop_tables(); // out with the old tables
        create_tables(); // in with the new tables

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
                list($countryName, $lat, $long) = explode(",", trim($result));
                try {
                    SuperEightFestivalsCountry::create([
                        "location" => [
                            "name" => $countryName,
                            "latitude" => $lat,
                            "longitude" => $long,
                        ],
                    ]);
                } catch (Throwable $e) {
                    logger_log(LogLevel::Error, "Failed to add country. " . $e->getMessage());
                }
            }
            fclose($fn);
        }

        $defaultCitiesFile = __DIR__ . "/__res/default-cities.txt";
        if (file_exists($defaultCitiesFile)) {
            $fn = fopen($defaultCitiesFile, "r");
            while (!feof($fn)) {
                $result = fgets($fn);
                list($countryName, $cityName, $lat, $long) = explode(",", trim($result));
                try {
                    $country = SuperEightFestivalsCountry::get_by_name($countryName);
                    if (!$country) throw new Error("No country exists with name: {$countryName}");
                    SuperEightFestivalsCity::create([
                        "country_id" => $country->id,
                        "location" => [
                            "name" => $cityName,
                            "description" => "",
                            "latitude" => $lat,
                            "longitude" => $long,
                        ],
                    ]);
                } catch (Throwable $e) {
                    logger_log(LogLevel::Error, "Failed to add city. " . $e->getMessage());
                }
            }
            fclose($fn);
        }
    }

    public function hookInitialize()
    {
    }

    function hookUninstall()
    {
        // Drop tables
        drop_tables();

        // delete files
        delete_plugin_directories();
    }

    function hookAdminHead()
    {
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
        $nav = array(
            array(
                'label' => 'About',
                'uri' => '/about',
            ),
            array(
                'label' => 'Federation',
                'uri' => '/federation',
            ),
            array(
                'label' => 'History',
                'uri' => '/federation#history',
            ),
            array(
                'label' => 'Filmmakers',
                'uri' => '/filmmakers',
            ),
            array(
                'label' => 'Festival Cities',
                'uri' => '/cities',
            ),
        );
        return $nav;
    }

    function id_from_route($route)
    {
        $route = str_replace("/", "_", $route);
        $route = str_replace(":", "", $route);
        if (preg_match('/_$/', $route)) $route = substr($route, 0, strlen($route) - 1);
        return $route;
    }

    function add_route($router, $route, $controller, $action)
    {
        $router->addRoute("s8f_" . $this->id_from_route($route), new Zend_Controller_Router_Route($route, array(
            'module' => 'super-eight-festivals',
            'controller' => $controller,
            'action' => $action
        )));
    }

    function add_api_route($router, $full_route, $action)
    {
        $this->add_route($router, $full_route, "api", $action);
    }

    function add_static_route($router, $id, $fullRoute, $action, $adminOnly)
    {
        $router->addRoute(
            $id,
            new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $adminOnly ? "admin" : "public",
                    "action" => $action,
                )
            )
        );
    }

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
            // Route: /staff/
            $this->add_route($router, ":module/staff/", "admin-staff", "index");
            $this->add_route($router, ":module/staff/:staff/", "admin-staff", "single");

            // Route: /contributor/
            $this->add_route($router, ":module/contributors/", "admin-contributors", "index");
            $this->add_route($router, ":module/contributors/:contributor/", "admin-contributors", "single");

            // Route: /countries/
            $this->add_route($router, ":module/countries/", "admin-countries", "index");
            // Route: /countries/[country]/
            $this->add_route($router, ":module/countries/:country/", "admin-countries", "single");
            // Route: /countries/[country]/cities/
            $this->add_route($router, ":module/countries/:country/cities/", "admin-country-cities", "index");
            // Route: /countries/[country]/cities/[city]/
            $this->add_route($router, ":module/countries/:country/cities/:city/", "admin-country-cities", "single");
            // Route: /countries/[country]/cities/[city]/banners/
            $this->add_route($router, ":module/countries/:country/cities/:city/banners/", "admin-country-city-banners", "index");
            // Route: /countries/[country]/cities/[city]/festivals/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/", "admin-country-city-festivals", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/", "admin-country-city-festivals", "single");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/film-catalogs/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/film-catalogs/", "admin-country-city-festival-film-catalogs", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/films/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/films/", "admin-country-city-festival-films", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/print-media/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/print-media/", "admin-country-city-festival-print-media", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/photos/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/photos/", "admin-country-city-festival-photos", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/posters/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festival/posters/", "admin-country-city-festival-posters", "index");

            // Route: /filmmakers/
            $this->add_route($router, ":module/filmmakers/", "admin-filmmakers", "index");
            // Route: /filmmakers/[filmmaker]/
            $this->add_route($router, ":module/filmmakers/:filmmakerID/", "admin-filmmakers", "single");
            $this->add_route($router, ":module/filmmakers/:filmmakerID/photos/", "admin-filmmaker-photos", "index");

            // Route: /federation/
            $this->add_route($router, ":module/federation/", "admin-federation", "index");
            $this->add_route($router, ":module/federation/newsletters/", "admin-federation-newsletters", "index");
            $this->add_route($router, ":module/federation/photos/", "admin-federation-photos", "index");
            $this->add_route($router, ":module/federation/magazines/", "admin-federation-magazines", "index");
            $this->add_route($router, ":module/federation/bylaws/", "admin-federation-bylaws", "index");

            // Route: /debug/
            $this->add_route($router, ":module/debug/", "admin-debug", "index");
            $this->add_route($router, ":module/debug/purge/all", "admin-debug", "debug-purge-all");
            $this->add_route($router, ":module/debug/purge/all", "admin-debug", "debug-purge-all");
            $this->add_route($router, ":module/debug/purge/unused", "admin-debug", "debug-purge-unused");
            $this->add_route($router, ":module/debug/create-tables", "admin-debug", "debug-create-tables");
            $this->add_route($router, ":module/debug/create-missing-columns", "admin-debug", "debug-create-missing-columns");
            $this->add_route($router, ":module/debug/create-directories", "admin-debug", "debug-create-directories");
            $this->add_route($router, ":module/debug/generate-missing-thumbnails", "admin-debug", "debug-generate-missing-thumbnails");
            $this->add_route($router, ":module/debug/regenerate-all-thumbnails", "admin-debug", "debug-regenerate-all-thumbnails");
            $this->add_route($router, ":module/debug/delete-all-thumbnails", "admin-debug", "debug-delete-all-thumbnails");
            $this->add_route($router, ":module/debug/fix-festivals", "admin-debug", "debug-fix-festivals");
            $this->add_route($router, ":module/debug/relocate-files", "admin-debug", "debug-relocate-files");

        } else {
//            $this->add_public_static_route($router, "index", "", "index"); // commented out because the theme should handle the index
            $this->add_static_route($router, "search", "search", "search", false);
            $this->add_static_route($router, "about", "about", "about", false);
            $this->add_static_route($router, "contact", "contact", "contact", false);
            $this->add_static_route($router, "submit", "submit", "submit", false);
            $this->add_static_route($router, "federation", "federation", "federation", false);
            $this->add_static_route($router, "cities", "cities", "cities", false);
            $this->add_static_route($router, "city", "cities/:city", "city", false);
            $this->add_static_route($router, "filmmakers", "filmmakers", "filmmakers", false);
            $this->add_static_route($router, "filmmaker", "filmmakers/:filmmakerID", "filmmaker", false);
        }

        // ADD API ROUTES
        $this->add_api_route($router, "/rest-api/", "index");
        // debug
        $this->add_api_route($router, "/rest-api/migrations/", "migrations");
        // users
        $this->add_api_route($router, "/rest-api/users/", "users");
        $this->add_api_route($router, "/rest-api/users/:user/", "user");
        // filmmakers
        $this->add_api_route($router, "/rest-api/filmmakers/", "filmmakers");
        $this->add_api_route($router, "/rest-api/filmmakers/:filmmaker/", "filmmaker");
        $this->add_api_route($router, "/rest-api/filmmakers/:filmmaker/films/", "filmmaker-films");
        $this->add_api_route($router, "/rest-api/filmmakers/:filmmaker/films/:film/", "filmmaker-film");
        $this->add_api_route($router, "/rest-api/filmmakers/:filmmaker/photos/", "filmmaker-photos");
        $this->add_api_route($router, "/rest-api/filmmakers/:filmmaker/photos/:photo/", "filmmaker-photo");
        // films
        $this->add_api_route($router, "/rest-api/films/", "films");
        // contributors
        $this->add_api_route($router, "/rest-api/contributors/", "contributors");
        $this->add_api_route($router, "/rest-api/contributors/:contributor/", "contributor");
        // staff
        $this->add_api_route($router, "/rest-api/staff/", "staffs");
        $this->add_api_route($router, "/rest-api/staff/:staff/", "staff");
        // cities
        $this->add_api_route($router, "/rest-api/cities/", "cities");
        $this->add_api_route($router, "/rest-api/cities/:city/", "city");
        $this->add_api_route($router, "/rest-api/cities/:city/festivals/", "city-festivals");
        // festivals
        $this->add_api_route($router, "/rest-api/festivals/", "festivals");
        $this->add_api_route($router, "/rest-api/festivals/:festival/", "festival");
        // federation
        $this->add_api_route($router, "/rest-api/federation/bylaws/", "federation-bylaws");
        $this->add_api_route($router, "/rest-api/federation/bylaws/:bylawID", "federation-bylaw");
        $this->add_api_route($router, "/rest-api/federation/magazines/", "federation-magazines");
        $this->add_api_route($router, "/rest-api/federation/magazines/:magazineID", "federation-magazine");
        $this->add_api_route($router, "/rest-api/federation/newsletters/", "federation-newsletters");
        $this->add_api_route($router, "/rest-api/federation/newsletters/:newsletterID", "federation-newsletter");
        $this->add_api_route($router, "/rest-api/federation/photos/", "federation-photos");
        $this->add_api_route($router, "/rest-api/federation/photos/:photoID", "federation-photo");
        // country hierarchy api routes
        $this->add_api_route($router, "/rest-api/countries/", "countries");
        $this->add_api_route($router, "/rest-api/countries/:country/", "country");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/", "country-cities");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/", "country-city");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/banner/", "country-city-banner");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/", "country-city-festivals");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/", "country-city-festival");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/films/", "country-city-festival-films");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/films/:filmID/", "country-city-festival-film");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/film-catalogs/", "country-city-festival-film-catalogs");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/film-catalogs/:filmCatalogID/", "country-city-festival-film-catalog");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/photos/", "country-city-festival-photos");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/photos/:photoID/", "country-city-festival-photo");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/posters/", "country-city-festival-posters");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/posters/:posterID/", "country-city-festival-poster");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/print-media/", "country-city-festival-print-media");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/festivals/:festival/print-media/:printMediaID/", "country-city-festival-print-medium");


        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/films/", "country-city-films");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/filmmakers/", "country-city-filmmakers");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/film-catalogs/", "country-city-film-catalogs");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/photos/", "country-city-photos");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/posters/", "country-city-posters");
        $this->add_api_route($router, "/rest-api/countries/:country/cities/:city/print-media/", "country-city-print-media");
    }

}