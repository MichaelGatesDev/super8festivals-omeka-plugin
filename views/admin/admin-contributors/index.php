<?= $this->partial("__partials/header.php", ["title" => "Contributors"]); ?>

    <div class="row">
        <div class="col">
            <s8f-contributors-table></s8f-contributors-table>
        </div>
    </div>

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-contributors-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>