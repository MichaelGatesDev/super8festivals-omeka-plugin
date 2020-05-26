<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(array(
    'title' => 'Countries',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #add-country-button {
        margin-bottom: 1em;
    }
</style>


<div class="records-section">
    <a id="add-country-button" class="button green" href="/admin/super-eight-festivals/countries/add">Add Country</a>
    <?php
    $countries = get_all_countries();
    usort($countries, function ($a, $b) {
        return $a['name'] > $b['name'];
    });
    ?>
    <?php if (count($countries) == 0): ?>
        <p>There are no countries available.</p>
    <?php else: ?>
        <?= $this->partial("__components/records/countries.php", array('countries' => $countries)); ?>
    <?php endif; ?>
</div>


<?php echo foot(); ?>

