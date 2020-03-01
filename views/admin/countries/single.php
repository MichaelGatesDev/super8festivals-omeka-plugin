<?php
echo head(array(
    'title' => $country->name,
));

$banner = get_banner_for_country($country->id);
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #content-heading {
        text-transform: capitalize;
    }

    .header-element {
        font-size: 15px;
    }

    .title {
        text-transform: capitalize;
    }

    #country-single #cities {
        margin: 0;
        padding: 0;
        display: block;
    }

    #country-single .country {
        font-size: 18px;
        list-style-type: none;
    }

    #country-single a, a:visited {
        color: #c76941;
    }

    #country-single a:hover {
        color: #e88347;
    }
</style>

<section id="country-single">
    <a class='header-element' href='/admin/super-eight-festivals/countries/<?= $country->name ?>/edit'>Edit</a>
    <a class='header-element' href='/admin/super-eight-festivals/countries/<?= $country->name ?>/delete'>Delete</a>

    <h2>Country Banner</h2>
    <?php if ($banner != null): ?>
        <div id="country-banner">
            <img src="" alt=""/>
        </div>
        <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/<?= $banner->id; ?>/edit">Edit</a>.
        <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/<?= $banner->id; ?>/delete">Delete</a>.
    <?php else: ?>
        <p>
            There is no banner available for this country.
            <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/add">Add one</a>.
        </p>
    <?php endif; ?>

    <h2>Cities</h2>
    <ul id="cities">
        <?php foreach (get_all_cities_in_country($country->id) as $city): ?>
            <li class="country title"><a href="/admin/super-eight-festivals/countries/<?= $country->name; ?>/cities/<?= $city->name; ?>"><?= $city->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>

<?php echo foot(); ?>

