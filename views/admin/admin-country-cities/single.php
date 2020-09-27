<?php
echo head(array(
    'title' => ucwords($city->name) . ", " . ucwords($country->name),
));

$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name);
$banner = SuperEightFestivalsCity::get_by_id($city->id);
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
            <h2 class="text-capitalize"><?= $city->name; ?> <span class="text-muted">(<?= $country->name; ?>)</span></h2>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <!--    Description -->
    <div class="row my-5">
        <div class="col">
            <h3>
                Description
                <a class="btn btn-primary btn-sm" href="<?= $rootURL; ?>/edit">Edit Description</a>
            </h3>
            <?php $description = $city->description; ?>
            <?php if ($description == null): ?>
                <p>There is no description available for this city.</p>
            <?php else: ?>
                <?= $description; ?>
            <?php endif; ?>
        </div>
    </div>

    <!--    City Banner -->
    <div class="row my-5">
        <div class="col">
            <h3>City Banner</h3>
            <?php $city_banner = $city->get_banner(); ?>
            <?php if ($city_banner == null): ?>
                <p>There is no banner available for this city.</p>
                <a class="btn btn-success" href="<?= $rootURL; ?>/banners/add">Add City Banner</a>
            <?php else: ?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?= get_relative_path($city_banner->get_thumbnail_path()); ?>" alt="<?= $city_banner->title; ?>"/>
                    <div class="card-body">
                        <a class="btn btn-primary" href="<?= $rootURL; ?>/banners/<?= $city_banner->id; ?>/edit">Edit</a>
                        <a class="btn btn-danger" href="<?= $rootURL; ?>/banners/<?= $city_banner->id; ?>/delete">Delete</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <s8f-festivals-table country-id="<?= $country->id; ?>" city-id="<?= $city->id; ?>"></s8f-festivals-table>
        </div>
    </div>

    <!--    Filmmakers Table -->
    <div class="row my-5">
        <div class="col">
            <h3 class="text-capitalize">
                Filmmakers
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/filmmakers/add">Add Filmmaker</a>
            </h3>
            <?php $filmmakers = SuperEightFestivalsFilmmaker::get_by_param('city_id', $city->id); ?>
            <?php if (count($filmmakers) == 0): ?>
                <p>There are no filmmakers available for this city.</p>
            <?php else: ?>
                <table id="contributors" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <td style="width: 1px;">ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Organization</td>
                        <td>Email</td>
                        <td style="width: 1px;"></td>
                        <td style="width: 1px;"></td>
                    </tr>
                    </thead>
                    <?php foreach ($filmmakers as $filmmaker): ?>
                        <?php
                        $recordRootURL = "$rootURL/filmmakers/" . $filmmaker->id;
                        ?>
                        <tr>
                            <td onclick="window.location.href = '<?= $recordRootURL; ?>';" style="cursor: pointer;"><span class="title"><?= $filmmaker->id; ?></span></td>
                            <td onclick="window.location.href = '<?= $recordRootURL; ?>';" style="cursor: pointer;"><span class="title"><?= $filmmaker->first_name; ?></span></td>
                            <td onclick="window.location.href = '<?= $recordRootURL; ?>';" style="cursor: pointer;"><span class="title"><?= $filmmaker->last_name; ?></span></td>
                            <td onclick="window.location.href = '<?= $recordRootURL; ?>';" style="cursor: pointer;"><span class="title"><?= $filmmaker->organization_name; ?></span></td>
                            <td onclick="window.location.href = '<?= $recordRootURL; ?>';" style="cursor: pointer;"><span class="title"><?= $filmmaker->email; ?></span></td>
                            <td><a class="btn btn-primary btn-sm" href="<?= $recordRootURL; ?>/edit">Edit</a></td>
                            <td><a class="btn btn-danger btn-sm" href="<?= $recordRootURL; ?>/delete">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>


</section>


<?php echo foot(); ?>

