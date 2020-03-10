<?php
echo head(array(
    'title' => ucwords($filmmaker->get_display_name()),
));
?>

<?php echo flash(); ?>


<h2>Photos</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/film-catalogs/add', 'text' => 'Add Film Catalog')); ?>
<?=
$this->partial('__components/tables/FilmCatalogsTable.php',
    array(
        'filmCatalogsVar' => get_all_film_catalogs_for_festival($festival->id),
    )
);
?>


<?php echo foot(); ?>
