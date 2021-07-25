<table class="table table-responsive table-striped table-hover">
    <thead>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Latitude</td>
        <td>Longitude</td>
        <td>Actions</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $countries = SuperEightFestivalsCountry::get_all();
    ?>
    <?php foreach ($countries as $country): ?>
        <?php
        $loc = $country->get_location();
        ?>
        <tr class="">
            <td><?= $country->id; ?></td>
            <td><?= $loc->name; ?></td>
            <td><?= $loc->latitude; ?></td>
            <td><?= $loc->longitude; ?></td>
            <td>
                <a class="btn btn-primary btn-sm" href="<?= build_admin_url(["countries", $loc->name]); ?>">
                    View
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>