<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Control Panel')),
);
echo head($head);
?>

<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/countries/', 'text' => 'Countries')); ?>
<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/cities/', 'text' => 'Cities')); ?>
<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/filmmakers/', 'text' => 'Filmmakers')); ?>
<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/settings/', 'text' => 'Settings')); ?>

<?php echo foot(); ?>
