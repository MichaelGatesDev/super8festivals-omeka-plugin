<?php
$title = "Untitled";
if (strlen($record->title) > 0) $title = $record->title;
echo head(array(
    'title' => "Edit Federation By-Law: {$title}",
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
            <h2>Edit Federation By-Law</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php echo $form; ?>
        </div>
    </div>

</section>


<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/preview-file.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/shared/javascripts/sort-selects.js'></script>

<?php echo foot(); ?>
