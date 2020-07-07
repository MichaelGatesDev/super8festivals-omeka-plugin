<div class="card d-inline-block my-2 mx-2" style="width: 18rem;">
    <a href="<?= get_relative_path($record->get_path()) ?>" data-fancybox="fb-TODO" data-title="<?= $record->title; ?>">
        <img
                class="card-img-top"
                src="<?= get_relative_path($record->get_thumbnail_path()); ?>"
                alt="<?= $record->title; ?>"
                style="object-fit: cover; height: 300px; "
        />
    </a>
    <div class="card-body" style="height: 250px; max-height: 300px; overflow-y: scroll;">
        <p>
            <span class="font-weight-bold">Title:</span>
            <?= $record->title == "" ? "Untitled" : $record->title; ?>
        </p>
        <p class="text-muted">
            <span class="font-weight-bold text-dark">Description:</span>
            <?= $record->description == "" ? "No description available." : $record->description; ?>
        </p>
        <?php if ($record->festival_id): ?>
            <p class="text-muted">
                <span class="font-weight-bold text-dark">Festival:</span>
                <?= $record->get_festival()->year === 0 ? "Uncategorized" : $record->get_festival()->year; ?>
            </p>
        <?php endif; ?>
        <p class="text-muted">
            <span class="font-weight-bold text-dark">Contributor:</span>
            <?= $record->contributor ? $record->contributor->get_display_name() : "No contributor." ?>
        </p>
    </div>
</div>