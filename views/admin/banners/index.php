<?php
echo head(array(
    'title' => 'Cities in ' . $country->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<style>
    .title {
        text-transform: capitalize;
    }

    #cities {
        margin: 0;
        padding: 0;
        display: block;
    }

    .city {
        font-size: 18px;
        list-style-type: none;
    }

    .city a, .city a:visited {
        color: #c76941;
    }

    .city a:hover {
        color: #e88347;
    }
</style>

<ul id="cities">
    <?php foreach (get_all_cities_in_country($country->id) as $city): ?>
        <li class="city title"><a href="/admin/super-eight-festivals/countries/<?= $country->name; ?>/cities/<?= $city->name; ?>"><?= $city->name ?></a></li>
    <?php endforeach; ?>
</ul>


<?php echo foot(); ?>

