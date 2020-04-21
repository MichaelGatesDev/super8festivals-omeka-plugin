<div class="card mb-4 shadow-sm display-inline-block">
    <div class="card-body">
        <p class="card-title mb-0">
            <span style="font-weight: bold">Title:</span>
            <span><?= strlen($document->title) > 0 ? $document->title : "N/A"; ?></span>
        </p>
        <p class="card-title mb-0">
            <span style="font-weight: bold">Description:</span>
            <span><?= strlen($document->description) > 0 ? $document->description : "N/A"; ?></span>
        </p>
        <p class="card-title mb-0">
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
    </div>
</div>