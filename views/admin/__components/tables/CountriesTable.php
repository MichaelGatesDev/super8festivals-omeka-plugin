<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Name" => 'name',
                "Latitude" => 'latitude',
                "Longitude" => 'longitude',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($countriesVar as $country): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($country, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($country, 'name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($country, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($country, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $country->latitude; ?></td>
            <td><?= $country->longitude ?></td>
            <td><?= $country->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>