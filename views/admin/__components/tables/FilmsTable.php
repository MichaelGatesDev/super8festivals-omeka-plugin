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
    <?php foreach ($filmsVar as $film): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url($film, 'view')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata($film, 'title'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($film, 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($film, 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $film->description; ?></td>
            <td><?= $film->thumbnailPathFile; ?></td>
            <td><?= $film->thumbnailPathWeb; ?></td>
            <td><?= $film->pathFile; ?></td>
            <td><?= $film->pathWeb; ?></td>
            <td><?= $film->embed; ?></td>
            <td><?= $film->width; ?></td>
            <td><?= $film->height; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
