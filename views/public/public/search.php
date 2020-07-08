<?php
$head = array(
    'title' => "Search: " . $query,
);
echo head($head);

function search_records($records, $property, $query, &$arr)
{
    if (strlen(trim($query)) === 0) return;
    foreach ($records as $record) {
        if (strpos($record[$property], $query) !== false) {
//            echo $record[$property] . " <-- Contains " . $query . " || ";
            if (in_array($record, $arr)) continue;
            array_push($arr, $record);
        }
    }
}

$query = trim($query); // trim blank
?>


<style>
</style>

<section class="container my-5" id="search-section">


    <?php if (trim(strlen($query)) > 0): ?>
        <h2>Search Results</h2>
        <p>Search query: <?= $query ?></p>

        <?php
        $countries = get_all_countries();
        $cities = get_all_cities();
        $contributors = get_all_contributors();
        $festivals = get_all_festivals();
        $festival_films = get_all_films();
        $festival_film_catalogs = get_all_film_catalogs();
        $filmmakers = get_all_filmmakers();
        $festival_memorabilia = get_all_memorabilia();
        $festival_photos = get_all_photos();
        $festival_posters = get_all_posters();
        $festival_print_media = get_all_print_media();

        $split_query = explode(" ", strtolower($query));
        $matching_countries = array();
        sort($matching_countries);
        $matching_cities = array();
        $matching_contributors = array();
        $matching_festivals = array();
        $matching_festival_films = array();
        $matching_festival_film_catalogs = array();
        $matching_festival_filmmakers = array();
        $matching_festival_memorabilia = array();
        $matching_festival_photos = array();
        $matching_festival_posters = array();
        $matching_festival_print_media = array();
        foreach ($split_query as $part) {
            // search country metadata
            search_records($countries, "name", $part, $matching_countries);

            // search city metadata
            search_records($cities, "name", $part, $matching_cities);

            // search contributor metadata
            search_records($contributors, "first_name", $part, $matching_contributors);
            search_records($contributors, "last_name", $part, $matching_contributors);
            search_records($contributors, "organization_name", $part, $matching_contributors);
            search_records($contributors, "email", $part, $matching_contributors);

            // search festival metadata
            search_records($festivals, "year", $part, $matching_festivals);
            search_records($festivals, "title", $part, $matching_festivals);
            search_records($festivals, "description", $part, $matching_festivals);

            // search festival film metadata
            search_records($festival_films, "title", $part, $matching_festival_films);
            search_records($festival_films, "description", $part, $matching_festival_films);

            // search festival film catalog metadata
            search_records($festival_film_catalogs, "title", $part, $matching_festival_film_catalogs);
            search_records($festival_film_catalogs, "description", $part, $matching_festival_film_catalogs);

            // search city filmmaker metadata
            search_records($filmmakers, "first_name", $part, $matching_festival_filmmakers);
            search_records($filmmakers, "last_name", $part, $matching_festival_filmmakers);
            search_records($filmmakers, "organization_name", $part, $matching_festival_filmmakers);
            search_records($filmmakers, "email", $part, $matching_festival_filmmakers);

            // search festival memorabilia metadata
            search_records($festival_memorabilia, "title", $part, $matching_festival_memorabilia);
            search_records($festival_memorabilia, "description", $part, $matching_festival_memorabilia);

            // search festival photos metadata
            search_records($festival_photos, "title", $part, $matching_festival_photos);
            search_records($festival_photos, "description", $part, $matching_festival_photos);

            // search festival posters metadata
            search_records($festival_posters, "title", $part, $matching_festival_posters);
            search_records($festival_posters, "description", $part, $matching_festival_posters);

            // search festival print media metadata
            search_records($festival_print_media, "title", $part, $matching_festival_print_media);
            search_records($festival_print_media, "description", $part, $matching_festival_print_media);
        }
        usort($matching_countries, function ($a, $b) {
            return strcmp(strtolower($a->name), strtolower($b->name));
        });
        usort($matching_cities, function ($a, $b) {
            return strcmp(strtolower($a->name), strtolower($b->name));
        });
        ?>

        <!-- Matching Countries -->
        <?php if (count($matching_countries) > 0): ?>
            <h3>Countries</h3>
            <ul>
                <?php foreach ($matching_countries as $country): ?>
                    <li>
                        <a href="/countries/<?= urlencode($country->name); ?>" class="title"><?= $country->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Cities -->
        <?php if (count($matching_cities) > 0): ?>
            <h3>Cities</h3>
            <ul>
                <?php foreach ($matching_cities as $city): ?>
                    <li>
                        <a href="/cities/<?= urlencode($city->name); ?>" class="title"><?= $city->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Contributors -->
        <?php if (count($matching_contributors) > 0): ?>
            <h3>Contributors</h3>
            <ul>
                <?php foreach ($matching_contributors as $contributor): ?>
                    <li>
                        <a href="/contributors/<?= $contributor->id ?>" class="title"><?= $contributor->get_display_name(); ?>&nbsp;<span class="text-lowercase">(<?= $contributor->email; ?>)</span></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festivals -->
        <?php if (count($matching_festivals) > 0): ?>
            <h3>Festivals</h3>
            <ul>
                <?php foreach ($matching_festivals as $festival): ?>
                    <li>
                        <a href="/cities/<?= urlencode($festival->get_city()->name); ?>" class="title">
                            <?php if ($festival->year !== -0): ?>
                                (<?= $festival->year; ?>)&nbsp;
                            <?php endif; ?>
                            <?= $festival->title; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Films -->
        <?php if (count($matching_festival_films) > 0): ?>
            <h3>Festival Films</h3>
            <ul>
                <?php foreach ($matching_festival_films as $film): ?>
                    <li>
                        <a href="<?= "Video Direct Link TBD" ?>">
                            <?php if (strlen($film->title) > 0): ?>
                                <?= $film->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($film->description) > 0): ?>
                            <p><?= $film->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Film Catalogs -->
        <?php if (count($matching_festival_film_catalogs) > 0): ?>
            <h3>Festival Film Catalogs</h3>
            <ul>
                <?php foreach ($matching_festival_film_catalogs as $film_catalog): ?>
                    <li>
                        <a href="<?= get_relative_path($film_catalog->get_path()); ?>">
                            <?php if (strlen($film_catalog->title) > 0): ?>
                                <?= $film_catalog->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($film_catalog->description) > 0): ?>
                            <p><?= $film_catalog->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Filmmakers -->
        <?php if (count($matching_festival_filmmakers) > 0): ?>
            <h3>Filmmakers</h3>
            <ul>
                <?php foreach ($matching_festival_filmmakers as $filmmaker): ?>
                    <li>
                        <a href="/filmmakers/<?= $filmmaker->id ?>" class="title"><?= $filmmaker->get_display_name(); ?>&nbsp;<span class="text-lowercase">(<?= $filmmaker->email; ?>)</span></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Memorabilia -->
        <?php if (count($matching_festival_memorabilia) > 0): ?>
            <h3>Festival Memorabilia</h3>
            <ul>
                <?php foreach ($matching_festival_memorabilia as $memorabilia): ?>
                    <li>
                        <a href="<?= get_relative_path($memorabilia->get_path()); ?>">
                            <?php if (strlen($memorabilia->title) > 0): ?>
                                <?= $memorabilia->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($memorabilia->description) > 0): ?>
                            <p><?= $memorabilia->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Photos -->
        <?php if (count($matching_festival_photos) > 0): ?>
            <h3>Festival Photos</h3>
            <ul>
                <?php foreach ($matching_festival_photos as $photo): ?>
                    <li>
                        <a href="<?= get_relative_path($photo->get_path()); ?>">
                            <?php if (strlen($photo->title) > 0): ?>
                                <?= $photo->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($photo->description) > 0): ?>
                            <p><?= $photo->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Posters -->
        <?php if (count($matching_festival_posters) > 0): ?>
            <h3>Festival Posters</h3>
            <ul>
                <?php foreach ($matching_festival_posters as $poster): ?>
                    <li>
                        <a href="<?= get_relative_path($poster->get_path()); ?>">
                            <?php if (strlen($poster->title) > 0): ?>
                                <?= $poster->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($poster->description) > 0): ?>
                            <p><?= $poster->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Matching Festival Print Media -->
        <?php if (count($matching_festival_print_media) > 0): ?>
            <h3>Festival Print Media</h3>
            <ul>
                <?php foreach ($matching_festival_print_media as $print_media): ?>
                    <li>
                        <a href="<?= get_relative_path($print_media->get_path()); ?>">
                            <?php if (strlen($print_media->title) > 0): ?>
                                <?= $print_media->title; ?>
                            <?php else: ?>
                                Untitled
                            <?php endif; ?>
                        </a>
                        <?php if (strlen($print_media->description) > 0): ?>
                            <p><?= $print_media->description; ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php else: ?>
        <h2>Oops!</h2>
        <p>It seems you did not search for anything.</p>
    <?php endif; ?>

</section>

<?php echo foot(); ?>
