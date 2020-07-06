<?php
echo head(array(
    'title' => $country->name,
));

$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country->name);
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="text-capitalize">
                <?= $country->name; ?>
                <a class="btn btn-primary" href='<?= $rootURL; ?>/edit'>Edit</a>
                <a class="btn btn-danger" href='<?= $rootURL; ?>/delete'>Delete</a>
            </h2>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <h3 class="text-capitalize">
                Cities
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/cities/add">Add City</a>
            </h3>
            <p class="text-muted">Click on the city name to navigate to its page.</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            $cities = get_all_cities_in_country($country->id);
            sort($cities);
            ?>
            <?php if (count($cities) == 0): ?>
                <p>There are no cities available for this country.</p>
            <?php else: ?>
                <table id="countries" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <td style="width: 1px;">ID</td>
                        <td>City Name</td>
                        <td style="width: 1px;"></td>
                        <td style="width: 1px;"></td>
                    </tr>
                    </thead>
                    <?php foreach ($cities as $city): ?>
                        <tr>
                            <td onclick="window.location.href = '<?= $rootURL; ?>/cities/<?= urlencode($city->name); ?>';" style="cursor: pointer;"><span class="title"><?= $city->id; ?></span></td>
                            <td onclick="window.location.href = '<?= $rootURL; ?>/cities/<?= urlencode($city->name); ?>';" style="cursor: pointer;"><span class="title"><?= $city->name; ?></span></td>
                            <td><a class="btn btn-primary btn-sm" href="<?= $rootURL; ?>/cities/<?= urlencode($city->name); ?>/edit">Edit</a></td>
                            <td><a class="btn btn-danger btn-sm" href="<?= $rootURL; ?>/cities/<?= urlencode($city->name); ?>/delete">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</section>


<?php echo foot(); ?>

