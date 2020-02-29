<?php
echo head(array(
    'title' => 'Browse Films',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/films/add', 'text' => 'Add Film')); ?>
<?=
$this->partial('__components/tables/FilmsTable.php',
    array(
        'filmsVar' => get_all_films_for_festival($festival->id),
    )
);
?>

<?php echo foot(); ?>

