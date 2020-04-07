<?php
$head = array(
    'title' => ucwords($country->name),
);
echo head($head);

$banner = get_active_country_banner($country->id);
$cities = get_all_cities_in_country($country->id);
?>

<style>
</style>

<section class="container-fluid" id="countries-list">

    <div class="container py-2 d-flex flex-column align-items-center">
        <div class="row py-2">
            <div class="col">
                <img src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc" ?>" class="img-fluid img-thumbnail" alt="Responsive image" style="height: 300px;"/>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                <h3 class="my-4">Festival Cities in <?= $country->name ?></h3>
            </div>
        </div>
        <div class="row">
            <?php foreach ($cities as $city): ?>
                <?php
                $banner = get_active_city_banner($city->id);
                $festivals = get_all_festivals_in_city($city->id);
                ?>
                <div class="col">
                    <div class="card mb-4" style="width: 250px;">
                        <img src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc" ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title title"><?= $city->name; ?></h5>
                            <p class="card-text">
                                Festivals: <?= count($festivals); ?>
                            </p>
                            <a href="/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>" class="btn btn-primary w-100">Explore</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
