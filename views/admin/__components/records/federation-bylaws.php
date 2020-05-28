<style>
    #federation-bylaws {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        /*height: 500px;*/
    }

    li.federation-bylaw:not(:last-child) {
        margin-right: 1em;
    }

    li.federation-bylaw {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.federation-bylaw .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.federation-bylaw .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.federation-bylaw embed {
        object-fit: cover;
    }

    li.federation-bylaw .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="federation-bylaws">
    <?php foreach ($federation_bylaws as $bylaw): ?>
        <li class="federation-bylaw">
            <a class="content" href="<?= get_relative_path($bylaw->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($bylaw->get_thumbnail_path()); ?>" alt="<?= $bylaw->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $bylaw->title != "" ? $bylaw->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $bylaw->description != "" ? $bylaw->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/federation/bylaws/<?= $bylaw->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/federation/bylaws/<?= $bylaw->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(".pdf-preview").each((index, elem) => {
    });
</script>