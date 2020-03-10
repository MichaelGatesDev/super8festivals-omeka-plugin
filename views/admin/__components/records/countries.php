<style>
    thead tr {
        background-color: #e0e0e0;
    }

    thead td {
        font-weight: bold;
        padding: 0.25em;
    }

    tbody tr:hover {
        background-color: #f0f0f0;
    }

    td {
        vertical-align: middle;
        padding: 0;
    }

    td a {
        display: block;
        padding: 0.5em;
    }

    td a.title {
        color: #c76941;
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
