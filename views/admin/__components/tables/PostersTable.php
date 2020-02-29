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
    <?php foreach ($postersVar as $poster): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($poster, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($poster, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($poster, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($poster, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $poster->description; ?></td>
            <td><?= $poster->thumbnailPathFile; ?></td>
            <td><?= $poster->thumbnailPathWeb; ?></td>
            <td><?= $poster->pathFile; ?></td>
            <td><?= $poster->pathWeb; ?></td>
            <td><?= $poster->embed; ?></td>
            <td><?= $poster->width; ?></td>
            <td><?= $poster->height; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
