<?php
echo head(array(
    'title' => 'Debug',
));
?>

<?php echo flash(); ?>


<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="mb-5">Debug Tools</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="/admin/super-eight-festivals/debug/purge/unused" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Purge All Unused records</a>
            <a href="/admin/super-eight-festivals/debug/fix-festivals" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Fix Festival IDs</a>
            <a href="/admin/super-eight-festivals/debug/create-tables" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Create DB Tables</a>
            <a href="/admin/super-eight-festivals/debug/create-missing-columns" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Create DB Columns</a>
            <a href="/admin/super-eight-festivals/debug/create-directories" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Create Directories</a>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <a href="/admin/super-eight-festivals/debug/generate-missing-thumbnails" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Generate Missing Thumbnails</a>
            <a href="/admin/super-eight-festivals/debug/regenerate-all-thumbnails" class="btn btn-secondary" style="margin: 0; padding: 0.5em 1.5em;">Regenerate All Thumbnails</a>
            <a href="/admin/super-eight-festivals/debug/delete-all-thumbnails" class="btn btn-danger" style="margin: 0; padding: 0.5em 1.5em;">Delete All Thumbnails</a>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <a href="/admin/super-eight-festivals/debug/relocate-files" class="btn btn-danger" style="margin: 0; padding: 0.5em 1.5em;">Relocate Files</a>
        </div>
    </div>

</section>

<?php echo foot(); ?>
