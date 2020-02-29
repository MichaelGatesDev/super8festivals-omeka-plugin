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
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($memorabiliaVar as $memorabilia): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($memorabilia, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($memorabilia, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($memorabilia, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($memorabilia, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $memorabilia->description; ?></td>
            <td><?= $memorabilia->thumbnailPathFile; ?></td>
            <td><?= $memorabilia->thumbnailPathWeb; ?></td>
            <td><?= $memorabilia->pathFile; ?></td>
            <td><?= $memorabilia->pathWeb; ?></td>
            <td><?= $memorabilia->embed; ?></td>
            <td><?= $memorabilia->width; ?></td>
            <td><?= $memorabilia->height; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
