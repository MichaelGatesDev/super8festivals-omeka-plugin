<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
);
echo head($head);
?>


<?php echo $this->partial('__components/button.php', array('url' => 'super-eight-festivals/countries/add', 'text' => 'Add Country')); ?>

<?php
$records = get_records("SuperEightFestivalsCountry");
echo $this->partial('__components/records/record-view.php',
    array(
        'records' => $records,
        'msgNoRecordsFound' => 'No countries found.',
        'urlAddRecord' => 'super-eight-festivals/countries/add',
        'msgAskAddRecord' => 'Add a country.',
        'viewPartial' => $this->partial('__components/records/table-view.php', array(
            'tableHeaders' => array('Name', 'Latitude', 'Longitude'),
            'fields' => array('name', 'latitude', 'longitude'),
            'records' => $records,
        )),
    ));
?>


<?php echo foot(); ?>
