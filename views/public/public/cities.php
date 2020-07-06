<?php
$head = array(
    'title' => "Festival Cities",
);
echo head($head);

$cities = get_all_cities();
usort($cities, function ($a, $b) {
    return $a['name'] > $b['name'];
});
?>

<style>
    .card-img-top {
        object-fit: contain;
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

    <div class="row">
        <div class="col">
            <?php foreach ($cities as $city): ?>
                <?php
                $banner = get_city_banner($city->id);
                $festivals = get_all_festivals_in_city($city->id);
                ?>
                <div class="card d-inline-block m-4">
                    <img src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc" ?>" class="card-img-top" style="object-fit: cover" alt="City Banner">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><?= $city->name; ?></h5>
                    </div>
                    <div class="card-footer">
                        <p class="small text-muted m-0 p-0 text-capitalize"><?= $city->get_country()->name; ?></p>
                    </div>
                    <a href="/cities/<?= urlencode($city->name); ?>" class="stretched-link"></a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
