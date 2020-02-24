<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Name" => 'name',
                "Country" => 'country_id',
                "Latitude" => 'latitude',
                "Longitude" => 'longitude',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($citiesVar as $city): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($city, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($city, 'name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($city, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($city, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $city->getCountry()->name; ?></td>
            <td><?= $city->latitude; ?></td>
            <td><?= $city->longitude; ?></td>
            <td><?= $city->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
