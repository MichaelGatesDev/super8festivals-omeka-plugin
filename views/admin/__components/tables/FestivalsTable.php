<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Year" => 'year',
                "Title" => 'title',
                "Description" => 'description',
                "City" => 'city_id',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($festivalsVar as $festival): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($festival, 'view')); ?>">
                        <?php echo metadata($festival, 'year'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($festival, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($festival, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $festival->title; ?></td>
            <td><?= $festival->description; ?></td>
            <td><?= $festival->getCity()->name; ?></td>
            <td><?= $festival->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
