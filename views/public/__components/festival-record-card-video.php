<div class="card d-inline-block my-2 mx-2" style="width: 30rem;">
    <div class="card-body">
        <div style="overflow: hidden;">
            <?= $record->embed; ?>
        </div>
        <p>
            <span class="font-weight-bold">Title:</span>
            <?= $record->title == "" ? "Untitled" : $record->title; ?>
        </p>
        <p class="text-muted">
                                <span class="font-weight-bold text-dark">
                                Description:
                                </span>
            <?= $record->description == "" ? "No description available." : $record->description; ?>
        </p>
        <p>
            <span class="font-weight-bold">Contributor:</span>
            <?= $record->contributor ? $record->contributor->get_display_name() : "No contributor." ?>
        </p>
        <p>
            <span class="font-weight-bold">Filmmaker:</span>
            <?= $record->filmmaker ? $record->filmmaker->get_display_name() : "Filmmaker unknown." ?>
        </p>
    </div>
</div>