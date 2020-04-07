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
        <a href="<?= get_relative_path($document->get_path()); ?>" class="stretched-link"></a>
    </div>
</div>