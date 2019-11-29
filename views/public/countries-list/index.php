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

<section class="container-fluid" id="countries-list">

    <div class="row">
        <div class="col">
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            Images can go here
        </div>
        <div class="col-6">
            <h2>Festival Countries:</h2>
            <ul class="countries-list">
                <?php foreach ($countries as $country): ?>
                    <li>
                        <a href="<?= $this->url('countries/' . str_replace(" ", "-", strtolower($country->name))); ?>">
                            <?php echo $country->name ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php echo foot(); ?>
