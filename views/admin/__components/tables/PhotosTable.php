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
                "Width" => 'width',
                "Height" => 'height',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($photosVar as $photo): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($photo, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($photo, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($photo, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($photo, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $photo->description; ?></td>
            <td><?= $photo->thumbnailPathFile; ?></td>
            <td><?= $photo->thumbnailPathWeb; ?></td>
            <td><?= $photo->pathFile; ?></td>
            <td><?= $photo->pathWeb; ?></td>
            <td><?= $photo->embed; ?></td>
            <td><?= $photo->width; ?></td>
            <td><?= $photo->height; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
