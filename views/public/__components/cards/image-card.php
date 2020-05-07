<div class="card mb-4 shadow-sm display-inline-block">
    <div class="card-image" style="background-color: lightgray; height: 250px;">
        <img class="card-img-top img-fluid w-100" src="<?= get_relative_path($image->get_thumbnail_path()); ?>" alt="No preview available" style="object-fit: cover; width: 100%; height: 100%;  display: flex; justify-content: center; align-items: center; text-align: center; "/>
    </div>
    <a href="<?= get_relative_path($image->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $image->title; ?>"></a>
</div>