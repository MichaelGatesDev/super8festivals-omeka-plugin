<?php
echo head(array(
    'title' => 'Edit Country: ' . $country->name,
));
$banner = get_banner_for_country($country->id);
$posters = get_all_posters_for_country($country->id);
?>

<?php echo flash(); ?>

<div style="display: flex; flex-direction: column;">

    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>

    <!--Banner Section-->
    <div class="row mx-0 mb-0 py-2">
        <div class="col">
            <h2>Banner</h2>
            <p>Note: There can only be one banner per country.</p>
            <?php if ($banner != null): ?>
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: fit-content;">
                    <img src="<?= $banner->path; ?>" class="card-img-top" alt="" style="object-fit: contain; width: 100%; height: 350px;">
                    <ul class="action-links group">
                        <!-- Edit Item-->
                        <li>
                            <a class="edit" href="<?php echo html_escape(record_url($banner, 'edit')); ?>">
                                Edit
                            </a>
                        </li>
                        <!-- Delete Item-->
                        <li>
                            <a class="delete-confirm" href="<?php echo html_escape(record_url($banner, 'delete-confirm')); ?>">
                                Delete
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <p>There is no banner for this country.</p>
                <a href="<?php echo html_escape(record_url(new SuperEightFestivalsCountryBanner(), 'add')); ?>" class="add button small green">Add Banner</a>
            <?php endif; ?>
        </div>
    </div>

    <!--Posters Section-->
    <div class="row mx-0 mb-0 py-2">
        <div class="col">
            <h2>Posters</h2>
            <p>Note: There can only be one banner per country.</p>
            <?php if (count($posters) > 0): ?>
                <?php foreach ($posters as $poster): ?>
                    <div style="display: inline-block; width: 300px; height: 300px; margin-bottom: 4em;">
                        <img src="<?= $poster->path; ?>" class="card-img-top" alt="" style="object-fit: cover; width: 100%; height: 100%;">
                        <ul class="action-links group">
                            <!-- Edit Item-->
                            <li>
                                <a class="edit" href="<?php echo html_escape(record_url($poster, 'edit')); ?>">
                                    Edit
                                </a>
                            </li>
                            <!-- Delete Item-->
                            <li>
                                <a class="delete-confirm" href="<?php echo html_escape(record_url($poster, 'delete-confirm')); ?>">
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>There are no posters for this country.</p>
                <a href="<?php echo html_escape(record_url(new SuperEightFestivalsFestivalPoster(), 'add')); ?>" class="add button small green">Add Poster</a>
            <?php endif; ?>
        </div>
    </div>

</div>


<?php echo foot(); ?>
