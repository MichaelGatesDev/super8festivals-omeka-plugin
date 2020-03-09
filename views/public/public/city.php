<?php
$head = array(
    'title' => ucwords($country->name),
);
echo head($head);

$cities = get_all_cities_in_country($country->id);
?>

<style>
</style>
<section class="container-fluid" id="countries-list">

    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Oof</h2>
            </div>
        </div>
    </div>

</section>

<?php echo foot(); ?>
