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
                "$fullRoute/add",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "add"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_edit", new Zend_Controller_Router_Route(
                "$fullRoute/:$urlParam/edit",
                array(
                    'module' => 'super-eight-festivals',
                    'controller' => $controllerName,
                    'action' => "edit"
                ))
        );
        $router->addRoute("super_eight_festivals_" . $routeID . "_delete", new Zend_Controller_Router_Route(
                "$fullRoute/:$urlParam/delete",
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

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
            $this->add_static_route($router, "federation", ":module/federation", "federation", true);
            $this->addRecordRoute($router, "federation_newsletter", "federation-newsletters", ":module/federation/newsletters", "newsletterID");
            $this->addRecordRoute($router, "federation_photo", "federation-photos", ":module/federation/photos", "photoID");
            $this->addRecordRoute($router, "federation_magazine", "federation-magazines", ":module/federation/magazines", "magazineID");
            $this->addRecordRoute($router, "federation_bylaw", "federation-bylaws", ":module/federation/bylaws", "bylawID");

            $this->add_static_route($router, "debug", ":module/debug", "debug", true);
            $this->add_static_route($router, "debug_purge_all", ":module/debug/purge/all", "debug-purge-all", true);
            $this->add_static_route($router, "debug_purge_unused", ":module/debug/purge/unused", "debug-purge-unused", true);
            $this->add_static_route($router, "debug_create_tables", ":module/debug/create-tables", "debug-create-tables", true);
            $this->add_static_route($router, "debug_create_missing_columns", ":module/debug/create-missing-columns", "debug-create-missing-columns", true);
            $this->add_static_route($router, "debug_create_directories", ":module/debug/create-directories", "debug-create-directories", true);
            $this->add_static_route($router, "debug_generate_missing_thumbnails", ":module/debug/generate-missing-thumbnails", "debug-generate-missing-thumbnails", true);
            $this->add_static_route($router, "debug_regenerate_all_thumbnails", ":module/debug/regenerate-all-thumbnails", "debug-regenerate-all-thumbnails", true);
            $this->add_static_route($router, "debug_delete_all_thumbnails", ":module/debug/delete-all-thumbnails", "debug-delete-all-thumbnails", true);
            $this->add_static_route($router, "debug_fix_festivals", ":module/debug/fix-festivals", "debug-fix-festivals", true);
            $this->add_static_route($router, "debug_relocate_files", ":module/debug/relocate-files", "debug-relocate-files", true);

            $this->addRecordRoute($router, "staff", "staff", ":module/staff", "staffID");
            $this->addRecordRoute($router, "contributor", "contributors", ":module/contributors", "contributorID");


            // Route: /countries/
            $router->addRoute("s8f_admin_countries", new Zend_Controller_Router_Route(":module/countries/", array(
                'module' => 'super-eight-festivals',
                'controller' => "admin-countries",
                'action' => "index"
            )));
            // Route: /countries/[country]/
            $router->addRoute("s8f_admin_country", new Zend_Controller_Router_Route(":module/countries/:country", array(
                'module' => 'super-eight-festivals',
                'controller' => "admin-countries",
                'action' => "single"
            )));
            // Route: /countries/[country]/cities/
            $router->addRoute("s8f_admin_country_cities", new Zend_Controller_Router_Route(":module/countries/:country/cities/", array(
                'module' => 'super-eight-festivals',
                'controller' => "admin-country-cities",
                'action' => "index"
            )));
            // Route: /countries/[country]/cities/[city]/
            $router->addRoute("s8f_admin_country_city", new Zend_Controller_Router_Route(":module/countries/:country/cities/:city", array(
                'module' => 'super-eight-festivals',
                'controller' => "admin-country-cities",
                'action' => "single"
            )));
            // Route: /countries/[country]/cities/[city]/festivals/[festival]/
            $router->addRoute("s8f_admin_country_city_festival", new Zend_Controller_Router_Route(":module/countries/:country/cities/:city/festivals/:festival", array(
                'module' => 'super-eight-festivals',
                'controller' => "admin-country-city-festivals",
                'action' => "single"
            )));

            $this->addRecordRoute($router, "city_banner", "city-banners", ":module/countries/:country/cities/:city/banners", "bannerID");
            $this->addRecordRoute($router, "filmmaker", "filmmakers", ":module/countries/:country/cities/:city/filmmakers", "filmmakerID");
            $this->addRecordRoute($router, "filmmaker_photos", "filmmaker-photos", ":module/countries/:country/cities/:city/filmmakers/:filmmakerID/photos", "filmmakerPhotoID");

            $this->addRecordRoute($router, "festival_film_catalog", "festival-film-catalogs", ":module/countries/:country/cities/:city/festivals/:festivalID/film-catalogs", "filmCatalogID");
            $this->addRecordRoute($router, "festival_films", "festival-films", ":module/countries/:country/cities/:city/festivals/:festivalID/films", "filmID");
            $this->addRecordRoute($router, "festival_memorabilia", "festival-memorabilia", ":module/countries/:country/cities/:city/festivals/:festivalID/memorabilia", "memorabiliaID");
            $this->addRecordRoute($router, "festival_print_media", "festival-print-media", ":module/countries/:country/cities/:city/festivals/:festivalID/print-media", "printMediaID");
            $this->addRecordRoute($router, "festival_photos", "festival-photos", ":module/countries/:country/cities/:city/festivals/:festivalID/photos", "photoID");
            $this->addRecordRoute($router, "festival_posters", "festival-posters", ":module/countries/:country/cities/:city/festivals/:festivalID/posters", "posterID");
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