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
<table id="cities">
    <thead>
    <tr>
        <td style="width: 1px;">ID</td>
        <td>City Name</td>
        <td>Latitude</td>
        <td>Longitude</td>
        <td style="width: 1px;"></td>
        <td style="width: 1px;"></td>
    </tr>
    </thead>
    <?php foreach ($cities as $city): ?>
        <tr>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>"><?= $city->id; ?></a></td>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>"><?= $city->name; ?></a></td>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>"><?= $city->latitude; ?></a></td>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>"><?= $city->longitude; ?></a></td>
            <td><a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>/edit">Edit</a></td>
            <td><a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($city->get_country()->name); ?>/cities/<?= urlencode($city->name); ?>/delete">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
