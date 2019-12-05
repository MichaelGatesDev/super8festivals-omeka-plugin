<?php
$head = array(
    'title' => "Search Results",
);
echo head($head);
?>

<?php echo flash(); ?>

<?php

$searchQuery = $_GET["query"];

$foundCountries = get_all_countries_by_name_ambiguous($searchQuery);
$foundCities = get_all_cities_by_name_ambiguous($searchQuery);

$resultsCount = count($foundCountries) + count($foundCities);
?>

<section class="container">

    <div class="row">
        <div class="col">
            <h2>Search Results (<?= $resultsCount; ?> total)</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php if ($resultsCount == 0): ?>
                <p>No results found for '<?= $searchQuery; ?>'</p>
            <?php else: ?>
                <!--COUNTRIES-->
                <?php if (count($foundCountries) > 0): ?>
                    <h3>Countries:</h3>
                    <ul>
                        <?php foreach ($foundCountries as $country): ?>
                            <li class="text-capitalize">
                                <a href="/countries/<?= str_replace(" ", "-", strtolower($country->name)); ?>">
                                    <?= $country->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <!--CITIES-->
                <?php if (count($foundCities) > 0): ?>
                    <h3>Countries:</h3>
                    <ul>
                        <?php foreach ($foundCities as $city): ?>
                            <li class="text-capitalize">
                                <?php
                                $country = get_country_by_id($city->country_id);
                                $countryNameInternal = str_replace(" ", "-", strtolower($country->name));
                                $cityNameInternal = str_replace(" ", "-", strtolower($city->name));
                                ?>
                                <a href="/countries/<?= $countryNameInternal ?>#<?= $cityNameInternal; ?>">
                                    <?= $city->name; ?>, <?= $country->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


</section>

<?php echo foot(); ?>
