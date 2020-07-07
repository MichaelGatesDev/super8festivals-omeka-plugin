<?php
echo head(
    array(
        'title' => 'Federation',
    )
);
?>

<section id="federation" class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2 class="mb-4">Federation</h2>
        </div>
    </div>

    <!--Newsletters-->
    <div class="row mb-4">
        <div class="col">
            <h3>Newsletters <a class="btn btn-success btn-sm" href="/admin/super-eight-festivals/federation/newsletters/add">Add</a></h3>
            <?php $newsletters = get_all_federation_newsletters(); ?>
            <?php if (count($newsletters) == 0): ?>
                <p>There are no newsletters available for the federation.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($newsletters as $newsletter): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $newsletter)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Photos-->
    <div class="row my-4">
        <div class="col bg-light">
            <h3>Photos <a class="btn btn-success btn-sm" href="/admin/super-eight-festivals/federation/photos/add">Add</a></h3>
            <?php $photos = get_all_federation_photos(); ?>
            <?php if (count($photos) == 0): ?>
                <p>There are no photos available for the federation.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($photos as $photo): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $photo)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--Magazines-->
    <div class="row my-4">
        <div class="col">
            <h3>Magazines <a class="btn btn-success btn-sm" href="/admin/super-eight-festivals/federation/magazines/add">Add</a></h3>
            <?php $magazines = get_all_federation_magazines(); ?>
            <?php if (count($magazines) == 0): ?>
                <p>There are no magazines available for the federation.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($magazines as $magazine): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $magazine)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!--By-Laws-->
    <div class="row my-4">
        <div class="col bg-light">
            <h3>By-Laws <a class="btn btn-success btn-sm" href="/admin/super-eight-festivals/federation/bylaws/add">Add</a></h3>
            <?php $bylaws = get_all_federation_bylaws(); ?>
            <?php if (count($bylaws) == 0): ?>
                <p>There are no by-laws available for the federation.</p>
            <?php else: ?>
                <div class="row row-cols">
                    <?php foreach ($bylaws as $bylaw): ?>
                        <?= $this->partial("__components/festival-record-card-previewable.php", array('record' => $bylaw)); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
