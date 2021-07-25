<?= $this->partial("__partials/header.php", ["title" => "Staff"]); ?>

    <div class="row">
        <div class="col">
            <s8f-staff-table></s8f-staff-table>
        </div>
    </div>

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-staff-table.js'></script>


<?= $this->partial("__partials/footer.php") ?>