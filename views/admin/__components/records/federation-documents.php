<style>
    #federation-documents {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        /*height: 500px;*/
    }

    li.federation-document:not(:last-child) {
        margin-right: 1em;
    }

    li.federation-document {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.federation-document .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.federation-document .content > * {
        /*border: 1px dashed red;*/
        width: 200px;
        height: 300px;
    }

    li.federation-document embed {
        object-fit: cover;
    }

    li.federation-document .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="federation-documents">
    <?php foreach ($federation_documents as $document): ?>
        <li class="federation-document">
            <a class="content" href="<?= get_relative_path($document->get_thumbnail_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($document->get_thumbnail_path()); ?>" alt="<?= $document->title; ?>" style="object-fit: contain"/>
            </a>
            <p class=""><span style="font-weight: bold;">Title: </span><?= $document->title != "" ? $document->title : "N/A"; ?></p>
            <p class=""><span style="font-weight: bold;">Description: </span><?= $document->description != "" ? $document->description : "N/A"; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/federation/documents/<?= $document->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/federation/documents/<?= $document->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>

<script>
    $(".pdf-preview").each((index, elem) => {
    });
</script>