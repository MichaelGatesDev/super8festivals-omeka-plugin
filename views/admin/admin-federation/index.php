<?= $this->partial("__partials/header.php", ["title" => "Federation"]); ?>

<div class="row my-5">
    <div class="col">
        <s8f-federation-newsletters-table>
        </s8f-federation-newsletters-table>
    </div>
</div>

<div class="row my-5">
    <div class="col">
        <s8f-federation-photos-table>
        </s8f-federation-photos-table>
    </div>
</div>

<div class="row my-5">
    <div class="col">
        <s8f-federation-bylaws-table>
        </s8f-federation-bylaws-table>
    </div>
</div>

<div class="row my-5">
    <div class="col">
        <s8f-federation-magazines-table>
        </s8f-federation-magazines-table>
    </div>
</div>


<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-newsletters-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-photos-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-magazines-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-bylaws-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
