<?php
echo head(
    array(
        'title' => 'Admin Panel',
    )
);
?>

<?php echo flash(); ?>

<h2>Super 8 Festivals Control Panel</h2>


<div style="display: flex; flex-direction: row;">
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete countries.</p>
        <a href="super-eight-festivals/countries/" class="button green" style="margin: 0;">Countries</a>
    </div>
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete cities.</p>
        <a href="super-eight-festivals/cities/" class="button green" style="margin: 0;">Cities</a>
    </div>
</div>


<div style="display: flex; flex-direction: row;">
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete country banners.</p>
        <a href="super-eight-festivals/banners/" class="button green" style="margin: 0;">Banners</a>
    </div>
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete festival posters.</p>
        <a href="super-eight-festivals/posters/" class="button green" style="margin: 0;">Posters</a>
    </div>
    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete filmmakers.</p>
        <a href="super-eight-festivals/filmmakers/" class="button green" style="margin: 0;">Filmmakers</a>
    </div>

    <div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
        <p style="margin-top: 0;">Browse, add, edit, and delete contributors.</p>
        <a href="super-eight-festivals/contributors/" class="button green" style="margin: 0;">Contributors</a>
    </div>
</div>


<div style="display: flex; flex-direction: column; background-color: #f2f2f2; padding: 1em; border-radius: 5px; margin: 0.5em;">
    <p style="margin-top: 0;">Edit text content on pages</p>
    <a href="super-eight-festivals/pages/" class="button blue" style="margin: 0;">Edit Page Contents</a>
</div>


<?php echo foot(); ?>
