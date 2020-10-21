<?php
echo head(array(
    'title' => 'Admin Panel',
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
            <h2 class="mb-5">Super 8 Festivals Control Panel</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="/admin/super-eight-festivals/countries" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Countries</a>
            <a href="/admin/super-eight-festivals/federation" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Federation</a>
            <a href="/admin/super-eight-festivals/filmmakers" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Filmmakers</a>
            <a href="/admin/super-eight-festivals/contributors" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Contributors</a>
            <a href="/admin/super-eight-festivals/staff" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Site Staff</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="/admin/super-eight-festivals/debug" class="btn btn-danger mt-4">Debug Tools</a>
        </div>
    </div>

</section>


<?php echo foot(); ?>
