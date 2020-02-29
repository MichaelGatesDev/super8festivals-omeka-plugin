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
    <?php foreach ($printMediaVar as $print): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($print, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($print, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($print, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($print, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $print->description; ?></td>
            <td><?= $print->thumbnailPathFile; ?></td>
            <td><?= $print->thumbnailPathWeb; ?></td>
            <td><?= $print->pathFile; ?></td>
            <td><?= $print->pathWeb; ?></td>
            <td><?= $print->embed; ?></td>
            <td><?= $print->width; ?></td>
            <td><?= $print->height; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
