<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(
    array(
        'title' => 'Debug',
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Debug</h2>

<style>
    .buttons {
        margin: 0;
        padding: 0;
    }

    .buttons li {
        list-style-type: none;
        display: inline-block;
    }

    .buttons li:not(:last-child) {
        margin-right: 1em;
    }
</style>

<ul class="buttons">
    <li><a href="/admin/super-eight-festivals/debug/purge/unused" class="button red" style="margin: 0; padding: 0.5em 1.5em;">Purge unused</a></li>
    <!--    <li><a href="/admin/super-eight-festivals/debug/purge/all" class="button red" style="margin: 0; padding: 0.5em 1.5em;">Purge All</a></li>-->
    <li><a href="/admin/super-eight-festivals/debug/create-tables" class="button blue" style="margin: 0; padding: 0.5em 1.5em;">Create DB Tables</a></li>
    <li><a href="/admin/super-eight-festivals/debug/create-directories" class="button blue" style="margin: 0; padding: 0.5em 1.5em;">Create Directories</a></li>
</ul>


<?php echo foot(); ?>
