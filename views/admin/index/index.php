<?php
echo head(
    array(
        'title' => 'Admin Panel',
    )
);
?>

<?php echo flash(); ?>

<h2>Super 8 Festivals Control Panel</h2>

<style>

</style>

<div style="display: flex; flex-direction: row;">
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete countries.</p>
        <a href="/admin/super-eight-festivals/countries" class="button green" style="margin: 0;">Countries</a>
    </div>
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete festivals.</p>
        <a href="/admin/super-eight-festivals/festivals" class="button green" style="margin: 0;">Festivals</a>
    </div>
</div>

<div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
    <p style="margin-top: 0;">Edit text content on pages</p>
    <a href="/admin/super-eight-festivals/pages" class="button blue" style="margin: 0;">Edit Page Contents</a>
</div>


<?php echo foot(); ?>
