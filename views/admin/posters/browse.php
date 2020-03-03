<?php
echo head(array(
    'title' => 'Browse Posters',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Banner')); ?>

<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Internal ID" => 'id',
                "Country" => 'country_id',
                "City" => 'city_id',
                "Path" => 'path',
                "Thumbnail" => 'thumbnail',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach (loop('super_eight_festivals_festival_poster') as $banner): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url('super_eight_festivals_festival_poster')); ?>" style="text-transform: capitalize;">
                       <?= $banner->id; ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_festival_poster', 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_festival_poster', 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $banner->get_country()->name; ?></td>
            <td><?= $banner->getCity()->name; ?></td>
            <td style="text-transform: lowercase;">
                <div style=" display: flex; flex-direction: column;">
                    <?= $banner->path; ?>
                    <img src="<?= $banner->path; ?>" width="200" style="margin-top: 0.5em;">
                </div>
            </td>
            <td style="text-transform: lowercase;">
                <div style=" display: flex; flex-direction: column;">
                    <?= $banner->thumbnail; ?>
                    <img src="<?= $banner->thumbnail; ?>" width="200" style="margin-top: 0.5em;">
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php echo foot(); ?>

