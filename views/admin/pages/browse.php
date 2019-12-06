<?php
echo head(array(
    'title' => 'Edit Page',
));
?>

<?php echo flash(); ?>

<h2>Super 8 Festivals Control Panel</h2>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p>If you would like to make any changes to <span style="font-weight: bold;">textual content</span> on the website, click on the page name below:</p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <ul>
                <?php foreach (loop('super_eight_festivals_page') as $page): ?>
                    <li>
                        <a class="edit" href="<?php echo html_escape(record_url($page, 'edit')); ?>">
                            <?= $page->title; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php echo foot(); ?>
