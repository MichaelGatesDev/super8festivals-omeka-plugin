<style>
    #federation-magazines {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        /*height: 500px;*/
    }

    li.federation-magazine:not(:last-child) {
        margin-right: 1em;
    }

    li.federation-magazine {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.federation-magazine .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.federation-magazine .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.federation-magazine embed {
        object-fit: cover;
    }

    li.federation-magazine .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="federation-magazines">
    <?php foreach ($federation_magazines as $magazine): ?>
        <li class="federation-magazine">
            <a class="content" href="<?= get_relative_path($magazine->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($magazine->get_thumbnail_path()); ?>" alt="<?= $magazine->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $magazine->title != "" ? $magazine->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $magazine->description != "" ? $magazine->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/federation/magazines/<?= $magazine->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/federation/magazines/<?= $magazine->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(".pdf-preview").each((index, elem) => {
    });
</script>