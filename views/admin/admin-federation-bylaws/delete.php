<?php
echo head(array(
    'title' => 'Delete Federation By-Law: ' . (strlen($federation_bylaw->title) > 0 ? ucwords($federation_bylaw->title) : "Untitled"),
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
            <h2>Delete Federation By-Law</h2>
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
