<?php
echo head(array(
    'title' => 'Edit Country: ' . $country->name,
));
$banner = get_banner_for_country($country->id);
?>

<?php echo flash(); ?>

<div style="display: flex; flex-direction: column;">
    <div style="position: relative; width: 100%; height: 100%; ">
        <?php echo $form; ?>
    </div>
    <!--Posters Section-->
    <div class="row mx-0 mb-0 py-2">
        <div class="col">
            <h2>Banner</h2>
            <p class="text-muted">Note: There can only be one banner per country.</p>
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
                <button>Upload</button>
            <?php endif; ?>
        </div>
    </div>


</div>


<?php echo foot(); ?>
