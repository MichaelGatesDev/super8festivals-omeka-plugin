<?php
echo head(array(
    'title' => 'Browse Cities',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add City')); ?>

<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(
            array(
                "Name" => 'name',
                "Country" => 'country_id',
                "Latitude" => 'latitude',
                "Longitude" => 'longitude',
                "Internal ID" => 'id',
            ),
            array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach (loop('super_eight_festivals_city') as $city): ?>
        <tr style="text-transform: capitalize;">
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url('super_eight_festivals_city')); ?>">
                        <?php echo metadata('super_eight_festivals_city', 'name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_city', 'edit')); ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url('super_eight_festivals_city', 'delete-confirm')); ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= $city->getCountry()->name; ?></td>
            <td><?= $city->latitude; ?></td>
            <td><?= $city->longitude; ?></td>
            <td><?= $city->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php echo foot(); ?>

