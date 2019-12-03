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
        <th>Name</th>
        <th>Internal ID</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (get_all_countries(true) as $country): ?>
        <tr>
            <td>
                <span style="text-transform: capitalize;">
                    <a href="/admin/super-eight-festivals/countries/<?= $country->name; ?>">
                        <?php echo $country->name ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <!-- Edit Item-->
                    <li>
                        <a href="<?php echo "edit/id/$country->id"; ?>">
                            Edit
                        </a>
                    </li>
                    <!-- Delete Item-->
                    <li>
                        <a href="<?php echo "delete-confirm/id/$country->id"; ?>">
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

