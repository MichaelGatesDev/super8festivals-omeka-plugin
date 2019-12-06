<?php
$url = $_SERVER['REQUEST_URI'];
$page = get_page_by_url($url);
$head = array(
    'title' => $page->title,
);
echo head($head);
?>

<?php echo flash(); ?>

<section class="container-fluid">
    <div class="row">
        <div class="col">
            <h2><?= $page->title; ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $page->content; ?>
        </div>
    </div>
</section>

<?php echo foot(); ?>
