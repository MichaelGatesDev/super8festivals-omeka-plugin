<?php

ini_set('max_execution_time', 0);

require_once dirname(__FILE__) . '/helpers/IOFunctions.php';
require_once dirname(__FILE__) . '/helpers/SuperEightFestivalsFunctions.php';
require_once dirname(__FILE__) . '/helpers/DBFunctions.php';

class SuperEightFestivalsPlugin extends Omeka_Plugin_AbstractPlugin
{
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
    }

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
                add_country($countryName, $lat, $long);
            }
            fclose($fn);
        }

        $defaultCitiesFile = __DIR__ . "/__res/default-cities.txt";
        if (file_exists($defaultCitiesFile)) {
            $fn = fopen($defaultCitiesFile, "r");
            while (!feof($fn)) {
                $result = fgets($fn);
                list($countryName, $cityName, $lat, $long) = explode(",", trim($result));
                add_city(get_country_by_name($countryName)->id, $cityName, $lat, $long);
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

    function hookDefineRoutes($args)
    {
        $router = $args['router'];

        if (is_admin_theme()) {
            $this->add_static_route($router, "federation", ":module/federation", "federation", true);
            $this->addRecordRoute($router, "federation_document", "federation-documents", ":module/federation/documents", "documentID");
            $this->addRecordRoute($router, "federation_photo", "federation-photos", ":module/federation/photos", "photoID");
            $this->add_static_route($router, "debug", ":module/debug", "debug", true);
            $this->add_static_route($router, "debug_purge_all", ":module/debug/purge/all", "debug-purge-all", true);
            $this->add_static_route($router, "debug_purge_unused", ":module/debug/purge/unused", "debug-purge-unused", true);
            $this->add_static_route($router, "debug_create_tables", ":module/debug/create-tables", "debug-create-tables", true);
            $this->add_static_route($router, "debug_create_directories", ":module/debug/create-directories", "debug-create-directories", true);
            $this->add_static_route($router, "debug_generate_missing_thumbnails", ":module/debug/generate-missing-thumbnails", "debug-generate-missing-thumbnails", true);
            $this->add_static_route($router, "debug_regenerate_all_thumbnails", ":module/debug/regenerate-all-thumbnails", "debug-regenerate-all-thumbnails", true);
            $this->add_static_route($router, "debug_delete_all_thumbnails", ":module/debug/delete-all-thumbnails", "debug-delete-all-thumbnails", true);
            $this->add_static_route($router, "debug_fix_festivals", ":module/debug/fix-festivals", "debug-fix-festivals", true);
            $this->addRecordRoute($router, "contributor", "contributors", ":module/contributors", "contributorID");
            $this->addRecordRoute($router, "country", "countries", ":module/countries", "countryName");
            $this->addRecordRoute($router, "city", "cities", ":module/countries/:countryName/cities", "cityName");
            $this->addRecordRoute($router, "country_banner", "country-banners", ":module/countries/:countryName/banners", "bannerID");
            $this->addRecordRoute($router, "city_banner", "city-banners", ":module/countries/:countryName/cities/:cityName/banners", "bannerID");
            $this->addRecordRoute($router, "festival", "festivals", ":module/countries/:countryName/cities/:cityName/festivals", "festivalID");
            $this->addRecordRoute($router, "film_catalog", "film-catalogs", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/film-catalogs", "filmCatalogID");
            $this->addRecordRoute($router, "filmmaker", "filmmakers", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/filmmakers", "filmmakerID");
            $this->addRecordRoute($router, "film", "films", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/films", "filmID");
            $this->addRecordRoute($router, "memorabilia", "memorabilia", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/memorabilia", "memorabiliaID");
            $this->addRecordRoute($router, "print_media", "print-media", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/print-media", "printMediaID");
            $this->addRecordRoute($router, "photo", "photos", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/photos", "photoID");
            $this->addRecordRoute($router, "poster", "posters", ":module/countries/:countryName/cities/:cityName/festivals/:festivalID/posters", "posterID");
        } else {
//            $this->add_public_static_route($router, "index", "", "index"); // commented out because the theme should handle the index
            $this->add_static_route($router, "search", "search", "search", false);
            $this->add_static_route($router, "about", "about", "about", false);
            $this->add_static_route($router, "contact", "contact", "contact", false);
            $this->add_static_route($router, "submit", "submit", "submit", false);
            $this->add_static_route($router, "federation", "federation", "federation", false);
            $this->add_static_route($router, "filmmakers", "filmmakers", "filmmakers", false);
            $this->add_static_route($router, "cities", "cities", "cities", false);
            $this->add_static_route($router, "city", "cities/:cityName", "city", false);
        }
    }

}