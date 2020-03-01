<?php
echo head(array(
    'title' => 'Countries',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    .title {
        text-transform: capitalize;
    }

    #countries {
        margin: 0;
        padding: 0;
        display: block;
    }

    .country {
        font-size: 18px;
        list-style-type: none;
    }

    .country a, .country a:visited {
        color: #c76941;
    }

    .country a:hover {
        color: #e88347;
    }
</style>

<a class="button" href="/admin/super-eight-festivals/countries/add">Add Country</a>

<ul id="countries">
    <?php foreach (get_all_countries() as $country): ?>
        <li class="country title"><a href="/admin/super-eight-festivals/countries/<?= $country->name; ?>"><?= $country->name ?></a></li>
    <?php endforeach; ?>
</ul>


<?php echo foot(); ?>

