<?= $this->partial("__partials/header.php", ["title" => "S8F Admin"]) ?>

    <div class="row pt-4">
        <div class="col-2">
        </div>
        <div class="col-10">

            <div class="row">
                <div class="col">
                    <?= $this->partial("__partials/flash.php"); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2 class="mb-2">Super 8 Festivals</h2>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?= $this->partial("__components/breadcrumbs.php"); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="omeka-panel">

                        <div class="row mb-4">
                            <div class="col">
                                <a href="<?= build_admin_url(["countries"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Countries</a>
                                <a href="<?= build_admin_url(["federation"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Federation</a>
                                <a href="<?= build_admin_url(["filmmakers"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Filmmakers</a>
                                <a href="<?= build_admin_url(["contributors"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Contributors</a>
                                <a href="<?= build_admin_url(["staff"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Site Staff</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-countries-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>