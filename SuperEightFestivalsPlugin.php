<?php

ini_set('max_execution_time', 0);

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
                    $country = new SuperEightFestivalsCountry();
                    $country->name = $countryName;
                    $country->latitude = $lat;
                    $country->longitude = $long;
                    $country->save();
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
                    $city = new SuperEightFestivalsCity();
                    $country = SuperEightFestivalsCountry::get_by_name($countryName);
                    if (!$country) {
                        logger_log(LogLevel::Error, "Failed to add city: no country found with name '${countryName}'");
                        continue;
                    }
                    $city->country_id = $country->id;
                    $city->name = $cityName;
                    $city->latitude = $lat;
                    $city->longitude = $long;
                    $city->save();
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
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-modal.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-alerts-area.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-table.js'></script>\n";

        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/modals/country-modal.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/modals/city-modal.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/modals/festival-modal.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-countries-table.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-cities-table.js'></script>\n";
        echo "<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-festivals-table.js'></script>\n";
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


    function addRecordRoute($router, $routeID, $controllerName, $fullRoute, $urlParam)
    {
        $router->addRoute("super_eight_festivals_" . $controllerName, new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "index"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_single", new Zend_Controller_Router_Route(
                "$fullRoute/:$urlParam",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "single"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_add", new Zend_Controller_Router_Route(
                "$fullRoute/add/",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "add"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_edit", new Zend_Controller_Router_Route(
                "$fullRoute/:$urlParam/edit/",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "edit"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_delete", new Zend_Controller_Router_Route(
                "$fullRoute/:$urlParam/delete/",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "delete"
                ))
        );
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

    function add_api_route($router, $id, $fullRoute, $action)
    {
        $router->addRoute(
            $id,
            new Zend_Controller_Router_Route(
                $fullRoute,
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => "api",
                    "action" => $action,
                )
            )
        );
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

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
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
            $this->add_route($router, ":module/countries/:country/cities/:city/banners/:banner/", "admin-country-city-banners", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/banners/:banner/edit/", "admin-country-city-banners", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/banners/:banner/delete/", "admin-country-city-banners", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/banners/add/", "admin-country-city-banners", "add");
            // Route: /countries/[country]/cities/[city]/festivals/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/", "admin-country-city-festivals", "index");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/", "admin-country-city-festivals", "single");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/film-catalogs/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs/", "admin-country-city-festival-film-catalogs", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs/:filmCatalogID/", "admin-country-city-festival-film-catalogs", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs/:filmCatalogID/edit/", "admin-country-city-festival-film-catalogs", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs/:filmCatalogID/delete/", "admin-country-city-festival-film-catalogs", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs/add/", "admin-country-city-festival-film-catalogs", "add");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/films/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/films/", "admin-country-city-festival-films", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/films/:filmID/", "admin-country-city-festival-films", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/films/:filmID/edit/", "admin-country-city-festival-films", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/films/:filmID/delete/", "admin-country-city-festival-films", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/films/add/", "admin-country-city-festival-films", "add");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/memorabilia/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia/", "admin-country-city-festival-memorabilia", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia/:memorabiliaID/", "admin-country-city-festival-memorabilia", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia/:memorabiliaID/edit/", "admin-country-city-festival-memorabilia", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia/:memorabiliaID/delete/", "admin-country-city-festival-memorabilia", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia/add/", "admin-country-city-festival-memorabilia", "add");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/print-media/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/print-media/", "admin-country-city-festival-print-media", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/print-media/:printMediaID/", "admin-country-city-festival-print-media", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/print-media/:printMediaID/edit/", "admin-country-city-festival-print-media", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/print-media/:printMediaID/delete/", "admin-country-city-festival-print-media", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/print-media/add/", "admin-country-city-festival-print-media", "add");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/photos/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/photos/", "admin-country-city-festival-photos", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/photos/:photoID/", "admin-country-city-festival-photos", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/photos/:photoID/edit/", "admin-country-city-festival-photos", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/photos/:photoID/delete/", "admin-country-city-festival-photos", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/photos/add/", "admin-country-city-festival-photos", "add");
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/posters/
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/posters/", "admin-country-city-festival-posters", "index");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/posters/:posterID/", "admin-country-city-festival-posters", "single");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/posters/:posterID/edit/", "admin-country-city-festival-posters", "edit");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/posters/:posterID/delete/", "admin-country-city-festival-posters", "delete");
            $this->add_route($router, ":module/countries/:country/cities/:city/festivals/:festivalID/posters/add/", "admin-country-city-festival-posters", "add");

            // Route: /filmmakers/
            $this->add_route($router, ":module/filmmakers/", "admin-filmmakers", "index");
            $this->add_route($router, ":module/filmmakers/:filmmakerID/", "admin-filmmakers", "single");
            $this->add_route($router, ":module/filmmakers/:filmmakerID/edit/", "admin-filmmakers", "edit");
            $this->add_route($router, ":module/filmmakers/:filmmakerID/delete/", "admin-filmmakers", "delete");
            $this->add_route($router, ":module/filmmakers/add/", "admin-filmmakers", "add");

            // TODO move these
