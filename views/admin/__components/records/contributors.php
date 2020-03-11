<style>
    #contributors {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 200px;
    }

    li.contributor:not(:last-child) {
        margin-right: 1em;
    }

    li.contributor {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.contributor .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.contributor .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="contributors">
    <?php foreach ($contributors as $contributor): ?>
        <li class="contributor">
            <p>First: <?= $contributor->first_name; ?></p>
            <p>Last: <?= $contributor->last_name; ?></p>
            <p>Organization: <?= $contributor->organization_name; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/contributors/<?= $contributor->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/contributors/<?= $contributor->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>