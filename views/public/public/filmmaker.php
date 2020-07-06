<?php
$head = array(
    'title' => "Federation",
);
echo head($head);


?>

<section class="container pb-4" id="filmmaker">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-capitalize"><?= html_escape($filmmaker->get_full_name()); ?></h2>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col">
            <h3 class="mb-4">Photos</h3>
            <?php if (count($records = get_all_photos_for_filmmaker($filmmaker->id)) > 0): ?>
                <?php foreach ($records as $photo): ?>
                    <div class="card m-4 shadow-sm display-inline-block w-25">
                        <div class="card-body">
                            <div class="card-image mb-2" style="background-color: lightgray; height: 250px;">
                                <img class="card-img-top img-fluid w-100" src="<?= get_relative_path($photo->get_thumbnail_path()); ?>" alt="No preview available"
                                     style="object-fit: cover; width: 100%; height: 100%;  display: flex; justify-content: center; align-items: center; text-align: center; "/>
                            </div>
                            <p class="card-title mb-2">
                                <span style="font-weight: bold">Title:</span>
                                <span><?= $photo->title; ?></span>
                            </p>
                            <p class="card-title mb-2">
                                <span style="font-weight: bold">Description:</span>
                                <span><?= $photo->description; ?></span>
                            </p>
                            <p class="card-title mb-2">
                                <span style="font-weight: bold">Contributor:</span>
                                <span><?= $photo->contributor; ?></span>
                            </p>
                            <a href="<?= get_relative_path($photo->get_path()); ?>" class="stretched-link" data-fancybox="fb-photos" data-title="Editing Super 8 double system"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>There are no filmmakers here yet.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
