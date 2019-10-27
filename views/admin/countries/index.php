<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
);
echo head($head);
?>

<?php echo flash(); ?>

<?php echo $this->partial('__components/button.php', array('url' => 'add', 'text' => 'Add Country')); ?>
<?php echo $this->partial('__components/button.php', array('url' => 'edit', 'text' => 'Edit Country')); ?>

<?php
set_loop_records('super_eight_festivals_countries', get_records("SuperEightFestivalsCountry"));
?>


<table class="full">
    <thead>
    <tr>
        <th>Name</th>
        <th>Latitude</th>
        <th>Longitude</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (loop('super_eight_festivals_countries') as $country): ?>
        <tr>
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url('super_eight_festivals_country')); ?>">
                        <?php echo metadata('super_eight_festivals_country', 'name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <li>
                        <a href="<?php echo "edit/id/$country->id"; ?>">
                            <?php echo __('edit'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo "delete/id/$country->id"; ?>">
                            <?php echo __('delete'); ?>
                        </a>
                    </li>
                </ul>
            </td>
            <td><?php echo metadata('super_eight_festivals_country', 'latitude'); ?></td>
            <td><?php echo metadata('super_eight_festivals_country', 'longitude'); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php echo foot(); ?>
