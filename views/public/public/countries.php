<?php
$head = array(
    'title' => "Countries",
);
echo head($head);

$countries = get_all_countries();
?>

<style>
    img.country-banner {
        object-fit: cover;
    }
</style>
<section class="container-fluid" id="countries-list">

    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h2>Countries</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($countries as $country): ?>
                <?php
                $banner = get_active_country_banner($country->id);
                $cities = get_all_cities_in_country($country->id);
                $festivals = get_all_festivals_in_country($country->id);
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="card mb-4">
                        <div class="embed-responsive embed-responsive-16by9">
                            <img alt="<?= $country->name; ?>"
                                 class="card-img-top embed-responsive-item img-thumbnail img-responsive country-banner"
                                 src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc"; ?>"
                            />
                        </div>
                        <div class="card-body">
                            <h3 class="card-title text-capitalize"><?= $country->name; ?></h3>
                            <div class="row">
                                <div class="col">
                                    <p class="card-text text-left mb-1"><small class="text-muted"><?= count($cities); ?> Cities</small></p>
                                </div>
                                <div class="col">
                                    <p class="card-text text-left mb-1"><small class="text-muted"><?= count($cities); ?> Festivals</small></p>
                                </div>
                            </div>
                            <a href="/countries/<?= urlencode($country->name); ?>" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
