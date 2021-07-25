<?= $this->partial("__partials/header.php", ["title" => ucwords($country->get_location()->name)]); ?>

    <div class="row">
        <div class="col">
            <s8f-cities-table
                country-id="<?= $country->id; ?>"
            >
            </s8f-cities-table>
        </div>
    </div>

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-cities-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>