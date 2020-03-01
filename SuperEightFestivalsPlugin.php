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

        add_countries_by_names(array(
            "argentina",
            "australia",
            "belgium",
            "brazil",
            "canada",
            "colombia",
            "germany",
            "hong kong",
            "iran",
            "italy",
            "japan",
            "mexico",
            "philippines",
            "portugal",
            "puerto rico",
            "spain",
            "tunisia",
            "united states",
            "venezuela"
        ));

        // add cities
        add_city_by_country_name('germany', 'berlin', 52.52000, 13.40500);
        add_city_by_country_name('argentina', 'rosario', -32.95870, -60.69300);
        add_city_by_country_name('australia', 'sydney', -33.86880, 151.20930);
        add_city_by_country_name('belgium', 'brussels', 50.85030, 4.35170);
        add_city_by_country_name('brazil', 'sao paulo', -23.55050, -46.63330);
        add_city_by_country_name('spain', 'barcelona', 41.38510, 2.17340);
        add_city_by_country_name('united states', 'chicago', 41.87810, -87.62980);
        add_city_by_country_name('colombia', 'bogota', 4.71100, -74.07210);
        add_city_by_country_name('philippines', 'manila', 14.59950, 120.98420);
        add_city_by_country_name('hong kong', 'hong kong', 22.31930, 114.16940);
        add_city_by_country_name('iran', 'tehran', 35.68920, 51.38900);
        add_city_by_country_name('japan', 'tokyo', 35.67620, 139.65030);
        add_city_by_country_name('japan', 'hiroshima', 34.38530, 132.45531);
        add_city_by_country_name('mexico', 'mexico city', 19.43260, -99.13320);
        add_city_by_country_name('italy', 'montecallini', 39.81840, 18.31290);
        add_city_by_country_name('portugal', 'lisbon', 38.72230, -9.13930);
        add_city_by_country_name('puerto rico', 'san juan', 18.46550, 66.10570);
        add_city_by_country_name('canada', 'montreal', 45.50170, -73.56730);
        add_city_by_country_name('canada', 'toronto', 43.65320, -79.38320);
        add_city_by_country_name('tunisia', 'kelibia', 36.84620, 11.09950);
        add_city_by_country_name('venezuela', 'caracas', 10.48060, -66.90360);

        // add contributor
        add_contributor(
            "michael",
            "gates",
            "",
            "mgate005@plattsburgh.edu"
        );

        /*
        // add pages
        add_page("History", "/history", "Content goes here.");
        add_page("Federation", "/federation", "Content goes here.");
        add_page("Filmmakers", "/filmmakers", "Content goes here.");
        add_page("About", "/about", "
I am a professor of Spanish and film at the State Univeristy of New York in Plattsburgh. In 2008 I received a Fulbright grant to study the films of Venezuelan avant-garde filmmaker Diego Rísquez. My intention was to examine Rísquez’s work from an author theory perspective. A collection of newspaper clippings in Rísquez’s archive changed my mind. At this point I did not even know what Super 8 was. Yet, I became eager to find out more about the young filmmakers in the newspaper. They had maintained a transnational network, the International Federation of Super 8 Cinema, outside of regional or national institutions.
<br/><br/>
Meeting these filmmakers was fascinating but took a long time. It took over ten years as filmmakers lived in over twenty countries and I received little funding for my project. Most funding sources were not interested in Super 8 culture. In some cases, I interviewed people at airports between flights or took side trips after conferences or visiting relatives. The biggest challenge, however, was not locating and meeting people, but writing about the fascinating world I discovered.
<br/><br/>
Finding ways to write about people in the twenty countries interacting with each other was challenging. For that, I wrote Small Gauge, Big Dreams, a book that focuses on Super 8 as a technology that allowed the establishment of one of the first de-centralized, transnational, cinematic networks.
<br/><br/>
My second challenge was to document my findings. Only in rare instances had local, regional or national archives collect the films, photographs, and catalogs that filmmakers had kept in their attics. This meant that readers could not go to their libraries or a website to view the objects or documents I cite in the book. For that, I created this website.
");


        //============================================================================\\
        //      BELGIUM - THIS IS ONLY TEMPORARY FOR SHOWCASE, WILL BE DYNAMIC SOON
        //============================================================================\\
        // add banner
        add_banner_for_country_by_name(
            "belgium",
            "https://i.imgur.com/w5gYBsF.jpg",
            "https://i.imgur.com/wqa34uC.jpg"
        );

        // add posters
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/V67MtfH.jpg",
            "https://i.imgur.com/4pc1mpm.jpg"
        );

        // add photos
        add_photo_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Photo Title",
            "This is an example description.",
            "https://i.imgur.com/trj94fF.png",
            "https://i.imgur.com/EGSqRDW.png"
        );

        // add print media
        $newspaper = new SuperEightFestivalsFestivalPrintMedia();
        $newspaper->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $newspaper->path = "https://i.imgur.com/EuYD9Hj.jpg";
        $newspaper->thumbnail = "https://i.imgur.com/EuYD9Hj.jpg";
        $newspaper->save();

        // add memorabilia
        $memA = new SuperEightFestivalsFestivalMemorabilia();
        $memA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $memA->path = "https://i.imgur.com/LRLnf4S.png";
        $memA->thumbnail = "https://i.imgur.com/LRLnf4S.png";
        $memA->save();


        // add films
        $filmA = new SuperEightFestivalsFestivalFilm();
        $filmA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmA->title = "My Cool Film";
        $filmA->url = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
        $filmA->embed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $filmA->save();

        // add filmmakers
        $filmmakerA = new SuperEightFestivalsFestivalFilmmaker();
        $filmmakerA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmmakerA->first_name = "Jane";
        $filmmakerA->last_name = "Doe";
        $filmmakerA->cover_photo_url = "https://i.imgur.com/zzA8Gxw.png";
        $filmmakerA->save();
        */
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