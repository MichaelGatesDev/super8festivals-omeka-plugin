<style>
    #federation-newsletters {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        /*height: 500px;*/
    }

    li.federation-newsletter:not(:last-child) {
        margin-right: 1em;
    }

    li.federation-newsletter {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.federation-newsletter .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.federation-newsletter .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.federation-newsletter embed {
        object-fit: cover;
    }

    li.federation-newsletter .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="federation-newsletters">
    <?php foreach ($federation_newsletters as $newsletter): ?>
        <li class="federation-newsletter">
            <a class="content" href="<?= get_relative_path($newsletter->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($newsletter->get_thumbnail_path()); ?>" alt="<?= $newsletter->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $newsletter->title != "" ? $newsletter->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $newsletter->description != "" ? $newsletter->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/federation/newsletters/<?= $newsletter->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/federation/newsletters/<?= $newsletter->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(".pdf-preview").each((index, elem) => {
    });
</script>