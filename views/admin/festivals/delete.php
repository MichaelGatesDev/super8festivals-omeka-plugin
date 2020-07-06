<?php
echo head(array(
    'title' => 'Delete Festival: ' . $festival->get_title(),
));
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <h2>Delete Festival: <?= $festival->get_title(); ?></h2>
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
