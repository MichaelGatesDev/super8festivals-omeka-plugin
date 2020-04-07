<div class="card mb-4 shadow-sm display-inline-block">
    <img class="img-fluid w-100" src="<?= get_relative_path($image->get_thumbnail_path()); ?>" alt="<?= $image->title; ?>"/>
    <a href="<?= get_relative_path($image->get_path()); ?>" class="stretched-link" data-fancybox="fb-posters" data-title="<?= $image->title; ?>"></a>
</div>