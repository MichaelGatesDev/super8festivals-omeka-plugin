<?php
$url = $_SERVER['REQUEST_URI'];
$head = array(
    'title' => $page->title,
);
echo head($head);
?>

<?php echo flash(); ?>

<section class="container">
    <div class="row">
        <div class="col">
            <h2>About</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col">
        </div>
    </div>
</section>

<?php echo foot(); ?>
