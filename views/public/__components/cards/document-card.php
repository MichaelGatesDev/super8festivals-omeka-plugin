<div class="card mb-4 shadow-sm display-inline-block">
    <div class="card-body">
        <div class="card-image mb-2" style="background-color: lightgray; height: 200px;">
            <img class="card-img-top img-fluid w-100" src="<?= get_relative_path($document->get_thumbnail_path()); ?>" alt="No preview available" style="object-fit: cover; width: 100%; height: 100%;  display: flex; justify-content: center; align-items: center; text-align: center; "/>
        </div>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Title:</span>
            <span><?= strlen($document->title) > 0 ? $document->title : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Description:</span>
            <span><?= strlen($document->description) > 0 ? $document->description : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Contributor:</span>
            <span><?= $document->get_contributor() ? $document->get_contributor()->get_display_name() : "N/A"; ?></span>
        </p>
        <?php if (strlen($document->file_url_web) > 0): ?>
            <a href="<?= $document->file_url_web; ?>" class="stretched-link" target="_blank"></a>
        <?php else: ?>
            <?php if (is_localhost()): ?>
                <a href="<?= get_relative_path($document->get_path()); ?>" class="stretched-link"></a>
            <?php else: ?>
                <a target="_blank" href="https://docs.google.com/viewerng/viewer?url=<?= base_url(true) . get_relative_path($document->get_path()); ?>" class="stretched-link"></a>
            <?php endif; ?>
        <?php endif; ?>
        <a href="<?= get_relative_path($document->get_path()); ?>" class="stretched-link"></a>
    </div>
</div>