<?= $this->partial("__partials/header.php", ["title" => "Filmmakers"]); ?>

<div class="row">
    <div class="col">
        <s8f-filmmakers-table></s8f-filmmakers-table>
    </div>
</div>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-filmmakers-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
