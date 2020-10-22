<?php
$head = array(
    'title' => "Filmmakers",
);
echo head($head);
?>

<style>
</style>

<section class="container my-5" id="filmmakers">

    <div class="row">
        <div class="col">
            <h2 class="my-4">Filmmakers</h2>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col">
            <?php if (count($records = SuperEightFestivalsFilmmaker::get_all()) > 0): ?>
                <?php foreach ($records as $filmmaker): ?>
                    <div class="card d-inline-block mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-capitalize mb-3">
                                <?= $filmmaker->get_full_name() == "" ? "No name" : html_escape($filmmaker->get_full_name()) ?>
                            </h5>
                            <p class="card-text mb-1"><span class="font-weight-bold">Total films:</span> <?= count($filmmaker->get_films()); ?></p>
                            <p class="card-text mb-1"><span class="font-weight-bold">Organization:</span> <?= $filmmaker->organization_name != "" ? $filmmaker->organization_name : "N/A" ?></p>
                            <a href="/filmmakers/<?= $filmmaker->id; ?>/" class="stretched-link"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>There are no filmmakers here yet.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
