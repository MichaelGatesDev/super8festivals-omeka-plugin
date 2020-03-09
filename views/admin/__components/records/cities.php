<style>
    #cities {
        margin-bottom: 1em;
        padding: 0;
    }

    .title {
        text-transform: capitalize;
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
<table id="cities">
    <?php foreach ($cities as $city): ?>
        <tr>
            <td><a class="title" href="/admin/super-eight-festivals/countries/<?= $city->get_country()->name; ?>/cities/<?= $city->name; ?>"><?= $city->name ?></a></td>
            <td><a class="button blue" href="/admin/super-eight-festivals/countries/<?= $city->get_country()->name; ?>/cities/<?= $city->name; ?>/edit">Edit</a></td>
            <td><a class="button red" href="/admin/super-eight-festivals/countries/<?= $city->get_country()->name; ?>/cities/<?= $city->name; ?>/delete">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
