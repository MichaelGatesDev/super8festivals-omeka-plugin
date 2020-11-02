<?php
echo head(array(
    'title' => 'Debug',
));
?>

<?php echo flash(); ?>

<section class="container">
    <?= $this->partial("__components/breadcrumbs.php"); ?>


    <h2>File Relocation Results</h2>

    <?php

    function find_and_move($file)
    {
        $matches = find_path_to_file($file);
        if (count($matches) === 0) {
            echo "<p class='text-muted'>No matches found for file: {$file}</p>";
            return;
        }
        foreach ($matches as $current_location) {
            $final_location = get_uploads_dir() . "/" . $file;
            if ($current_location == $final_location) {
                echo "<p class='text-muted'>{$file} Already in uploads folder</p>";
                continue;
            }
            if (rename($current_location, $final_location)) {
                echo "<p>Moved {$current_location} to {$final_location}</p>";
            } else {
                echo "<p class='text-danger'>Failed to move file</p>";
            }
        }
    }

    echo "<h3>SuperEightFestivalsCityBanner</h3>";
    foreach (SuperEightFestivalsCityBanner::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFederationBylaw</h3>";
    foreach (SuperEightFestivalsFederationBylaw::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFederationMagazine</h3>";
    foreach (SuperEightFestivalsFederationMagazine::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFederationNewsletter</h3>";
    foreach (SuperEightFestivalsFederationNewsletter::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFederationPhoto</h3>";
    foreach (SuperEightFestivalsFederationPhoto::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFestivalPhoto</h3>";
    foreach (SuperEightFestivalsFestivalPhoto::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFestivalPoster</h3>";
    foreach (SuperEightFestivalsFestivalPoster::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFestivalPrintMedia</h3>";
    foreach (SuperEightFestivalsFestivalPrintMedia::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }

    echo "<h3>SuperEightFestivalsFilmmakerPhoto</h3>";
    foreach (SuperEightFestivalsFilmmakerPhoto::get_all() as $record) {
        find_and_move($record['file_name']);
        find_and_move($record['thumbnail_file_name']);
    }
    ?>

</section>


<?php echo foot(); ?>
