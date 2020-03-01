<?php
echo head(array(
    'title' => 'Delete Banner',
));
?>

<?php echo flash(); ?>

<div title="<?php echo $pageTitle; ?>">
    <h2>Are you sure?</h2>
    <?php echo $form; ?>
</div>

<?php echo foot(); ?>
