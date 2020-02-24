<?php
echo head(array(
    'title' => 'Browse Festivals',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add Festival' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Festival')); ?>

<?=
$this->partial('__components/tables/FestivalsTable.php',
    array(
        'festivalsVar' => get_all_festivals(),
    )
);
?>

<?php echo foot(); ?>

