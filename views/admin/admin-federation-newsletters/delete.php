<?php
$title = "Untitled";
if (strlen($record->title) > 0) $title = $record->title;
echo head(array(
    'title' => "Delete Federation Newsletter: {$title}",
));
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2>Delete Federation Newsletter</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>Are you sure?</h3>
            <?php echo $form; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
