<?php
$head = array(
    'title' => "Countries",
);
echo head($head);
?>

<?php echo flash(); ?>



<?php
$countries = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
sort($countries);
?>

<ul class="countries-list">
    <?php foreach ($countries as $country): ?>
        <li>
            <a href="<?= $this->url('countries/' . str_replace(" ", "-", strtolower($country->name))); ?>">
                <?php echo $country->name ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<?php echo foot(); ?>
