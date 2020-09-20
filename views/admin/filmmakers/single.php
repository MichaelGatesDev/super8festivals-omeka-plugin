<?php
echo head(array(
    'title' => 'Filmmaker: ' . $filmmaker->get_display_name(),
));

$photos = SuperEightFestivalsFilmmakerPhoto::get_by_param('filmmaker_id', $filmmaker->id);
$rootURL = "/admin/super-eight-festivals/countries/" . urlencode($country->name) . "/cities/" . urlencode($city->name) . "/filmmakers/" . $filmmaker->id;
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
                <?= $filmmaker->get_display_name(); ?>
                <a class="btn btn-primary" href='<?= $rootURL; ?>/edit'>Edit</a>
                <a class="btn btn-danger" href='<?= $rootURL; ?>/delete'>Delete</a>
            </h2>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
                <a class="btn btn-success btn-sm" href="<?= $rootURL; ?>/photos/add">Add Photo</a>
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There are no photos available for this filmaker.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
                        <a href="<?= get_relative_path($photo->get_path()) ?>" data-fancybox="fb-filmmaker-photos" data-title="<?= $photo->title; ?>">
                            <img class="card-img-top" src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="<?= $photo->title; ?>"/>
                        </a>
                        <div class="card-body">
                            <div style="overflow: hidden;">
                                <?= $photo->embed; ?>
                            </div>
                            <p>
                                <span class="font-weight-bold">
                                Title:
                                </span>
                                <?= $photo->title == "" ? "Untitled" : $photo->title; ?>
                            </p>
                            <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
                                <?= $photo->description == "" ? "No description available." : $photo->description; ?>
                            </p>
                            <p>
                                <span class="font-weight-bold">
                                Contributor:
                                </span>
                                <?= $photo->contributor ? $photo->contributor->get_display_name() : "No contributor." ?>
                            </p>
                            <div>
                                <a class="btn btn-primary" href="<?= $rootURL; ?>/photos/<?= $photo->id; ?>/edit">Edit</a>
                                <a class="btn btn-danger" href="<?= $rootURL; ?>/photos/<?= $photo->id; ?>/delete">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</section>


<?php echo foot(); ?>
