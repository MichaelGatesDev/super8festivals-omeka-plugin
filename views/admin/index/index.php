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
    <li><a href="/admin/super-eight-festivals/federation" class="button green big" style="margin: 0;">Federation</a></li>
    <li><a href="/admin/super-eight-festivals/countries" class="button green big" style="margin: 0;">Countries</a></li>
    <li><a href="/admin/super-eight-festivals/filmmakers" class="button green big" style="margin: 0;">Filmmakers</a></li>
    <li><a href="/admin/super-eight-festivals/contributors" class="button green big" style="margin: 0;">Contributors</a></li>
</ul>

<div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
    <a href="/admin/super-eight-festivals/pages" class="button blue big" style="margin: 0;">Edit Page Contents</a>
</div>


<?php echo foot(); ?>
