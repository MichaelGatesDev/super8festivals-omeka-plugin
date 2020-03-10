<?php
queue_css_file("admin");
echo head(array(
    'title' => $country->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<a class="button blue" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/edit'>Edit</a>
<a class="button red" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/delete'>Delete</a>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
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
        <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/banners/add">Add Country Banner</a>
    </div>

    <div class="records-section">
        <h2>Cities</h2>
        <?php
        $cities = get_all_cities_in_country($country->id);
        sort($cities);
        ?>
        <?php if (count($cities) == 0): ?>
            <p>There are no cities available for this country.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/cities.php", array('cities' => $cities)); ?>
        <?php endif; ?>
        <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/add">Add City</a>
    </div>
</section>

<?php echo foot(); ?>

