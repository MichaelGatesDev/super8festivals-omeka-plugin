<?= $this->partial("__partials/header.php", ["title" => "Contributor: " . ucwords($contributor->get_person()->get_name())]); ?>

    <div class="row">
        <div class="col">
            <h3>Contributions</h3>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p>Placeholder</p>
        </div>
    </div>

<?= $this->partial("__partials/footer.php") ?>