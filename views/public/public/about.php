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
                        <?php foreach ($records as $record): ?>
                            <div class="card" style="width: 18rem;">
                                <img src="<?= get_relative_path($record->get_thumbnail_path()); ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-capitalize"><?= html_escape($record->get_full_name()); ?></h5>
                                    <p class="card-text"></p>
                                </div>
                                <div class="card-footer">
                                    <p class="m-0"><?= html_escape($record->role); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>There are no staff here yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo foot(); ?>
