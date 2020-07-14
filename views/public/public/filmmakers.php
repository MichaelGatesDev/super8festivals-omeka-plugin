<?php
$head = array(
    'title' => "Filmmakers",
);
echo head($head);


?>

<style>
</style>

<section class="container my-5" id="filmmakers">

    <div class="row">
        <div class="col">
            <h2 class="my-4">Filmmakers</h2>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col">
            <?php if (count($records = get_all_filmmakers()) > 0): ?>
                <?php foreach ($records as $filmmaker): ?>
                    <?php
                    $information = array();
                    array_push($information, array(
                        "key" => "Name",
                        "value" => $filmmaker->get_full_name() == "" ? "No name" : html_escape($filmmaker->get_full_name()),
                    ));
                    array_push($information, array(
                        "key" => "email",
                        "value" => $filmmaker->email == "" ? "No email" : html_escape($filmmaker->email),
                    ));
                    echo $this->partial("__components/record-card.php", array(
                        'card_width' => '300px',
                        'card_height' => '100px',
//                            'preview_height' => '300px',
                        'embed' => $filmmaker->embed,
//                            'thumbnail_path' => get_relative_path($poster->get_thumbnail_path()),
//                            'preview_path' => get_relative_path($poster->get_path()),
                        'fancybox_category' => 'filmmakers',
                        'information' => $information,
                        'admin' => false,
//                        'edit_url' => $root_url . '/filmmakers/' . $filmmaker->id . "/edit",
//                        'delete_url' => $root_url . '/filmmakers/' . $filmmaker->id . "/delete",
                        'link' => '/filmmakers/' . $filmmaker->id
                    )); ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>There are no filmmakers here yet.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
