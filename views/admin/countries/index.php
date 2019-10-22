<?php
$head = array(
    'title' => html_escape(__('Super 8 Festivals | Countries')),
);
echo head($head);
?>


<p>This is the countries tab!</p>

<a class="add-page button small green" href="<?php echo html_escape(url('super-eight-festivals/countries/add')); ?>">
    Add Country
</a>
<a class="add-page button small green" href="<?php echo html_escape(url('super-eight-festivals/countries/browse')); ?>">
    Browse Countries
</a>

<?php if (!has_loop_records('simple_pages_page')): ?>
    <p><?php echo __('There are no countries.'); ?></p>
<?php else: ?>
    <?php echo $this->partial('countries/browse.php', array('countries' => $countries)); ?>
<?php endif; ?>

<?php echo foot(); ?>
