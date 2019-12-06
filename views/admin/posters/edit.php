<?php
echo head(array(
    'title' => 'Edit Poster: ' . $poster->id,
));
?>

<?php echo flash(); ?>

<div style="display: flex; flex-direction: column;">
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>

    <h2>Thumbnail Preview</h2>
    <img src="<?= $poster->thumbnail; ?>" class="card-img-top" alt="" style="contain; width: 25%;">
    <h2>Original Preview</h2>
    <img src="<?= $poster->path ?>" class="card-img-top" alt="" style="contain; width: 50%;">
</div>


<?php echo foot(); ?>
