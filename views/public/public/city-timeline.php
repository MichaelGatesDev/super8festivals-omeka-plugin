<?php
$head = array(
    'title' => "Timeline of " . ucwords($city->get_location()->name),
);

echo head($head);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h2 class="text-center py-2">Timeline of <span class="text-capitalize"><?= $city->get_location()->name; ?></span></h2>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <?php if(!$timeline): ?>
                <p>There is no timeline available for this city.</p>
            <?php else: ?>
                <?= $timeline->get_embed()->embed; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo foot(); ?>
