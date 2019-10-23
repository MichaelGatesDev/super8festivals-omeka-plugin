<table class="full">
    <thead>
    <tr>
        <?php echo browse_sort_links(array(
            'Name' => 'title',
            'Latitude' => 'slug',
            'Longitude' => 'updated'), array('link_tag' => 'th scope="col"', 'list_tag' => ''));
        ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach (get_records('SuperEightFestivalsCountry') as $country): ?>
        <tr>
            <td>
                <span>
                    <?php echo $country->name; ?>
                </span>
            </td>
            <td>
                <span>
                    <?php echo $country->latitude; ?>
                </span>
            </td>
            <td>
                <span>
                <?php echo $country->longitude; ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
