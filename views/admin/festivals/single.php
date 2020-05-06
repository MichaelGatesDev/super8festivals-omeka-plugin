<?php
$head = array(
    'title' => $festival->get_title(),
);

queue_css_file("admin");
queue_js_file("jquery.min");

queue_css_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css");
queue_js_url("https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js");

echo head($head);
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<a class="button blue" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/edit'>Edit</a>
<a class="button red" href='/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/delete'>Delete</a>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
</style>

<section id="country-single">

    <div class="records-section">
        <h2>Film Catalogs</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/film-catalogs/add">Add Film Catalog</a>
        <?php $film_catalogs = get_all_film_catalogs_for_festival($festival->id); ?>
        <?php if (count($film_catalogs) == 0): ?>
            <p>There are no film catalogs available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/film-catalogs.php", array('film_catalogs' => $film_catalogs)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Filmmakers</h2>
        <?php $filmmakers = get_all_filmmakers_for_festival($festival->id); ?>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/filmmakers/add">Add Filmmaker</a>
        <?php if (count($filmmakers) == 0): ?>
            <p>There are no filmmakers available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/filmmakers.php", array('filmmakers' => $filmmakers)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Films</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/films/add">Add Film</a>
        <?php $films = get_all_films_for_festival($festival->id); ?>
        <?php if (count($films) == 0): ?>
            <p>There are no films available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/films.php", array('films' => $films)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Memorabilia</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/memorabilia/add">Add Memorabilia</a>
        <?php $memorabilia = get_all_memorabilia_for_festival($festival->id); ?>
        <?php if (count($memorabilia) == 0): ?>
            <p>There are no memorabilia available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/memorabilia.php", array('memorabilia' => $memorabilia)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Print Media</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/print-media/add">Add Print Media</a>
        <?php $print_medias = get_all_print_media_for_festival($festival->id); ?>
        <?php if (count($print_medias) == 0): ?>
            <p>There is no print media available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/print-media.php", array('printMediaVar' => $print_medias)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Photos</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/photos/add">Add Photo</a>
        <?php $photos = get_all_photos_for_festival($festival->id); ?>
        <?php if (count($photos) == 0): ?>
            <p>There are no photos available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/photos.php", array('photos' => $photos)); ?>
        <?php endif; ?>
    </div>

    <div class="records-section">
        <h2>Posters</h2>
        <a class="button" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/cities/<?= urlencode($city->name); ?>/festivals/<?= $festival->id; ?>/posters/add">Add Posters</a>
        <?php $posters = get_all_posters_for_festival($festival->id); ?>
        <?php if (count($posters) == 0): ?>
            <p>There are no posters available for this festival.</p>
        <?php else: ?>
            <?= $this->partial("__components/records/posters.php", array('posters' => $posters)); ?>
        <?php endif; ?>
    </div>

</section>

<?php echo foot(); ?>

