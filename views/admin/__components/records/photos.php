<style>
    #photos {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 500px;
    }

    li.photo:not(:last-child) {
        margin-right: 1em;
    }

    li.photo {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.photo .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.photo .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.photo img {
        object-fit: cover;
    }

    li.photo .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="photos">
    <?php foreach ($photos as $photo): ?>
        <li class="photo">
            <a class="content" href="<?= get_relative_path($photo->get_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="<?= $photo->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $photo->title != "" ? $photo->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $photo->description != "" ? $photo->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($photo->get_country()->name); ?>/cities/<?= urlencode($photo->get_city()->name); ?>/festivals/<?= $photo->festival_id; ?>/photos/<?= $photo->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($photo->get_country()->name); ?>/cities/<?= urlencode($photo->get_city()->name); ?>/festivals/<?= $photo->festival_id; ?>/photos/<?= $photo->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>