<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
);
echo head($head);
?>

<?php echo flash(); ?>

<?php if (!get_records('SuperEightFestivalsCountry')): ?>
    <p>
        <?php echo 'There are no countries.'; ?>
        <a href="<?php echo html_escape(url('super-eight-festivals/countries/add')); ?>"><?php echo __('Add a country.'); ?></a>
    </p>
<?php else: ?>
    <?php echo $this->partial('countries/browse-list.php'); ?>
<?php endif; ?>


<?php echo foot(); ?>
