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

<section class="container" id="countries-list">
    <h3>Festival Countries:</h3>
    <ul class="countries-list">
        <?php foreach ($countries as $country): ?>
            <li>
                <a href="<?= $this->url('countries/' . str_replace(" ", "-", strtolower($country->name))); ?>">
                    <?php echo $country->name ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php echo foot(); ?>
