<?php
$head = array(
    'title' => "Federation",
);
echo head($head);


?>

<style>
</style>

<section class="container-fluid" id="countries-list">

    <div class="container py-2">
        <div class="row">
            <!--Documents-->
            <div class="col">
                <h2>Documents</h2>
                <?php if (count($records = get_all_federation_documents()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/document-card.php", array("document" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!--Photos-->
            <div class="col">
                <h2>Photos</h2>
                <?php if (count($records = get_all_federation_photos()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <?= $this->partial("__components/cards/image-card.php", array("image" => $record)); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>

<?php echo foot(); ?>
