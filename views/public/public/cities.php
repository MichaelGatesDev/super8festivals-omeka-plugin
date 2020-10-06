<?php
$head = array(
    'title' => "Festival Cities",
);
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
        return strtolower($a['name']) > strtolower($b['name']);
    });
}
if ($sort_mode == "country") {
    usort($cities, function ($a, $b) {
        $a_country = $a->get_country();
        $b_country = $b->get_country();
        return strtolower($a_country['name']) > strtolower($b_country['name']);
    });
}
?>

<style>
    .card-img-top {
        object-fit: cover;
        width: 250px;
        height: 150px;
    }
</style>

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

    <div class="row">
        <div class="col">
            <?php foreach ($cities as $city): ?>
                <?php
                $banner = $city->get_banner();
                $country = $city->get_country();
                $country_code = get_country_code($country->name);
                ?>
                <div class="card d-inline-block m-4">
                    <img src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc?text=Placeholder" ?>" class="card-img-top" style="object-fit: cover" alt="City Banner" loading="lazy">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><?= $city->name; ?></h5>
                    </div>
                    <div class="card-footer">
                        <?php if ($country_code): ?>
                            <span class="flag-icon flag-icon-<?= strtolower($country_code); ?>"></span>
                        <?php endif; ?>
                        <span class="small text-muted m-0 p-0 text-capitalize"><?= $country->name; ?></span>
                    </div>
                    <a href="/cities/<?= urlencode($city->name); ?>" class="stretched-link"></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
