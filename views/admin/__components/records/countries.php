<style>
    #countries {
        margin-bottom: 1em;
        padding: 0;
    }

    .title {
        text-transform: capitalize;
    }

    a.title {
        color: #c76941;
    }

    a.title:hover {
        color: #e88347;
    }

    td {
        vertical-align: middle;
    }

    td .button {
        margin: 0;
    }

    tr td:first-child {
        width: 100%;
    }

    table {
        margin-bottom: 5em;
    }

</style>
<table id="countries">
    <?php foreach ($countries as $country): ?>
        <tr>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>"><?= $country->name ?></a></td>
            <td><a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/edit">Edit</a></td>
            <td><a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/delete">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
