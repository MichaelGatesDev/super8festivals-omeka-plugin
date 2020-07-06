<?php
echo head(
    array(
        'title' => 'Filmmaker: ' . $filmmaker->get_display_name(),
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>

<section id="federation">

    <div class="records-section">
        <h2>Photos</h2>
        <a class="button green" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/filmmakers/<?= $filmmaker->id; ?>/photos/add'>Add Photo</a>
        <?php $photos = get_all_photos_for_filmmaker($filmmaker->id); ?>
        <?php if (count($photos) == 0): ?>
            <p>There are no photos available for this filmmaker.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/filmmaker-photos.php", array('filmmaker_photos' => $photos)); ?>
        <?php endif; ?>
    </div>


</section>

<?php echo foot(); ?>
