<?= $this->partial("__partials/header.php", ["title" => "S8F Dashboard"]) ?>

    <div class="row">
        <div class="col">
            <a href="<?= build_admin_url(["countries"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Countries</a>
            <a href="<?= build_admin_url(["federation"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Federation</a>
            <a href="<?= build_admin_url(["filmmakers"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Filmmakers</a>
            <a href="<?= build_admin_url(["contributors"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Contributors</a>
            <a href="<?= build_admin_url(["staff"]); ?>" class="btn btn-primary" style="margin: 0; padding: 0.5em 1.5em;">Site Staff</a>
        </div>
    </div>

<!--    <ul class="nav nav-tabs" role="tablist">-->
<!--        <li class="nav-item" role="presentation">-->
<!--            <button class="nav-link active" id="countries-tab" data-bs-toggle="tab" data-bs-target="#countries" type="button" role="tab" aria-controls="countries" aria-selected="true">-->
<!--                Countries-->
<!--            </button>-->
<!--        </li>-->
<!--        <li class="nav-item" role="presentation">-->
<!--            <button class="nav-link" id="federation-tab" data-bs-toggle="tab" data-bs-target="#federation" type="button" role="tab" aria-controls="federation" aria-selected="false">-->
<!--                Federation-->
<!--            </button>-->
<!--        </li>-->
<!--        <li class="nav-item" role="presentation">-->
<!--            <button class="nav-link" id="filmmakers-tab" data-bs-toggle="tab" data-bs-target="#filmmakers" type="button" role="tab" aria-controls="profile" aria-selected="false">-->
<!--                Filmmakers-->
<!--            </button>-->
<!--        </li>-->
<!--        <li class="nav-item" role="presentation">-->
<!--            <button class="nav-link" id="contributors-tab" data-bs-toggle="tab" data-bs-target="#contributors" type="button" role="tab" aria-controls="contributors" aria-selected="false">-->
<!--                Contributors-->
<!--            </button>-->
<!--        </li>-->
<!--        <li class="nav-item" role="presentation">-->
<!--            <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staff" type="button" role="tab" aria-controls="staff" aria-selected="false">-->
<!--                Site Staff-->
<!--            </button>-->
<!--        </li>-->
<!--    </ul>-->
<!--    <div class="tab-content">-->
<!--        <div class="tab-pane fade show active" id="countries" role="tabpanel" aria-labelledby="countries-tab">-->
<!--            <div class="p-4">-->
<!--                <h3>Countries</h3>-->
<!--                --><?//= $this->partial("__components/tables/countries-table.php"); ?>
<!--            </div>-->
<!--        </div>-->
<!--        <div class="tab-pane fade" id="federation" role="tabpanel" aria-labelledby="federation-tab">-->
<!---->
<!--        </div>-->
<!--        <div class="tab-pane fade" id="filmmakers" role="tabpanel" aria-labelledby="filmmakers-tab">-->
<!---->
<!--        </div>-->
<!--        <div class="tab-pane fade" id="contributors" role="tabpanel" aria-labelledby="contributors-tab">-->
<!---->
<!--        </div>-->
<!--        <div class="tab-pane fade" id="staff" role="tabpanel" aria-labelledby="staff-tab">-->
<!---->
<!--        </div>-->
<!--    </div>-->

<?= $this->partial("__partials/footer.php") ?>