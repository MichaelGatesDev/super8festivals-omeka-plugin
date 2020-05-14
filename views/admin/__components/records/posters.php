<style>
    #posters {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 500px;
    }

    li.poster:not(:last-child) {
        margin-right: 1em;
    }

    li.poster {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.poster .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.poster .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.poster img {
        object-fit: cover;
    }

    li.poster .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="posters">
    <?php foreach ($posters as $poster): ?>
        <li class="poster">
            <a class="content" href="<?= get_relative_path($poster->get_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($poster->get_thumbnail_path()); ?>" alt="<?= $poster->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $poster->title != "" ? $poster->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $poster->description != "" ? $poster->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($poster->get_country()->name); ?>/cities/<?= urlencode($poster->get_city()->name); ?>/festivals/<?= $poster->festival_id; ?>/posters/<?= $poster->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($poster->get_country()->name); ?>/cities/<?= urlencode($poster->get_city()->name); ?>/festivals/<?= $poster->festival_id; ?>/posters/<?= $poster->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>