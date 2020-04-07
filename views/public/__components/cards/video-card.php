<div class="card mb-4 shadow-sm display-inline-block" style="width: 300px;">
    <div class="card-body">
        <div class="video-embed"><?= $video->embed; ?></div>
        <h5 class="card-title"><?= $video->title; ?></h5>
        <p class="card-text"><?= $video->description; ?></p>
    </div>
</div>
<style>
    .video-embed iframe {
        width: 100% !important;
        height: auto;
    }
</style>