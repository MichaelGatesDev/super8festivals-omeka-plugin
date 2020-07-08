<?php
$head = array(
    'title' => "About",
);
echo head($head);
?>

<?php echo flash(); ?>

<section class="container">
    <div class="row">
        <div class="col">
            <h2>About</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>Our Team</h3>
            <?php if (count($records = get_all_staffs()) > 0): ?>
                <div class="row">
                    <div class="col">
                        <div class="row row-cols">
                            <?php foreach ($records as $record): ?>
                                <div class="card d-inline-block p-0 my-2 mx-2" style="width: 18rem;">
                                    <img
                                            class="card-img-top"
                                            src="<?= $record->get_path() != null ? get_relative_path($record->get_thumbnail_path()) : "https://placehold.it/280x140/abc?text=Placeholder"; ?>"
                                            alt="<?= $record->get_full_name(); ?>"
                                            style="object-fit: cover; height: 200px; width: 100%;"
                                    />
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-capitalize m-0"><?= html_escape($record->get_full_name()); ?></h5>
                                    </div>
                                    <div class="card-footer text-center">
                                        <p class="text-capitalize m-0"><?= html_escape($record->role); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>There are no staff here yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo foot(); ?>
