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
                <li><a href="/admin/super-eight-festivals/edit-page/home">Home</a></li>
                <li><a href="/admin/super-eight-festivals/edit-page/history">History</a></li>
                <li><a href="/admin/super-eight-festivals/edit-page/filmmakers">Filmmakers</a></li>
                <li><a href="/admin/super-eight-festivals/edit-page/about">About</a></li>
                <li><a href="/admin/super-eight-festivals/edit-page/contact">Contact</a></li>
                <li><a href="/admin/super-eight-festivals/edit-page/submit">Submit</a></li>
                <li>
                    <a href="/admin/super-eight-festivals/edit-page/countries">Countries</a>
                    <ul>
                        <?php foreach (get_all_countries(true) as $country): ?>
                            <li><a href="/admin/super-eight-festivals/edit-page/countries/<?= strtolower(str_replace(" ", "-", $country->name)); ?>"><?= $country->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php echo foot(); ?>
