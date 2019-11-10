<?php
$head = array(
    'title' => $country->name,
);
echo head($head);
?>

<?php echo flash(); ?>

<section class="container">

    <!--The name of the country-->
    <h2 class="country-name"><?= $country->name; ?></h2>

    <!-- mini-map to show the country in relation to other countries-->
    <div class="country-map" id="country-map">
    </div>


    <!--Display a list of festivals-->
    <h3>Festivals:</h3>
    <ul>
        <li>Example Festival Here</li>
    </ul>

</section>


<?php echo foot(); ?>
