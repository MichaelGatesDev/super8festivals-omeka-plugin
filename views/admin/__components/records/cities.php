<style>
    #cities {
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
