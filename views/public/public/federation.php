<?php
$head = array(
    'title' => "Federation",
);

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);

?>

<style>
</style>

<section class="container-fluid" id="countries-list">

    <div class="container py-2">
        <div class="row" id="history">
            <div class="col">
                <h2 class="mb-4">History</h2>
                <p>TBD</p>
            </div>
        </div>
        <div class="row">
            <!--Documents-->
            <div class="col">
                <h2 class="mb-4">Documents</h2>
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
                <?php else: ?>
                    <p>There are no documents here yet.</p>
                <?php endif; ?>
            </div>
            <!--Photos-->
            <div class="col">
                <h2 class="mb-4">Photos</h2>
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
                <?php else: ?>
                    <p>There are no photos here yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>

<?php echo foot(); ?>
