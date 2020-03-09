<?php
echo head(
    array(
        'title' => 'Admin Panel',
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<h2>Super 8 Festivals Control Panel</h2>

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
    <li><a href="/admin/super-eight-festivals/federation" class="button green big" style="margin: 0; padding: 0.5em 1.5em;">Federation</a></li>
    <li><a href="/admin/super-eight-festivals/countries" class="button green big" style="margin: 0; padding: 0.5em 1.5em;">Countries</a></li>
    <li><a href="/admin/super-eight-festivals/filmmakers" class="button green big" style="margin: 0; padding: 0.5em 1.5em;">Filmmakers</a></li>
    <li><a href="/admin/super-eight-festivals/countributors" class="button green big" style="margin: 0; padding: 0.5em 1.5em;">Contributors</a></li>
</ul>

<hr style="margin-top: 5em">

<a href="/admin/super-eight-festivals/purge" class="button red big">DELETE ALL WEBSITE DATA</a>


<?php echo foot(); ?>
