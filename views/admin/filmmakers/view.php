<?php
echo head(array(
    'title' => ucfirst($festival->getDisplayName()),
));
?>

<?php echo flash(); ?>


<h2>Filmmakers of <?= ucfirst($festival->title); ?></h2>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => '/admin/super-eight-festivals/filmmakers/add', 'text' => 'Add Filmmaker')); ?>

<?=
$this->partial('__components/tables/FilmmakersTable.php',
    array(
        'filmmakersVar' => get_all_filmmakers_for_festival($festival->id),
    )
);
?>


<?php echo foot(); ?>
