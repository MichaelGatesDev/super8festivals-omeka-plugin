<div class="card mb-4 shadow-sm display-inline-block">
    <div class="card-body">
        <div class="card-image" style="background-color: lightgray; height: 250px;">
            <img class="card-img-top img-fluid w-100" src="<?= get_relative_path($image->get_thumbnail_path()); ?>" alt="No preview available" style="object-fit: cover; width: 100%; height: 100%;  display: flex; justify-content: center; align-items: center; text-align: center; "/>
        </div>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Title:</span>
            <span><?= strlen($image->title) > 0 ? $image->title : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Description:</span>
            <span><?= strlen($image->description) > 0 ? $image->description : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Contributor:</span>
            <span><?= $image->get_contributor() ? $image->get_contributor()->get_display_name() : "N/A"; ?></span>
        </p>
        <a href="<?= get_relative_path($image->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $image->title; ?>"></a>
    </div>
</div>