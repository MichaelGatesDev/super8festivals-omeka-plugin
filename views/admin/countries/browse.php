<?php
echo head(array(
    'title' => 'Browse Countries',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Country')); ?>

<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Name" => 'name',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach (loop('super_eight_festivals_country') as $country): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url('super_eight_festivals_country')); ?>" style="text-transform: capitalize;">
                        <?php echo metadata('super_eight_festivals_country', 'name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_country', 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_country', 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $country->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php echo foot(); ?>

