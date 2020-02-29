<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Title" => 'title',
                "Description" => 'description',
                "Thumbnail Path (File)" => 'thumbnail_path_file',
                "Thumbnail Path (Web)" => 'thumbnail_path_web',
                "Path (File)" => 'path_file',
                "Path (Web)" => 'path_web',
                "Embed Code" => 'embed',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($filmCatalogsVar as $catalog): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($catalog, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($catalog, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($catalog, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($catalog, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $catalog->description; ?></td>
            <td><?= $catalog->thumbnail_path_file; ?></td>
            <td><?= $catalog->thumbnail_path_web; ?></td>
            <td><?= $catalog->path_file; ?></td>
            <td><?= $catalog->path_web; ?></td>
            <td><?= html_escape($catalog->embed); ?></td>
            <td><?= $catalog->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
