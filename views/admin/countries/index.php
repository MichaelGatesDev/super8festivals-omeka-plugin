<?php
echo head(array(
    'title' => 'Countries',
));
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
            <h2 class="mb-4">Countries <a class="btn btn-success btn-sm" href="/admin/super-eight-festivals/countries/add">Add Country</a></h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            $cities = get_all_countries();
            usort($cities, function ($a, $b) {
                return $a['name'] > $b['name'];
            });
            ?>
            <table id="countries" class="table table-striped table-hover">
                <thead>
                <tr>
                    <td style="width: 1px;">ID</td>
                    <td>City Name</td>
                    <td style="width: 1px;"></td>
                    <td style="width: 1px;"></td>
                </tr>
                </thead>
                <?php foreach ($cities as $country): ?>
                    <tr>
                        <td onclick="window.location.href = '/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>';" style="cursor: pointer;"><span class="title"><?= $country->id; ?></span></td>
                        <td onclick="window.location.href = '/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>';" style="cursor: pointer;"><span class="title"><?= $country->name; ?></span></td>
                        <td><a class="btn btn-primary btn-sm" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/edit">Edit</a></td>
                        <td><a class="btn btn-danger btn-sm" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/delete">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

</section>


<?php echo foot(); ?>

