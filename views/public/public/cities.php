<?php
$head = array(
    'title' => "Festival Cities",
);
echo head($head);

$cities = get_all_cities();
?>

<style>
    .card-img-top {
        object-fit: contain;
        width: 250px;
        height: 150px;
    }
</style>

<section class="container-fluid" id="countries-list">

    <div class="container py-2 d-flex flex-column align-items-center">
        <h2>Festival Cities</h2>
        <div class="row">
            <?php foreach ($cities as $city): ?>
                <?php
                $banner = get_city_banner($city->id);
                $festivals = get_all_festivals_in_city($city->id);
                ?>
                <div class="col" style="flex-grow: 0;">
                    <div class="card mb-4" style="width: 250px;">
                        <img src="<?= $banner != null ? get_relative_path($banner->get_thumbnail_path()) : "https://placehold.it/280x140/abc" ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title title"><?= $city->name; ?></h5>
                            <p class="card-text">
                                Festivals: <?= count($festivals); ?>
                            </p>
                        </div>
                        <a href="/cities/<?= urlencode($city->name); ?>" class="stretched-link"></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
