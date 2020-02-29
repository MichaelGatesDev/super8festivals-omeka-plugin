<?php
echo head(array(
    'title' => ucfirst($festival->getDisplayName()),
));
?>

<?php echo flash(); ?>


<h2>Film Catalogs</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/film-catalogs/add', 'text' => 'Add Film Catalog')); ?>
<?=
$this->partial('__components/tables/FilmCatalogsTable.php',
    array(
        'filmCatalogsVar' => get_all_film_catalogs_for_festival($festival->id),
    )
);
?>


<h2>Filmmakers</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/filmmakers/add', 'text' => 'Add Filmmaker')); ?>
<?=
$this->partial('__components/tables/FilmmakersTable.php',
    array(
        'filmmakersVar' => get_all_filmmakers_for_festival($festival->id),
    )
);
?>


<h2>Films</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/films/add', 'text' => 'Add Film')); ?>
<?=
$this->partial('__components/tables/FilmsTable.php',
    array(
        'filmsVar' => get_all_films_for_festival($festival->id),
    )
);
?>


<h2>Memorabilia</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/memorabilia/add', 'text' => 'Add Memorabilia')); ?>
<?=
$this->partial('__components/tables/MemorabiliaTable.php',
    array(
        'memorabiliaVar' => get_all_memorabilia_for_festival($festival->id),
    )
);
?>


<h2>Print Media</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/printmedia/add', 'text' => 'Add Print Media')); ?>
<?=
$this->partial('__components/tables/PrintMediaTable.php',
    array(
        'printMediaVar' => get_all_print_media_for_festival($festival->id),
    )
);
?>


<h2>Photos</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/photos/add', 'text' => 'Add Photo')); ?>
<?=
$this->partial('__components/tables/PhotosTable.php',
    array(
        'photosVar' => get_all_photos_for_festival($festival->id),
    )
);
?>


<h2>Posters</h2>
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/posters/add', 'text' => 'Add Poster')); ?>
<?=
$this->partial('__components/tables/PostersTable.php',
    array(
        'postersVar' => get_all_posters_for_festival($festival->id),
    )
);
?>


<?php echo foot(); ?>
