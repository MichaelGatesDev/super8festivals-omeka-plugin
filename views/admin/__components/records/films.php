<style>
    #films {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 380px;
    }

    li.film:not(:last-child) {
        margin-right: 1em;
    }

    li.film {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.film .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.film .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.film .content {
    }

    li.film .content img {
        object-fit: cover;
    }

    li.film .content p {
        margin: 0;
        padding: 0;
    }

    iframe {
        width: 300px;
        height: 200px;
    }
</style>
<ul id="films">
    <?php foreach ($films as $film): ?>
        <li class="film">
            <?= $film->embed; ?>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $film->title; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $film->description != "" ? $film->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($film->get_country()->name); ?>/cities/<?= urlencode($film->get_city()->name); ?>/festivals/<?= $film->festival_id; ?>/films/<?= $film->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($film->get_country()->name); ?>/cities/<?= urlencode($film->get_city()->name); ?>/festivals/<?= $film->festival_id; ?>/films/<?= $film->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>