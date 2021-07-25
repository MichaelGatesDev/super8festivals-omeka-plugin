<?= $this->partial("__partials/header.php", ["title" => "Staff: " . ucwords($filmmaker->get_person()->get_name())]); ?>

<div class="row my-5">
    <div class="col">
        <h3>Biography</h3>
        <?php if ($filmmaker->bio == null): ?>
            <p>There is no bio available for this filmmaker.</p>
        <?php else: ?>
            <div class="form-group">
                <textarea class="form-control" readonly><?= $filmmaker->bio; ?></textarea>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Films -->
<div class="row my-4" id="films">
    <div class="col">
        <s8f-filmmaker-films-table filmmaker-id="<?= $filmmaker->id; ?>"></s8f-filmmaker-films-table>
    </div>
</div>

<!-- Photos -->
<div class="row my-4" id="photos">
    <div class="col">
        <s8f-filmmaker-photos-table filmmaker-id="<?= $filmmaker->id; ?>"></s8f-filmmaker-photos-table>
    </div>
</div>

<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-filmmaker-films-table.js'></script>
<script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-filmmaker-photos-table.js'></script>

<?= $this->partial("__partials/footer.php") ?>
