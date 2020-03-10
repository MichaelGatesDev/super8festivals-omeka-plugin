<style>
    #filmmakers {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 200px;
    }

    li.filmmaker:not(:last-child) {
        margin-right: 1em;
    }

    li.filmmaker {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.filmmaker .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.filmmaker .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="filmmakers">
    <?php foreach ($filmmakers as $filmmaker): ?>
        <li class="filmmaker">
            <p>First: <?= $filmmaker->first_name; ?></p>
            <p>Last: <?= $filmmaker->last_name; ?></p>
            <p>Organization: <?= $filmmaker->organization_name; ?></p>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= $filmmaker->get_country()->name ?>/cities/<?= $filmmaker->get_city()->name; ?>/filmmakers/<?= $filmmaker->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= $filmmaker->get_country()->name ?>/cities/<?= $filmmaker->get_city()->name; ?>/filmmakers/<?= $filmmaker->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>