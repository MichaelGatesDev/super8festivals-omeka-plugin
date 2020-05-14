<style>
    #film-catalogs {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 500px;
    }

    li.film-catalog:not(:last-child) {
        margin-right: 1em;
    }

    li.film-catalog {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.film-catalog .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.film-catalog .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.film-catalog embed {
        object-fit: cover;
    }

    li.film-catalog .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="film-catalogs">
    <?php foreach ($printMediaVar as $print_media): ?>
        <li class="film-catalog">
            <a class="content" href="<?= get_relative_path($print_media->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($print_media->get_thumbnail_path()); ?>" alt="<?= $print_media->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $print_media->title != "" ? $print_media->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $print_media->description != "" ? $print_media->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($print_media->get_country()->name); ?>/cities/<?= urlencode($print_media->get_city()->name); ?>/festivals/<?= $print_media->festival_id; ?>/print-media/<?= $print_media->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($print_media->get_country()->name); ?>/cities/<?= urlencode($print_media->get_city()->name); ?>/festivals/<?= $print_media->festival_id; ?>/print-media/<?= $print_media->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>