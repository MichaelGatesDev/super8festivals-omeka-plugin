<style>
    #film-catalogs {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        /*height: 500px;*/
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
    <?php foreach ($film_catalogs as $catalog): ?>
        <li class="film-catalog">
            <a class="content" href="<?= get_relative_path($catalog->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($catalog->get_thumbnail_path()); ?>" alt="<?= $catalog->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $catalog->title != "" ? $catalog->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $catalog->description != "" ? $catalog->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($catalog->get_country()->name); ?>/cities/<?= urlencode($catalog->get_city()->name); ?>/festivals/<?= $catalog->festival_id; ?>/film-catalogs/<?= $catalog->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($catalog->get_country()->name); ?>/cities/<?= urlencode($catalog->get_city()->name); ?>/festivals/<?= $catalog->festival_id; ?>/film-catalogs/<?= $catalog->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(".pdf-preview").each((index, elem) => {
    });
</script>