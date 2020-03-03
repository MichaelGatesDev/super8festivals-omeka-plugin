<?php
echo head(array(
    'title' => $country->name,
));

$banner = get_banner_for_country($country->id);
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<div style="padding-bottom: 1em;">
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/edit'>Edit</a>
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/delete'>Delete</a>
</div>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #content-heading {
        text-transform: capitalize;
    }

    .title {
        text-transform: capitalize;
    }

    #country-single h2 {
        margin-bottom: 0.25em;
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

    #country-banner {
        border: 5px solid #9d5b41;
        width: 350px;
        height: 200px;
    }

    #country-banner img {
        object-fit: cover;
        width: inherit;
        height: inherit;
    }
</style>

<section id="country-single">
    <h2>Country Banner</h2>
    <?php if ($banner != null): ?>
        <div id="country-banner">
            <img src="<?= get_relative_path(get_country_dir($country->name) . "/" . $banner->path_file); ?>" alt=""/>
        </div>
        <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/<?= $banner->id; ?>/delete">Delete</a>
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

