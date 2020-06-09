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
            <!--Filmmakers-->
            <div class="col">
                <h2 class="mb-4">Filmmakers</h2>
                <?php if (count($records = get_all_festival_filmmakers()) > 0): ?>
                    <div class="row">
                        <div class="col">
                            <div class="card-columns">
                                <?php foreach ($records as $record): ?>
                                    <h2 class="mb-4"><?= $record->get_full_name(); ?></h2>
                                    <div class="filmmaker-card">F
                                        <p></p>
                                    </div>
                                    <?= $this->partial("__components/cards/person-card.php", array("person" => $record)); ?>
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
