<?php
if (!isset($records)) $records = array();
if (!isset($root_url)) $root_url = "/";

$posters = array_key_exists("posters", $records) ? $records["posters"] : array();
$photos = array_key_exists("photos", $records) ? $records["photos"] : array();
$print_media = array_key_exists("print_media", $records) ? $records["print_media"] : array();
$memorabilia = array_key_exists("memorabilia", $records) ? $records["memorabilia"] : array();
$films = array_key_exists("films", $records) ? $records["films"] : array();
$filmmakers = array_key_exists("filmmakers", $records) ? $records["filmmakers"] : array();
$film_catalogs = array_key_exists("film_catalogs", $records) ? $records["film_catalogs"] : array();
?>
<!-- Posters -->
<div class="row" id="posters">
    <div class="col">
        <h3>
            Posters (<?= count($posters); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/posters/add">Add Poster</a>
            <?php endif; ?>
        </h3>
        <?php if (count($posters) == 0): ?>
            <p>There are no posters available.</p>
        <?php else: ?>
            <?php foreach ($posters as $poster): ?>
                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $poster->title == "" ? "Untitled" : $poster->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $poster->description == "" ? "No description" : $poster->description,
                ));
                array_push($information, array(
                    "key" => "festival",
                    "value" => $poster->get_festival()->year == 0 ? "Uncategorized" : $poster->get_festival()->year,
                ));
                $contributor = $poster->get_contributor();
                $contributor_id = $poster->contributor_id;
                if ($poster->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $poster->contributor_id === 0 ? "No contributor" : $poster->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
                    'preview_path' => get_relative_path($poster->get_path()),
                    'fancybox_category' => 'posters',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/posters/' . $poster->id . "/edit",
                    'delete_url' => $root_url . '/posters/' . $poster->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Photos -->
<div class="row" id="photos">
    <div class="col">
        <h3>
            Photos (<?= count($photos); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/photos/add">Add Photo</a>
            <?php endif; ?>
        </h3>
        <?php if (count($photos) == 0): ?>
            <p>There are no photos available.</p>
        <?php else: ?>
            <?php foreach ($photos as $photo): ?>
                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $photo->title == "" ? "Untitled" : $photo->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $photo->description == "" ? "No description" : $photo->description,
                ));
                array_push($information, array(
                    "key" => "festival",
                    "value" => $photo->get_festival()->year == 0 ? "Uncategorized" : $photo->get_festival()->year,
                ));
                $contributor = $photo->get_contributor();
                $contributor_id = $photo->contributor_id;
                if ($poster->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $contributor == null || $photo->contributor_id == 0 ? "No contributor" : $photo->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($photo->get_thumbnail_path()),
                    'preview_path' => get_relative_path($photo->get_path()),
                    'fancybox_category' => 'photos',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/photos/' . $photo->id . "/edit",
                    'delete_url' => $root_url . '/photos/' . $photo->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Print Media-->
<div class="row" id="print-media">
    <div class="col">
        <h3>
            Print Media (<?= count($print_media); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/print-media/add">Add Print Media</a>
            <?php endif; ?>
        </h3>
        <?php if (count($print_media) == 0): ?>
            <p>There is no print media available.</p>
        <?php else: ?>
            <?php foreach ($print_media as $print_medium): ?>

                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $print_medium->title == "" ? "Untitled" : $print_medium->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $print_medium->description == "" ? "No description" : $print_medium->description,
                ));
                array_push($information, array(
                    "key" => "festival",
                    "value" => $print_medium->get_festival()->year == 0 ? "Uncategorized" : $print_medium->get_festival()->year,
                ));
                $contributor = $print_medium->get_contributor();
                $contributor_id = $print_medium->contributor_id;
                if ($print_medium->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $print_medium->contributor_id === 0 ? "No contributor" : $print_medium->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($print_medium->get_thumbnail_path()),
                    'preview_path' => get_relative_path($print_medium->get_path()),
                    'fancybox_category' => 'print-media',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/print-media/' . $print_medium->id . "/edit",
                    'delete_url' => $root_url . '/print-media/' . $print_medium->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Memorabilia -->
<div class="row" id="memorabilia">
    <div class="col">
        <h3>
            Memorabilia (<?= count($memorabilia); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/memorabilia/add">Add Memorabilia</a>
            <?php endif; ?>
        </h3>
        <?php if (count($memorabilia) == 0): ?>
            <p>There are no memorabilia available.</p>
        <?php else: ?>
            <?php foreach ($memorabilia as $memorabilium): ?>
                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $memorabilium->title == "" ? "Untitled" : $memorabilium->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $memorabilium->description == "" ? "No description" : $memorabilium->description,
                ));
                array_push($information, array(
                    "key" => "festival",
                    "value" => $memorabilium->get_festival()->year == 0 ? "Uncategorized" : $memorabilium->get_festival()->year,
                ));
                $contributor = $memorabilium->get_contributor();
                $contributor_id = $memorabilium->contributor_id;
                if ($memorabilium->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $memorabilium->contributor_id === 0 ? "No contributor" : $memorabilium->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($memorabilium->get_thumbnail_path()),
                    'preview_path' => get_relative_path($memorabilium->get_path()),
                    'fancybox_category' => 'memorabilia',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/memorabilia/' . $memorabilium->id . "/edit",
                    'delete_url' => $root_url . '/memorabilia/' . $memorabilium->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Films -->
<div class="row" id="films">
    <div class="col">
        <h3>
            Films (<?= count($films); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/films/add">Add Film</a>
            <?php endif; ?>
        </h3>
        <?php if (count($films) == 0): ?>
            <p>There are no films available.</p>
        <?php else: ?>
            <div class="row row-cols">
                <?php foreach ($films as $film): ?>
                    <?php
                    $information = array();
                    array_push($information, array(
                        "key" => "title",
                        "value" => $film->title == "" ? "Untitled" : $film->title,
                    ));
                    array_push($information, array(
                        "key" => "description",
                        "value" => $film->description == "" ? "No description" : $film->description,
                    ));
                    array_push($information, array(
                        "key" => "festival",
                        "value" => $film->get_festival()->year == 0 ? "Uncategorized" : $film->get_festival()->year,
                    ));
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $film->contributor_id === 0 ? "No contributor" : $film->get_contributor()->get_display_name(),
                    ));
                    $filmmaker = $film->get_filmmaker();
                    $filmmaker_id = $film->filmmaker_id;
                    if ($film->contributor_id != 0 && $filmmaker != null) {
                        array_push($information, array(
                            "key" => "filmmaker",
                            "value" => $filmmaker == null || $filmmaker_id == 0 ? "No filmmaker" : "<a href='/filmmakers/$filmmaker_id/'>" . $filmmaker->get_full_name() . "</a>",
                        ));
                    }
                    echo $this->partial("__components/record-card.php", array(
                        'card_width' => '500px',
//                            'preview_height' => '300px',
                        'embed' => $film->embed,
//                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($poster->get_path()),
                        'fancybox_category' => 'films',
                        'information' => $information,
                        'admin' => $admin,
                        'edit_url' => $root_url . '/films/' . $film->id . "/edit",
                        'delete_url' => $root_url . '/films/' . $film->id . "/delete",
                    )); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Filmmakers -->
