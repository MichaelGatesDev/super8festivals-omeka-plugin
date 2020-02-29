<?php
echo head(array(
    'title' => 'Browse Film Catalogs',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/film-catalogs/add', 'text' => 'Add Film Catalog')); ?>
<?=
$this->partial('__components/tables/FilmCatalogsTable.php',
    array(
        'filmCatalogsVar' => get_all_film_catalogs_for_festival($festival->id),
    )
);
?>

<?php echo foot(); ?>

