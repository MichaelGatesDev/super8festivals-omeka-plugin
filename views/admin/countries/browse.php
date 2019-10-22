<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
);
echo head($head);
?>


<p>This is where we show a list of all of the countries</p>

<?php

echo $this->databaseHelper->getAllCountries();


?>


<?php echo foot(); ?>
