<?php
echo head(array(
    'title' => $city->name,
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<div style="padding-bottom: 1em;">
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/edit'>Edit</a>
    <a href='/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/delete'>Delete</a>
</div>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #content-heading {
        text-transform: capitalize;
    }

    .header-element {
        font-size: 15px;
    }

    .records-section {
        padding: 1em;
    }

    .records-section:nth-child(odd) {
        background-color: #ffffff;
    }

    .records-section:nth-child(even) {
        background-color: #f2f2f2;
    }

    .anchor-buttons {
        margin: 0;
        padding: 0;
    }

    .anchor-buttons li {
        list-style-type: none;
        display: inline-block;
    }

    .anchor-buttons a, a:visited {
        color: #c76941;
    }

    .anchor-buttons a:hover {
        color: #e88347;
    }
</style>

<section id="country-single">

    <div class="records-section">
        <h2>Film Catalogs</h2>
        <?php $film_catalogs = get_all_film_catalogs_for_city($city->id); ?>
        <?php if (count($film_catalogs) == 0): ?>
            <p>There are no film catalogs available for this city.</p>
        <?php else: ?>
            <ul id="film-catalogs">
                <?php foreach ($film_catalogs as $catalog): ?>
                    <li>
                        <p><?= $catalog->title; ?></p>
                        <p><?= $catalog->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/film-catalogs/add">Add Film Catalog</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Filmmakers</h2>
        <?php $filmmakers = get_all_filmmakers_for_city($city->id); ?>
        <?php if (count($filmmakers) == 0): ?>
            <p>There are no filmmakers available for this city.</p>
        <?php else: ?>
            <ul id="filmmakers">
                <?php foreach ($filmmakers as $filmmaker): ?>
                    <li>
                        <p><?= $filmmaker->first_name; ?></p>
                        <p><?= $filmmaker->last_name; ?></p>
                        <p><?= $filmmaker->organization_name; ?></p>
                        <p><?= $filmmaker->email; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/filmmakers/add">Add Filmmaker</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Films</h2>
        <?php $films = get_all_films_for_city($city->id); ?>
        <?php if (count($films) == 0): ?>
            <p>There are no films available for this city.</p>
        <?php else: ?>
            <ul id="films">
                <?php foreach ($films as $film): ?>
                    <?php
                    $contributor = $film->get_contributor();
                    ?>
                    <li>
                        <p><?= $film->title; ?></p>
                        <p><?= $film->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/films/add">Add Film</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Memorabilia</h2>
        <?php $memorabilia = get_all_memorabilia_for_city($city->id); ?>
        <?php if (count($memorabilia) == 0): ?>
            <p>There are no memorabilia available for this city.</p>
        <?php else: ?>
            <ul id="memorabilia">
                <?php foreach ($memorabilia as $mem): ?>
                    <?php
                    $contributor = $mem->get_contributor();
                    ?>
                    <li>
                        <p><?= $mem->title; ?></p>
                        <p><?= $mem->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/memorabilia/add">Add Memorabilia</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Print Media</h2>
        <?php $printMedia = get_all_print_media_for_city($city->id); ?>
        <?php if (count($printMedia) == 0): ?>
            <p>There are no print media available for this city.</p>
        <?php else: ?>
            <ul id="memorabilia">
                <?php foreach ($printMedia as $media): ?>
                    <?php
                    $contributor = $media->get_contributor();
                    ?>
                    <li>
                        <p><?= $media->title; ?></p>
                        <p><?= $media->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/print-media/add">Add Print Media</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Photos</h2>
        <?php $photos = get_all_photos_for_city($city->id); ?>
        <?php if (count($photos) == 0): ?>
            <p>There are no photos available for this city.</p>
        <?php else: ?>
            <ul id="memorabilia">
                <?php foreach ($photos as $photo): ?>
                    <?php
                    $contributor = $photo->get_contributor();
                    ?>
                    <li>
                        <p><?= $photo->title; ?></p>
                        <p><?= $photo->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/photos/add">Add Photo</a>
            </li>
        </ul>
    </div>

    <div class="records-section">
        <h2>Posters</h2>
        <?php $posters = get_all_posters_for_city($city->id); ?>
        <?php if (count($posters) == 0): ?>
            <p>There are no posters available for this city.</p>
        <?php else: ?>
            <ul id="memorabilia">
                <?php foreach ($posters as $poster): ?>
                    <?php
                    $contributor = $poster->get_contributor();
                    ?>
                    <li>
                        <p><?= $poster->title; ?></p>
                        <p><?= $poster->description; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <ul class="anchor-buttons">
            <li>
                <a href="/admin/super-eight-festivals/countries/<?= $country->name ?>/cities/<?= $city->name; ?>/posters/add">Add Poster</a>
            </li>
        </ul>
    </div>

</section>

<?php echo foot(); ?>

