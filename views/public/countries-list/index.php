<?php
$head = array(
    'title' => "Countries",
);
echo head($head);
?>

<?php echo flash(); ?>



<?php
$countries = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
sort($countries);
?>

<section class="container-fluid" id="countries-list">

    <div class="row mb-3">
        <div class="col d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary active" id="gridButton">Grid View</button>
                <button type="button" class="btn btn-secondary" id="listButton">List View</button>
            </div>
        </div>
    </div>


    <div class="row" id="grid">
        <div class="col">
            <div class="card-deck d-flex justify-content-center align-items-center text-center">
                <?php foreach ($countries as $country): ?>
                    <div class="card mb-4" style="min-width: 280px; max-width: 240px;">
                        <img class="card-img-top" src="https://placehold.it/280x140/abc" alt="Card image cap">
                        <div class="card-body">
                            <h3 class="card-title"><?= $country->name; ?></h3>
                            <!--                            <p class="card-text">This is a longer card <br> with <br> supporting <br> text below <br> as a natural lead-in to additional content. This content is a little bit longer.</p>-->
                            <p class="card-text"><small class="text-muted">(0) Festivals</small></p>
                            <a href="<?= $this->url('countries/' . str_replace(" ", "-", strtolower($country->name))); ?>" class="stretched-link"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row d-none" id="list">
        <div class="col">
            <h2>Festival Countries:</h2>
            <ul class="countries-list">
                <?php foreach ($countries as $country): ?>
                    <li>
                        <a href="<?= $this->url('countries/' . str_replace(" ", "-", strtolower($country->name))); ?>">
                            <?php echo $country->name ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(() => {
            const listButton = $('#listButton');
            const gridButton = $('#gridButton');
            const listElem = $('#list');
            const gridElem = $('#grid');

            gridButton.click(() => grid());
            listButton.click(() => list());

            const grid = () => {
                gridButton.addClass('active');
                listButton.removeClass('active');
                /// if grid hidden, unhide
                if (gridElem.hasClass('d-none')) gridElem.removeClass('d-none');
                // if list not hidden, hide
                if (!listElem.hasClass('d-none')) listElem.addClass('d-none');
            };

            const list = () => {
                gridButton.removeClass('active');
                listButton.addClass('active');
                /// if grid hidden, unhide
                if (listElem.hasClass('d-none')) listElem.removeClass('d-none');
                // if list not hidden, hide
                if (!gridElem.hasClass('d-none')) gridElem.addClass('d-none');
            };
        });
    </script>

</section>

<?php echo foot(); ?>
