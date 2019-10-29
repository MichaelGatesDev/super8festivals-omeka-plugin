<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | About')),
);
echo head($head);
?>

<?php echo flash(); ?>


We should show a list of the countries here.


<?php
$countries = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
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
