<?php
echo head(array(
    'title' => 'Browse Filmmakers',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Filmmaker')); ?>

<?=
$this->partial('__components/tables/FilmmakersTable.php',
    array(
        'filmmakersVar' => get_all_filmmakers(),
    )
);
?>

<?php echo foot(); ?>

