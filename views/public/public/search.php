<?php
$head = array(
    'title' => "Search: " . $query,
);
echo head($head);

$query = strtolower(trim($query));


if (!isset($search_type)) $search_type = "city";

function search_records($records, $properties, $query, &$arr)
{
    if (strlen($query) === 0) return;
    foreach ($records as $record) {
        $record_as_array = $record->to_array();
        foreach ($properties as $property) {
            $nested_property = strtolower(get_nested_property($record_as_array, $property));
            if (strpos($nested_property, $query) !== false) {
//                echo $nested_property . " <-- Contains " . $query . "<br>";
                if (in_array($record, $arr)) continue;
                array_push($arr, $record);
            }
        }
    }
}

?>

<section class="container my-5" id="search-section">


    <?php if (strlen($query) > 0): ?>
        <h2 class="mb-4">Search Results for "<?= $query ?>"</h2>

        <?php

        $matching_cities = [];
        $matching_festivals = [];
        $matching_festival_film_catalogs = [];
        $matching_festival_photos = [];
        $matching_festival_posters = [];
        $matching_festival_print_media = [];
        $matching_filmmakers = [];
        $matching_films = [];

        switch ($search_type) {
            case "city":
                search_records(SuperEightFestivalsCity::get_all(), [
                    "location.name",
                    "country.location.name",
                ], $query, $matching_cities);
                break;
            case "festival":
                search_records(SuperEightFestivalsFestival::get_all(), [
                    "year",
                    "country.location.name",
                    "city.location.name",
                ], $query, $matching_festivals);
                break;
            case "film-catalog":
                search_records(SuperEightFestivalsFestivalFilmCatalog::get_all(), [
                    "festival.year",
                    "festival.city.country.location.name",
                    "festival.city.location.name",
                    "file.title",
//                    "file.description",
                ], $query, $matching_festival_film_catalogs);
                break;
            case "photo":
                search_records(SuperEightFestivalsFestivalPhoto::get_all(), [
                    "festival.year",
                    "festival.city.country.location.name",
                    "festival.city.location.name",
                    "file.title",
//                    "file.description",
                ], $query, $matching_festival_photos);
                break;
            case "poster":
                search_records(SuperEightFestivalsFestivalPoster::get_all(), [
                    "festival.year",
                    "festival.city.country.location.name",
                    "festival.city.location.name",
                    "file.title",
//                    "file.description",
                ], $query, $matching_festival_posters);
                break;
            case "print-media":
                search_records(SuperEightFestivalsFestivalPrintMedia::get_all(), [
                    "festival.year",
                    "festival.city.country.location.name",
                    "festival.city.location.name",
                    "file.title",
//                    "file.description",
                ], $query, $matching_festival_print_media);
                break;
            case "filmmaker":
                search_records(SuperEightFestivalsFilmmaker::get_all(), [
                    "person.first_name",
                    "person.last_name",
                    "person.organization_name",
                    "person.email",
                ], $query, $matching_filmmakers);
                break;
            case "film":
                search_records(SuperEightFestivalsFilmmakerFilm::get_all(), [
                    "embed.title",
//                    "embed.description",
                    "filmmaker.person.first_name",
                    "filmmaker.person.last_name",
                    "filmmaker.person.organization_name",
                    "filmmaker.person.email",
                ], $query, $matching_films);
                break;
        }
        ?>

        <!-- Matching Cities -->
        <?php if (count($matching_cities) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Cities</h3>
                    <ul>
                        <?php foreach ($matching_cities as $city): ?>
                            <li>
                                <a href="/cities/<?= urlencode($city->get_location()->name); ?>">
                                    <span class="text-capitalize">
                                        <?= $city->get_location()->name; ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>


        <!-- Matching Festivals -->
        <?php if (count($matching_festivals) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Festivals</h3>
                    <ul>
                        <?php foreach ($matching_festivals as $festival): ?>
                            <li>
                                <a href="/cities/<?= urlencode($festival->get_city()->get_location()->name); ?>/?year=<?= $festival->year; ?>">
                                    <span class="text-capitalize">
                                        (<?= $festival->year === 0 ? "Uncategorized" : $festival->year; ?>) <?= $festival->get_city()->get_location()->name; ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Festival Film Catalogs -->
        <?php if (count($matching_festival_film_catalogs) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Festival Film Catalogs</h3>
                    <ul>
                        <?php foreach ($matching_festival_film_catalogs as $film_catalog): ?>
                            <?php
                            $festival = $film_catalog->get_festival();
                            $city = $festival->get_city();
                            ?>
                            <li>
                                <a href="/cities/<?= urlencode($city->get_location()->name); ?>/?year=<?= $festival->year; ?>#film-catalogs">
                                    <span class="text-capitalize"><?= $film_catalog->get_file()->title; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Festival Photos -->
        <?php if (count($matching_festival_photos) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Festival Photos</h3>
                    <ul>
                        <?php foreach ($matching_festival_photos as $photo): ?>
                            <?php
                            $festival = $photo->get_festival();
                            $city = $festival->get_city();
                            ?>
                            <li>
                                <a href="/cities/<?= urlencode($city->get_location()->name); ?>/?year=<?= $festival->year; ?>#photos">
                                    <span class="text-capitalize"><?= $photo->get_file()->title; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Festival Posters -->
        <?php if (count($matching_festival_posters) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Festival Posters</h3>
                    <ul>
                        <?php foreach ($matching_festival_posters as $poster): ?>
                            <?php
                            $festival = $poster->get_festival();
                            $city = $festival->get_city();
                            ?>
                            <li>
                                <a href="/cities/<?= urlencode($city->get_location()->name); ?>/?year=<?= $festival->year; ?>#posters">
                                    <span class="text-capitalize"><?= $poster->get_file()->title; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Festival Print Media -->
        <?php if (count($matching_festival_print_media) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Festival Print Media</h3>
                    <ul>
                        <?php foreach ($matching_festival_print_media as $print_media): ?>
                            <?php
                            $festival = $print_media->get_festival();
                            $city = $festival->get_city();
                            ?>
                            <li>
                                <a href="/cities/<?= urlencode($city->get_location()->name); ?>/?year=<?= $festival->year; ?>#print-media">
                                    <span class="text-capitalize"><?= $print_media->get_file()->title; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Filmmakers -->
        <?php if (count($matching_filmmakers) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Filmmakers</h3>
                    <ul>
                        <?php foreach ($matching_filmmakers as $filmmaker): ?>
                            <li>
                                <a href="/filmmakers/<?= $filmmaker->id; ?>">
                                    <span class="text-capitalize"><?= $filmmaker->get_person()->get_name(); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Matching Films -->
        <?php if (count($matching_films) > 0): ?>
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-2">Films</h3>
                    <ul>
                        <?php foreach ($matching_films as $film): ?>
                            <li>
                                <a href="/filmmakers/<?= $film->filmmaker_id; ?>#films-<?= $film->id; ?>">
                                    <span class="text-capitalize"><?= $film->get_embed()->title; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <h2>Oops!</h2>
        <p>It seems you did not search for anything.</p>
    <?php endif; ?>

</section>

<?php echo foot(); ?>
