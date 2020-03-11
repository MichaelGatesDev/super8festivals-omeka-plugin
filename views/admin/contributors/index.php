<?php
queue_css_file("admin");
queue_js_file("jquery.min");
echo head(array(
    'title' => 'Contributors',
));
?>

<!--Omeka 'flash' message partial -->
<?php echo flash(); ?>

<?= $this->partial("__components/breadcrumbs.php"); ?>

<style>
    #add-contributor-button {
        margin-bottom: 1em;
    }
</style>


<div class="records-section">
    <a id="add-contributor-button" class="button green" href="/admin/super-eight-festivals/contributors/add">Add Contributor</a>
    <?php
    $contributors = get_all_contributors();
    sort($contributors);
    ?>
    <?php if (count($contributors) == 0): ?>
        <p>There are no contributors available.</p>
    <?php else: ?>
        <?= $this->partial("__components/records/contributors.php", array('contributors' => $contributors)); ?>
    <?php endif; ?>
</div>


<?php echo foot(); ?>

