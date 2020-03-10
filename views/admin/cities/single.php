<?php
queue_css_file("admin");
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
        <h2>Festivals</h2>
        <?php $festivals = get_all_festivals_in_city($city->id); ?>
        <?php if (count($festivals) == 0): ?>
            <p>There are no festivals available for this city.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/festivals.php", array('festivals' => $festivals)); ?>
        <?php endif; ?>
        <a class="button green" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/add">Add Festival</a>
    </div>

</section>

<?php echo foot(); ?>

