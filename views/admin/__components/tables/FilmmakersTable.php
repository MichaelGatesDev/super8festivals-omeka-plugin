<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Email" => 'email',
                "First Name" => 'first_name',
                "Last Name" => 'last_name',
                "Organization Name" => 'organization_name',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($filmmakersVar as $filmmaker): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($filmmaker, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($filmmaker, 'email'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($filmmaker, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($filmmaker, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $filmmaker->first_name; ?></td>
            <td><?= $filmmaker->last_name; ?></td>
            <td><?= $filmmaker->organization_name; ?></td>
            <td><?= $filmmaker->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
