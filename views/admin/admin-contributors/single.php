<?= $this->partial("__partials/header.php", ["title" => "Contributor: " . ucwords($contributor->get_person()->get_display_name())]); ?>

    <section class="container">

        <div class="row">
            <div class="col">
                <?= $this->partial("__components/breadcrumbs.php"); ?>
            </div>
        </div>

        <!-- Omeka Alerts -->
        <div class="row">
            <div class="col">
                <?= $this->partial("__partials/flash.php"); ?>
            </div>
        </div>

        <!-- S8F Alerts -->
        <div class="row">
            <div class="col">
                <s8f-alerts-area id="alerts"></s8f-alerts-area>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h2 class="text-capitalize mb-4">
                    Contributions
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p>TBD</p>
            </div>
        </div>

    </section>


<?= $this->partial("__partials/footer.php") ?>