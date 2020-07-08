<?php
$head = array(
    'title' => "Federation",
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
            <?php if (count($records = get_all_filmmakers()) > 0): ?>
                <?php foreach ($records as $filmmaker): ?>
                    <div class="card d-inline-block m-4">
                        <div class="card-body">
                            <h5 class="card-title text-capitalize"><?= $filmmaker->get_display_name(); ?></h5>
                        </div>
                        <a href="/filmmakers/<?= $filmmaker->id; ?>" class="stretched-link"></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>There are no filmmakers here yet.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
