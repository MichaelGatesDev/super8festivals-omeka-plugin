<?php
echo head(array(
    'title' => 'Browse Cities',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<!-- 'Add City' Button -->
<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add City')); ?>

<?php
set_loop_records("super_eight_festivals_city", get_records("SuperEightFestivalsCity", array(), -1));
?>


<table class="full">
    <thead>
    <tr>
        <th>Name</th>
        <th>Country</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Internal ID</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (get_all_cities(true, true) as $city): ?>
        <tr>
            <td>
                <span class="title">
                    <a href="<?php echo record_url($city); ?>">
                        <?php echo $city->name ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a href="<?php echo "edit/id/$city->id"; ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a href="<?php echo "delete-confirm/id/$city->id"; ?>">
                            Delete
                        </a>
                    </li>
                </ul>
            </td>
            <td><?= get_country_by_id($city->country_id)->name; ?></td>
            <td><?= $city->latitude; ?></td>
            <td><?= $city->longitude; ?></td>
            <td><?= $city->id; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php echo foot(); ?>

