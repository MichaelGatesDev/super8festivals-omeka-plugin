<style>
    #memorabilia {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 450px;
    }

    li.memorabilia:not(:last-child) {
        margin-right: 1em;
    }

    li.memorabilia {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.memorabilia .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.memorabilia .content > * {
        width: 200px;
        height: 300px;
    }

    li.memorabilia embed {
        object-fit: cover;
    }

    li.memorabilia .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="memorabilia">
    <?php foreach ($memorabilia as $memorabilium): ?>
        <?php
        $isImage = is_image_extension($memorabilium->get_file_type());
        $webPath = get_relative_path($memorabilium->get_path());
        ?>
        <li class="memorabilia">
            <a class="content" href="<?= $webPath; ?>" target="_blank">
                <embed src="<?= $webPath; ?>" alt="<?= $memorabilium->title; ?>"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $memorabilium->title != "" ? $memorabilium->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $memorabilium->description != "" ? $memorabilium->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($memorabilium->get_country()->name); ?>/cities/<?= urlencode($memorabilium->get_city()->name); ?>/festivals/<?= $memorabilium->festival_id; ?>/memorabilia/<?= $memorabilium->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($memorabilium->get_country()->name); ?>/cities/<?= urlencode($memorabilium->get_city()->name); ?>/festivals/<?= $memorabilium->festival_id; ?>/memorabilia/<?= $memorabilium->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>