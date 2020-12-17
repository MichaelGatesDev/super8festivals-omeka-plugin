<?= $this->partial("__partials/header.php", ["title" => "Federation"]); ?>

<section class="container">

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <!-- Omeka Alerts -->
    <div class="row">
        <div class="col">
            <?= $this->partial("__partials/flash.php"); ?>
        </div>
    </div>

    <!-- S8F Alerts -->
    <div class="row">
        <div class="col">
            <s8f-alerts-area id="alerts"></s8f-alerts-area>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <h2>Federation</h2>
        </div>
    </div>

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


</section>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-newsletters-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-photos-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-magazines-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-federation-bylaws-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
