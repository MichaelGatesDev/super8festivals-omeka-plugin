<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Control Panel')),
);
echo head($head);
?>

<div>
    <a href="super-eight-festivals/countries/" class="add big green button">Countries</a>
</div>

<div>
    <a href="super-eight-festivals/cities" class="add big green button">Cities</a>
</div>

<div>
    <a href="super-eight-festivals/filmmakers" class="add big green button">Filmmakers</a>
</div>

<div>
    <a href="super-eight-festivals/settings" class="add big green button">Settings</a>
</div>

<?php echo foot(); ?>
