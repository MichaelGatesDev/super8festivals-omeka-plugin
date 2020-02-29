<?php
echo head(array(
    'title' => 'Edit Banner: ' . $banner->id,
));
?>

<?php echo flash(); ?>

<div style="display: flex; flex-direction: column;">
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>

    <h2>Thumbnail Preview</h2>
    <img src="<?= $banner->thumbnail; ?>" class="card-img-top" alt="" style="contain; width: 25%;">
    <h2>Original Preview</h2>
    <img src="<?= $banner->path ?>" class="card-img-top" alt="" style="contain; width: 50%;">
</div>


<?php echo foot(); ?>
