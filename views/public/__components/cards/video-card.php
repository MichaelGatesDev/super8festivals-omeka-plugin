<div class="card mb-4 shadow-sm display-inline-block" style="width: 350px;">
    <div class="card-body">
        <div class="card-image mb-2" style="background-color: lightgray; width: 100%; height: 100%;">
            <div class="video-embed d-flex"><?= $video->embed; ?></div>
        </div>

        <p class="card-title mb-2">
            <span style="font-weight: bold">Title:</span>
            <span><?= strlen($video->title) > 0 ? $video->title : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Description:</span>
            <span><?= strlen($video->description) > 0 ? $video->description : "N/A"; ?></span>
        </p>
        <p class="card-title mb-2">
            <span style="font-weight: bold">Contributor:</span>
            <span><?= $video->get_contributor() ? $video->get_contributor()->get_display_name() : "N/A"; ?></span>
        </p>
    </div>
</div>
<style>
    .video-embed iframe {
        width: 100% !important;
        height: auto;
    }
</style>