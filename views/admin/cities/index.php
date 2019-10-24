<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Cities')),
);
echo head($head);
?>


<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/cities/add', 'text' => 'Add City')); ?>

<?php
$records = get_records("SuperEightFestivalsCity");
echo $this->partial('__components/records/record-view.php',
    array(
        'records' => $records,
        'msgNoRecordsFound' => 'No cities found.',
        'urlAddRecord' => 'super-eight-festivals/cities/add',
        'msgAskAddRecord' => 'Add a city.',
        'viewPartial' => $this->partial('__components/records/table-view.php', array(
            'tableHeaders' => array('Name', 'Latitude', 'Longitude', 'Country ID'),
            'fields' => array('name', 'latitude', 'longitude', 'country_id'),
            'records' => $records,
        )),
    ));
?>


<?php echo foot(); ?>
