<?php
queue_css_file("admin");
echo head(array(
    'title' => 'Countries',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>


<div class="records-section">
    <?php $countries = get_all_countries(); ?>
    <?php if (count($countries) == 0): ?>
        <p>There are no countries available.</p>
    <?php else: ?>
        <?= $this->partial("__components/records/countries.php", array('countries' => $countries)); ?>
    <?php endif; ?>
    <a class="button green" href="/admin/super-eight-festivals/countries/<?= $country->name ?>/banners/add">Add Country</a>
</div>


<?php echo foot(); ?>

