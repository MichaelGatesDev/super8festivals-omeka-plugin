<?php
echo head(array(
    'title' => $city->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<style>
    #content-heading {
        text-transform: capitalize;
    }

    .header-element {
        font-size: 15px;
    }
</style>

<a class='header-element' href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/edit'>Edit</a>
<a class='header-element' href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/delete'>Delete</a>


<p>Content TBD</p>

<?php echo foot(); ?>

