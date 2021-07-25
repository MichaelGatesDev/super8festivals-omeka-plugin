<?= $this->partial("__partials/header.php", ["title" => "S8F Dashboard"]) ?>

    <div class="row">
        <div class="col">
            <a href="<?= build_admin_url(["countries"]); ?>" class="btn btn-primary">Countries</a>
            <a href="<?= build_admin_url(["federation"]); ?>" class="btn btn-primary">Federation</a>
            <a href="<?= build_admin_url(["filmmakers"]); ?>" class="btn btn-primary">Filmmakers</a>
            <a href="<?= build_admin_url(["contributors"]); ?>" class="btn btn-primary">Contributors</a>
            <a href="<?= build_admin_url(["staff"]); ?>" class="btn btn-primary">Site Staff</a>
        </div>
    </div>

<?= $this->partial("__partials/footer.php") ?>