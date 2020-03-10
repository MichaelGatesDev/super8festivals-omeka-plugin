<style>
    #film-catalogs {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 380px;
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

    li.film-catalog .content {
    }

    li.film-catalog .content img {
        object-fit: cover;
    }

    li.film-catalog .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="film-catalogs">
    <?php foreach ($film_catalogs as $catalog): ?>
        <?php
        $isImage = is_image_extension($catalog->get_file_type());
        $webPath = get_relative_path($catalog->get_path());
        ?>
        <li class="film-catalog">
            <a class="content" href="<?= $webPath; ?>" target="_blank">
                <?php if ($isImage): ?>
                    <img src="<?= $webPath; ?>" alt="<?= $catalog->title; ?>"/>
                <?php else: ?>
                    <p>This item can not be displayed because it is not a valid image format.</p>
                <?php endif; ?>
            </a>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= $catalog->get_country()->name ?>/cities/<?= $catalog->get_city()->name; ?>/film-catalogs/<?= $catalog->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= $catalog->get_country()->name ?>/cities/<?= $catalog->get_city()->name; ?>/film-catalogs/<?= $catalog->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>