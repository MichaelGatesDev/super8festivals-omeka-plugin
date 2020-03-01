<?php
echo head(array(
    'title' => $city->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<div style="padding-bottom: 1em;">
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/edit'>Edit</a>
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/delete'>Delete</a>
</div>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #content-heading {
        text-transform: capitalize;
    }

    .header-element {
        font-size: 15px;
    }
</style>

<p>Content TBD</p>

<?php echo foot(); ?>

