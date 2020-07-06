<?php
echo head(array(
    'title' => 'Delete Film Catalog: ' . (strlen($film_catalog->title) > 0 ? ucwords($film_catalog->title) : "Untitled"),
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
            <h2>Delete Film Catalog</h2>
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
