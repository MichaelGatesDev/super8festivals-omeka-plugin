<?php
queue_css_file("admin");
echo head(array(
    'title' => $country->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<div style="padding-bottom: 1em;">
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/edit'>Edit</a>
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/delete'>Delete</a>
</div>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
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
</style>
<section id="country-single">

    <div class="records-section">
        <h2>Country Banners</h2>
        <?php $country_banners = get_country_banners($country->id); ?>
        <?php if (count($country_banners) == 0): ?>
            <p>There are no country banners available for this country.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/country-banners.php", array('country_banners' => $country_banners)); ?>
        <?php endif; ?>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/add">Add Country Banner</a>
    </div>

    <h2>Cities</h2>
    <ul id="cities">
        <?php foreach (get_all_cities_in_country($country->id) as $city): ?>
            <li class="country title"><a href="/admin/super-eight-festivals/countries/<?= $country->name; ?>/cities/<?= $city->name; ?>"><?= $city->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>

<?php echo foot(); ?>

