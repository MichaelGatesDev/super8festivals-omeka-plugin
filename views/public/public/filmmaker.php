<?php
$head = array(
    'title' => "Federation",
);
echo head($head);

$photos = get_all_photos_for_filmmaker($filmmaker->id);
?>

<section class="container pb-4" id="filmmaker">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-capitalize"><?= html_escape($filmmaker->get_full_name()); ?></h2>
        </div>
    </div>

    <div class="row my-5" id="film-catalogs">
        <div class="col">
            <h3>
                Photos (<?= count($photos); ?>)
            </h3>
            <?php if (count($photos) == 0): ?>
                <p>There is no print media available for this festival.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($photos as $film_catalog): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $film_catalog)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
