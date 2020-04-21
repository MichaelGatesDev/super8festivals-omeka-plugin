<?php
$festivals = get_all_festivals_in_city($city->id);
usort($festivals, function ($a, $b) {
    return $a->year > $b->year;
});
$all_city_records = array();
switch ($record_type) {
    case Super8FestivalsRecordType::FestivalFilm:
        $all_city_records = get_all_films_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalFilmCatalog:
        $all_city_records = get_all_film_catalogs_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalFilmmaker:
        $all_city_records = get_all_filmmakers_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalMemorabilia:
        $all_city_records = get_all_memorabilia_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalPhoto:
        $all_city_records = get_all_photos_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalPoster:
        $all_city_records = get_all_posters_for_city($city->id);
        break;
    case Super8FestivalsRecordType::FestivalPrintMedia:
        $all_city_records = get_all_print_media_for_city($city->id);
        break;
}
?>

<section id="<?= $section_id ?>" class="container mt-5 p-4 bg-light">
    <div class="row">
        <div class="col">
            <h3 class="pt-2 pb-2 title"><?= $section_title; ?></h3>
            <span class="text-muted">
                <?= strtr($section_description, array(
                    "{city_name}" => "<span class='title'>" . $city->name . "</span>",
                    "{records_name}" => $records_name,
                )); ?>
             </span>
        </div>
    </div>
    <div class="row pt-4">
        <div class="col">
            <?php if (count($all_city_records) > 0): ?>
                <?php foreach ($festivals as $festival): ?>
                    <?php if (count($records = get_festival_records_by_type($festival->id, $record_type)) > 0): ?>
                        <div class="row">
                            <div class="col">
                                <h4 class="title"><?= strpos($festival->title, "default festival") ? "uncategorized" : $festival->get_title(); ?></h4>
                                <div class="card-columns">
                                    <?php foreach ($records as $record): ?>
                                        <?= $this->partial("__components/cards/document-card.php", array("document" => $record)); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>
                    <?= strtr($section_no_records_msg, array(
                        "{city_name}" => "<span class='title'>" . $city->name . "</span>",
                        "{records_name}" => $records_name,
                    )); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>