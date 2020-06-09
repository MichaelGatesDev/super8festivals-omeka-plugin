<?php
queue_css_file("admin");
queue_js_file("jquery.min");

echo head(array(
    'title' => $city->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<a class="button blue" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/edit'>Edit</a>
<a class="button red" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/delete'>Delete</a>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>

<section id="city-single">

    <div class="records-section">
        <h2>City Banner</h2>
        <?php $city_banner = get_city_banner($city->id); ?>
        <?php if ($city_banner == null): ?>
            <p>There is no banner available for this city.</p>
            <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name) ?>/banners/add">Add City Banner</a>
        <?php else: ?>
            <?= $this->partial("__components/records/city-banner.php", array('city_banner' => $city_banner)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Description</h2>
        <?php $description = $city->description; ?>
        <?php if ($description == null): ?>
            <p>There is no description available for this city.</p>
        <?php else: ?>
            <?= $description; ?>
        <?php endif; ?>
        <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name) ?>/edit">Modify City Description</a>
    </div>

    <div class="records-section">
        <h2>Festivals</h2>
        <?php
        $festivals = get_all_festivals_in_city($city->id);
        usort($festivals, function ($value, $compareTo) {
            return $value['year'] >= $compareTo['year'];
        });
        ?>
        <?php if (count($festivals) == 0): ?>
            <p>There are no festivals available for this city.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/festivals.php", array('festivals' => $festivals)); ?>
        <?php endif; ?>
        <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/add">Add Festival</a>
    </div>

    <div class="records-section">
        <h2>Filmmakers</h2>
        <?php $filmmakers = get_all_filmmakers_for_city($city->id); ?>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/filmmakers/add">Add Filmmaker</a>
        <?php if (count($filmmakers) == 0): ?>
            <p>There are no filmmakers available for this city.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/filmmakers.php", array('filmmakers' => $filmmakers)); ?>
        <?php endif; ?>
    </div>

</section>

<?php echo foot(); ?>

