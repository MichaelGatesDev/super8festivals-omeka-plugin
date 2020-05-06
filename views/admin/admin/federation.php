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

    <div class="records-section">
        <h2>Documents</h2>
        <a class="button" href="/admin/super-eight-festivals/federation/documents/add">Add Document</a>
        <?php $documents = get_all_federation_documents(); ?>
        <?php if (count($documents) == 0): ?>
            <p>There are no documents available for the federation.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/federation-documents.php", array('federation_documents' => $documents)); ?>
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

</section>

<?php echo foot(); ?>
