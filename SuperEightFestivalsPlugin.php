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
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/5RNAxom.jpg",
            "https://i.imgur.com/QCqZWU6.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/iDTqEUl.jpg",
            "https://i.imgur.com/BVMDc4y.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/lRkRabE.jpg",
            "https://i.imgur.com/4g0Msba.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/kntJ6e2.jpg",
            "https://i.imgur.com/MTdxlNY.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/4J4hn6l.jpg",
            "https://i.imgur.com/RCEiR2Z.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/74a8hJo.jpg",
            "https://i.imgur.com/Xr9GIlS.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/ZIMCNyX.jpg",
            "https://i.imgur.com/L5sbfKq.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/MTnevnF.jpg",
            "https://i.imgur.com/cGr5TGm.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/ov7u63K.jpg",
            "https://i.imgur.com/ENCVfqe.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/zIxrV0U.jpg",
            "https://i.imgur.com/ci5dity.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/iV1wAtW.jpg",
            "https://i.imgur.com/XchGirL.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/vcU1i1Q.jpg",
            "https://i.imgur.com/jBA8tun.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/Qi21JLp.jpg",
            "https://i.imgur.com/IhpUOxZ.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/cdHeYrH.jpg",
            "https://i.imgur.com/Z3VBqSj.jpg"
        );
        add_poster_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Poster Title",
            "This is an example description.",
            "https://i.imgur.com/WyUAsAM.jpg",
            "https://i.imgur.com/wrjiqiU.jpg"
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
        add_photo_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Photo Title",
            "This is an example description.",
            "https://i.imgur.com/G0Ahebf.png",
            "https://i.imgur.com/lCgqHO4.png"
        );
        add_photo_for_city_by_name_and_country_by_name(
            'belgium',
            'brussels',
            "Photo Title",
            "This is an example description.",
            "https://i.imgur.com/RKMrltd.png",
            "https://i.imgur.com/IVLbfxj.png"
        );

        // add print media
        $newspaper = new SuperEightFestivalsFestivalPrintMedia();
        $newspaper->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $newspaper->path = "https://i.imgur.com/EuYD9Hj.jpg";
        $newspaper->thumbnail = "https://i.imgur.com/EuYD9Hj.jpg";
        $newspaper->save();
        $magazine = new SuperEightFestivalsFestivalPrintMedia();
        $magazine->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $magazine->path = "https://i.imgur.com/IzdVLBe.jpg";
        $magazine->thumbnail = "https://i.imgur.com/IzdVLBe.jpg";
        $magazine->save();

        // add memorabilia
        $memA = new SuperEightFestivalsFestivalMemorabilia();
        $memA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $memA->path = "https://i.imgur.com/LRLnf4S.png";
        $memA->thumbnail = "https://i.imgur.com/LRLnf4S.png";
        $memA->save();
        $memB = new SuperEightFestivalsFestivalMemorabilia();
        $memB->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $memB->path = "https://i.imgur.com/KtlAYaR.png";
        $memB->thumbnail = "https://i.imgur.com/KtlAYaR.png";
        $memB->save();
        $memC = new SuperEightFestivalsFestivalMemorabilia();
        $memC->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $memC->path = "https://i.imgur.com/X5qU1V0.jpg";
        $memC->thumbnail = "https://i.imgur.com/X5qU1V0.jpg";
        $memC->save();

        // add films
        $filmA = new SuperEightFestivalsFestivalFilm();
        $filmA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmA->title = "My Cool Film";
        $filmA->url = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
        $filmA->embed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $filmA->save();
        $filmB = new SuperEightFestivalsFestivalFilm();
        $filmB->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmB->title = "Another Awesome Film";
        $filmB->url = "https://www.youtube.com/watch?v=FTQbiNvZqaY";
        $filmB->embed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/FTQbiNvZqaY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $filmB->save();

        // add filmmakers
        $filmmakerA = new SuperEightFestivalsFestivalFilmmaker();
        $filmmakerA->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmmakerA->first_name = "Jane";
        $filmmakerA->last_name = "Doe";
        $filmmakerA->cover_photo_url = "https://i.imgur.com/zzA8Gxw.png";
        $filmmakerA->save();
        $filmmakerB = new SuperEightFestivalsFestivalFilmmaker();
        $filmmakerB->city_id = get_city_by_name(get_country_by_name('belgium')->id, 'brussels')->id;
        $filmmakerB->organization_name = "Example Film University";
        $filmmakerB->cover_photo_url = "https://i.imgur.com/1Lvkt7C.jpg";
        $filmmakerB->save();
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

    function filterPublicNavigationItems($navArray)
    {
//        $navArray[] = array('label' => __('My Plugin Items'),
//            'uri' => url('myplugin/items')
//        );
        return $navArray;
    }


}