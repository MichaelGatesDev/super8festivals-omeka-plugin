<?= $this->partial("__partials/header.php", ["title" => "Countries"]); ?>

    <div class="row">
        <div class="col">
            <s8f-countries-table></s8f-countries-table>
        </div>
    </div>

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-countries-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>