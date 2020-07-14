<?php
if (!isset($records)) $records = array();
if (!isset($root_url)) $root_url = "/";
if (!isset($filmmakers_url)) $filmmakers_url = "add";

$newsletters = array_key_exists("newsletters", $records) ? $records["newsletters"] : array();
$photos = array_key_exists("photos", $records) ? $records["photos"] : array();
$magazines = array_key_exists("magazines", $records) ? $records["magazines"] : array();
$by_laws = array_key_exists("by_laws", $records) ? $records["by_laws"] : array();
?>
<!-- Newsletters -->
<div class="row" id="newsletters">
    <div class="col">
        <h3>
            Newsletters (<?= count($newsletters); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/newsletters/add">Add Newsletter</a>
            <?php endif; ?>
        </h3>
        <?php if (count($newsletters) == 0): ?>
            <p>There are no newsletters available.</p>
        <?php else: ?>
            <?php foreach ($newsletters as $newsletter): ?>
                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $newsletter->title == "" ? "Untitled" : $newsletter->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $newsletter->description == "" ? "No description" : $newsletter->description,
                ));
                $contributor = $newsletter->get_contributor();
                $contributor_id = $newsletter->contributor_id;
                if ($newsletter->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $newsletter->contributor_id === 0 ? "No contributor" : $newsletter->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
//                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($newsletter->get_thumbnail_path()),
                    'preview_path' => get_relative_path($newsletter->get_path()),
                    'fancybox_category' => 'newsletters',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/newsletters/' . $newsletter->id . "/edit",
                    'delete_url' => $root_url . '/newsletters/' . $newsletter->id . "/delete",
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
                $contributor = $photo->get_contributor();
                $contributor_id = $photo->contributor_id;
                if ($newsletter->contributor_id != 0 && $contributor != null) {
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

<!-- Magazines-->
<div class="row" id="magazines">
    <div class="col">
        <h3>
            Magazines (<?= count($magazines); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/magazines/add">Add Magazines</a>
            <?php endif; ?>
        </h3>
        <?php if (count($magazines) == 0): ?>
            <p>There is no print media available.</p>
        <?php else: ?>
            <?php foreach ($magazines as $magazine): ?>

                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $magazine->title == "" ? "Untitled" : $magazine->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $magazine->description == "" ? "No description" : $magazine->description,
                ));
                $contributor = $magazine->get_contributor();
                $contributor_id = $magazine->contributor_id;
                if ($magazine->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $magazine->contributor_id === 0 ? "No contributor" : $magazine->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($magazine->get_thumbnail_path()),
                    'preview_path' => get_relative_path($magazine->get_path()),
                    'fancybox_category' => 'magazines',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/magazines/' . $magazine->id . "/edit",
                    'delete_url' => $root_url . '/magazines/' . $magazine->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- By-Laws -->
<div class="row" id="by_law">
    <div class="col">
        <h3>
            By-Laws (<?= count($by_laws); ?>)
            <?php if ($admin): ?>
                <a class="btn btn-success btn-sm" href="<?= $root_url; ?>/bylaws/add">Add By-Law</a>
            <?php endif; ?>
        </h3>
        <?php if (count($by_laws) == 0): ?>
            <p>There are no by_law available.</p>
        <?php else: ?>
            <?php foreach ($by_laws as $by_law): ?>
                <?php
                $information = array();
                array_push($information, array(
                    "key" => "title",
                    "value" => $by_law->title == "" ? "Untitled" : $by_law->title,
                ));
                array_push($information, array(
                    "key" => "description",
                    "value" => $by_law->description == "" ? "No description" : $by_law->description,
                ));
                $contributor = $by_law->get_contributor();
                $contributor_id = $by_law->contributor_id;
                if ($by_law->contributor_id != 0 && $contributor != null) {
                    array_push($information, array(
                        "key" => "contributor",
                        "value" => $by_law->contributor_id === 0 ? "No contributor" : $by_law->get_contributor()->get_display_name(),
                    ));
                }
                echo $this->partial("__components/record-card.php", array(
                    'card_width' => '300px',
                    'preview_height' => '300px',
                    // 'embed' => $film->embed,
                    'thumbnail_path' => get_relative_path($by_law->get_thumbnail_path()),
                    'preview_path' => get_relative_path($by_law->get_path()),
                    'fancybox_category' => 'by_law',
                    'information' => $information,
                    'admin' => $admin,
                    'edit_url' => $root_url . '/bylaws/' . $by_law->id . "/edit",
                    'delete_url' => $root_url . '/bylaws/' . $by_law->id . "/delete",
                )); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
