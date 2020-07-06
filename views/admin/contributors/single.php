<?php
echo head(array(
    'title' => 'Contributor: ' . $contributor->get_display_name(),
));
$rootURL = "/admin/super-eight-festivals/contributors/" . $contributor->id;
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
                <?= $contributor->get_display_name(); ?>
                <a class="btn btn-primary" href='<?= $rootURL; ?>/edit'>Edit</a>
                <a class="btn btn-danger" href='<?= $rootURL; ?>/delete'>Delete</a>
            </h2>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <h3 class="text-capitalize">
                Contributions
            </h3>
            <p class="text-muted">Feature not available yet.</p>
        </div>
    </div>

</section>

<?php echo foot(); ?>
