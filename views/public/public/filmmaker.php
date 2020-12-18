<?php
$head = array(
    'title' => "Filmmaker",
);
echo head($head);

$films = $filmmaker->get_films();
$photos = $filmmaker->get_photos();
?>

<section class="container my-5" id="filmmaker">

    <div class="row">
        <div class="col">
            <h2 class="my-4 text-capitalize"><?= html_escape($filmmaker->get_person()->get_display_name()); ?></h2>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-films">
        <div class="col">
            <h3>Films</h3>
            <div id="films"></div>
        </div>
    </div>

    <div class="row my-5" id="filmmaker-photos">
        <div class="col">
            <h3>Photos</h3>
            <div id="photos"></div>
        </div>
    </div>

</section>


<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-embed-record-cards.js"></script>
<script type="module" src="/plugins/SuperEightFestivals/views/public/javascripts/components/s8f-file-record-cards.js"></script>
<script type="module">
    import { html, render } from "/plugins/SuperEightFestivals/views/shared/javascripts/vendor/lit-html.js";
    import API, { HTTPRequestMethod } from "/plugins/SuperEightFestivals/views/shared/javascripts/api.js";

    const fetchFilms = () => API.performRequest(API.constructURL(["filmmakers", <?= $filmmaker->id ?>, "films"]), HTTPRequestMethod.GET);
    const fetchPhotos = () => API.performRequest(API.constructURL(["filmmakers", <?= $filmmaker->id ?>, "photos"]), HTTPRequestMethod.GET);

    $(() => {
        fetchFilms().then((films) => {
            render(
                html`<s8f-embed-record-cards .embeds=${films}></s8f-embed-record-cards>`,
                document.getElementById("films"),
            );
        });
        fetchPhotos().then((photos) => {
            render(
                html`<s8f-file-record-cards .files=${photos}></s8f-file-record-cards>`,
                document.getElementById("photos"),
            );
        });
    });
</script>

<?php echo foot(); ?>
