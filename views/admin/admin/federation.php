<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(
    array(
        'title' => 'Federation',
    )
);
?>

<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>

<section id="country-single">

    <!--Newsletters-->
    <div class="records-section">
        <h2>Newsletters</h2>
        <a class="button" href="/admin/super-eight-festivals/federation/newsletters/add">Add Newsletter</a>
        <?php $newsletters = get_all_federation_newsletters(); ?>
        <?php if (count($newsletters) == 0): ?>
            <p>There are no newsletters available for the federation.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/federation-newsletters.php", array('federation_newsletters' => $newsletters)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Photos</h2>
        <a class="button" href="/admin/super-eight-festivals/federation/photos/add">Add Photo</a>
        <?php $photos = get_all_federation_photos(); ?>
        <?php if (count($photos) == 0): ?>
            <p>There are no photos available for the federation.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/federation-photos.php", array('federation_photos' => $photos)); ?>
        <?php endif; ?>
    </div>

    <!--Magazines-->
    <div class="records-section">
        <h2>Magazines</h2>
        <a class="button" href="/admin/super-eight-festivals/federation/magazines/add">Add Magazine</a>
        <?php $magazines = get_all_federation_magazines(); ?>
        <?php if (count($magazines) == 0): ?>
            <p>There are no magazines available for the federation.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/federation-magazines.php", array('federation_magazines' => $magazines)); ?>
        <?php endif; ?>
    </div>

    <!--By-Laws-->
    <div class="records-section">
        <h2>By-Laws</h2>
        <a class="button" href="/admin/super-eight-festivals/federation/bylaws/add">Add By-Law</a>
        <?php $bylaws = get_all_federation_bylaws(); ?>
        <?php if (count($bylaws) == 0): ?>
            <p>There are no by-laws available for the federation.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/federation-bylaws.php", array('federation_bylaws' => $bylaws)); ?>
        <?php endif; ?>
    </div>

</section>

<?php echo foot(); ?>