<div class="row" id="filmmakers">
    <div class="col">
        <h3>
            Filmmakers (<?= count($filmmakers); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/filmmakers/add">Add Filmmaker</a>
            <?php endif; ?>
        </h3>
        <?php if (count($filmmakers) == 0): ?>
            <p>There are no filmmakers available.</p>
        <?php else: ?>
            <div class="row row-cols">
                <?php foreach ($filmmakers as $filmmaker): ?>
                    <?php
                    $information = array();
                    array_push($information, array(
                        "key" => "Name",
                        "value" => $filmmaker->get_full_name() == "" ? "No name" : $filmmaker->get_full_name(),
                    ));
                    array_push($information, array(
                        "key" => "email",
                        "value" => $filmmaker->email == "" ? "No email" : $filmmaker->email,
                    ));
                    echo $this->partial("__components/record-card.php", array(
                        'card_width' => '300px',
//                            'preview_height' => '300px',
                        'embed' => $filmmaker->embed,
//                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($poster->get_path()),
                        'fancybox_category' => 'filmmakers',
                        'information' => $information,
                        'admin' => $admin,
                        'edit_url' => $root_url . '/filmmakers/' . $filmmaker->id . "/edit",
                        'delete_url' => $root_url . '/filmmakers/' . $filmmaker->id . "/delete",
                    )); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Film Catalogs -->
<div class="row" id="film-catalogs">
    <div class="col">
        <h3>
            Film Catalogs (<?= count($film_catalogs); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/film-catalogs/add">Add Film Catalog</a>
            <?php endif; ?>
        </h3>
        <?php if (count($film_catalogs) == 0): ?>
            <p>There are no film catalogs available.</p>
        <?php else: ?>
            <div class="row row-cols">
                <?php foreach ($film_catalogs as $film_catalog): ?>
                    <?php
                    $information = array();
                    array_push($information, array(
                        "key" => "title",
                        "value" => $film_catalog->title == "" ? "Untitled" : $film_catalog->title,
                    ));
                    array_push($information, array(
                        "key" => "description",
                        "value" => $film_catalog->description == "" ? "No description" : $film_catalog->description,
                    ));
                    array_push($information, array(
                        "key" => "festival",
                        "value" => $film_catalog->get_festival()->year == 0 ? "Uncategorized" : $film_catalog->get_festival()->year,
                    ));
                    $contributor = $film_catalog->get_contributor();
                    $contributor_id = $film_catalog->contributor_id;
                    if ($film_catalog->contributor_id != 0 && $contributor != null) {
                        array_push($information, array(
                            "key" => "contributor",
                            "value" => $film_catalog->contributor_id === 0 ? "No contributor" : $film_catalog->get_contributor()->get_display_name(),
                        ));
                    }
                    echo $this->partial("__components/record-card.php", array(
                        'card_width' => '300px',
                        'preview_height' => '300px',
                        // 'embed' => $film->embed,
                        'thumbnail_path' => get_relative_path($film_catalog->get_thumbnail_path()),
                        'preview_path' => get_relative_path($film_catalog->get_path()),
                        'fancybox_category' => 'film-catalogs',
                        'information' => $information,
                        'admin' => $admin,
                        'edit_url' => $root_url . '/film-catalogs/' . $film_catalog->id . "/edit",
                        'delete_url' => $root_url . '/film-catalogs/' . $film_catalog->id . "/delete",
                    )); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>