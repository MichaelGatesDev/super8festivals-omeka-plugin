<style>
    #countries {
        margin-bottom: 1em;
        padding: 0;
    }

    a.title {
        color: #c76941;
    }

    a.title:hover {
        color: #e88347;
    }

    thead td {
        font-weight: bold;
    }

    td {
        vertical-align: middle;
    }

    td .button {
        margin: 0;
    }

    table {
        margin-bottom: 5em;
    }

</style>
<table id="countries">
    <thead>
    <tr>
        <td style="width: 1px;">ID</td>
        <td>City Name</td>
        <td style="width: 1px;"></td>
        <td style="width: 1px;"></td>
    </tr>
    </thead>
    <?php foreach ($countries as $country): ?>
        <tr>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>"><?= $country->id; ?></a></td>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>"><?= $country->name; ?></a></td>
            <td><a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/edit">Edit</a></td>
            <td><a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($country->name); ?>/delete">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
