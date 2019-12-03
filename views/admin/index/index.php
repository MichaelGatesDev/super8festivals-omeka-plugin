<?php
echo head(array(
    'title' => 'Admin Panel',
));
?>

<?php echo flash(); ?>

<h2>Super 8 Festivals Control Panel</h2>

<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/countries/', 'text' => 'Countries')); ?>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/cities/', 'text' => 'Cities')); ?>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/festivals/', 'text' => 'Festivals')); ?>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/filmmakers/', 'text' => 'Filmmakers')); ?>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/contributing/', 'text' => 'Contributing')); ?>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/settings/', 'text' => 'Settings')); ?>
    </div>
</div>

<hr/>

<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/edit-page/', 'text' => 'Edit Page Contents')); ?>
    </div>
</div>

<?php echo foot(); ?>
