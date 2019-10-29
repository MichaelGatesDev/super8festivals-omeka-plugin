<?php
$head = array(
    'title' => 'Contributing',
);
echo head($head);
?>

<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/contributing/contributors', 'text' => 'Contributors')); ?>
<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/contributing/contribution-types', 'text' => 'Contribution Types')); ?>

<?php echo foot(); ?>
