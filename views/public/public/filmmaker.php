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
            <div class="col">
                <h2 class="mb-4"><?= ucwords($filmmaker->get_full_name()); ?></h2>
            </div>
        </div>
        <div class="row">
            <!--Filmmakers-->
            <div class="col">
                <h3 class="mb-4">Photos</h3>
                <?php if (count($records = get_all_photos_for_filmmaker($filmmaker->id)) > 0): ?>
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
                    <p>There are no filmmakers here yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>

<?php echo foot(); ?>
