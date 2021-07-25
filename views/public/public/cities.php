<?php
$head = array(
    'title' => "Festival Cities",
);
queue_css_file("style");
queue_css_url("//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css");
echo head($head);

$cities = SuperEightFestivalsCity::get_all();

$sort_modes = array("city", "country");
$sort_mode = isset($_GET['sort']) ? $_GET['sort'] : null;
if ($sort_mode == null) {
    $sort_mode = $sort_modes[0];
}
if ($sort_mode == "city") {
    usort($cities, function ($a, $b) {
        return strtolower($a->get_location()->name) > strtolower($b->get_location()->name);
    });
}
if ($sort_mode == "country") {
    usort($cities, function ($a, $b) {
        $a_country = $a->get_country();
        $b_country = $b->get_country();
        return strtolower($a_country->get_location()->name) > strtolower($b_country->get_location()->name);
    });
}
?>

<section class="container pb-4" id="countries-list">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-center">Festival Cities</h2>
        </div>
    </div>

    <!-- Sort Buttons -->
    <div class="row">
        <div class="col">
            <ul class="nav bg-light rounded">
                <?php foreach ($sort_modes as $mode): ?>
                    <li class="nav-item <?= $sort_mode == $mode ? " active " : "" ?>">
                        <a class="nav-link" href="?sort=<?= $mode; ?>">Sort by <?= ucwords($mode); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="row row-cols-auto g-2">
        <?php foreach ($cities as $city): ?>
            <?php
            $city_loc = $city->get_location();
            $banner = $city->get_banner();
            if ($banner) {
                $banner_file = $banner->get_file();
            } else {
                $banner_file = null;
            }
            $country = $city->get_country();
            $country_loc = $country->get_location();
            $country_code = get_country_code($country_loc->name);
            ?>
            <div class="col">
                <div class="card d-inline-block m-1" style="width: 15rem;">
                    <img src="<?= $banner_file ? get_relative_path($banner_file->get_thumbnail_path()) : img("placeholder-200x200.svg") ?>" class="card-img-top" alt="" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><?= $city_loc->name; ?></h5>
                    </div>
                    <div class="card-footer">
                        <?php if ($country_code): ?>
                            <span class="flag-icon flag-icon-<?= strtolower($country_code); ?>"></span>
                        <?php endif; ?>
                        <span class="small text-muted m-0 p-0 text-capitalize"><?= $country_loc->name; ?></span>
                    </div>
                    <a href="/cities/<?= urlencode($city_loc->name); ?>" class="stretched-link"></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>

<?php echo foot(); ?>