//            $this->addRecordRoute($router, "filmmaker_photos", "filmmaker-photos", ":module/countries/:country/cities/:city/filmmakers/:filmmakerID/photos", "filmmakerPhotoID");

//            $this->add_static_route($router, "federation", ":module/federation", "federation", true);
//            $this->addRecordRoute($router, "federation_newsletter", "federation-newsletters", ":module/federation/newsletters", "newsletterID");
//            $this->addRecordRoute($router, "federation_photo", "federation-photos", ":module/federation/photos", "photoID");
//            $this->addRecordRoute($router, "federation_magazine", "federation-magazines", ":module/federation/magazines", "magazineID");
//            $this->addRecordRoute($router, "federation_bylaw", "federation-bylaws", ":module/federation/bylaws", "bylawID");
//
//            $this->add_static_route($router, "debug", ":module/debug", "debug", true);
//            $this->add_static_route($router, "debug_purge_all", ":module/debug/purge/all", "debug-purge-all", true);
//            $this->add_static_route($router, "debug_purge_unused", ":module/debug/purge/unused", "debug-purge-unused", true);
//            $this->add_static_route($router, "debug_create_tables", ":module/debug/create-tables", "debug-create-tables", true);
//            $this->add_static_route($router, "debug_create_missing_columns", ":module/debug/create-missing-columns", "debug-create-missing-columns", true);
//            $this->add_static_route($router, "debug_create_directories", ":module/debug/create-directories", "debug-create-directories", true);
//            $this->add_static_route($router, "debug_generate_missing_thumbnails", ":module/debug/generate-missing-thumbnails", "debug-generate-missing-thumbnails", true);
//            $this->add_static_route($router, "debug_regenerate_all_thumbnails", ":module/debug/regenerate-all-thumbnails", "debug-regenerate-all-thumbnails", true);
//            $this->add_static_route($router, "debug_delete_all_thumbnails", ":module/debug/delete-all-thumbnails", "debug-delete-all-thumbnails", true);
//            $this->add_static_route($router, "debug_fix_festivals", ":module/debug/fix-festivals", "debug-fix-festivals", true);
//            $this->add_static_route($router, "debug_relocate_files", ":module/debug/relocate-files", "debug-relocate-files", true);
//
//            $this->addRecordRoute($router, "staff", "staff", ":module/staff", "staffID");
//            $this->addRecordRoute($router, "contributor", "contributors", ":module/contributors", "contributorID");


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
        $this->add_api_route($router, "api_index", "/rest-api/", "index");
        // users
        $this->add_api_route($router, "api_users_all", "/rest-api/users/", "all-users");
        $this->add_api_route($router, "api_users_single", "/rest-api/users/:user/", "single-user");
        $this->add_api_route($router, "api_users_add", "/rest-api/users/add/", "add-user");
        // countries
        $this->add_api_route($router, "api_countries_all", "/rest-api/countries/", "all-countries");
        $this->add_api_route($router, "api_countries_single", "/rest-api/countries/:country/", "single-country");
        $this->add_api_route($router, "api_countries_add", "/rest-api/countries/add/", "add-country");
        // cities
        $this->add_api_route($router, "api_cities_all", "/rest-api/cities/", "all-cities");
        $this->add_api_route($router, "api_cities_single", "/rest-api/cities/:city/", "single-city");
        $this->add_api_route($router, "api_country_cities_all", "/rest-api/countries/:country/cities/", "country-all-cities");
        $this->add_api_route($router, "api_country_cities_single", "/rest-api/countries/:country/cities/:city/", "country-single-city");
        $this->add_api_route($router, "api_country_cities_add", "/rest-api/countries/:country/cities/add/", "country-add-city");
        // festivals
        $this->add_api_route($router, "api_festivals_all", "/rest-api/festivals/", "all-festivals");
        $this->add_api_route($router, "api_festivals_single", "/rest-api/festivals/:festival/", "single-festival");
        $this->add_api_route($router, "api_city_festivals_all", "/rest-api/cities/:city/festivals/", "city-all-festivals");
        $this->add_api_route($router, "api_city_festivals_single", "/rest-api/cities/:city/festivals/:festival/", "city-single-festival");
        $this->add_api_route($router, "api_city_festivals_add", "/rest-api/cities/:city/festivals/add/", "city-add-festival");
        $this->add_api_route($router, "api_country_city_festivals_all", "/rest-api/countries/:country/cities/:city/festivals/", "country-city-all-festivals");
        $this->add_api_route($router, "api_country_city_festivals_single", "/rest-api/countries/:country/cities/:city/festivals/:festival/", "country-city-single-festival");
        $this->add_api_route($router, "api_country_city_festivals_add", "/rest-api/countries/:country/cities/:city/festivals/add/ ", "country-city-add-festival");
    }

}