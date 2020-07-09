<?php
if (!isset($card_width)) $card_width = "256px";
if (!isset($embed)) $embed = null;
if (!isset($thumbnail_path)) $thumbnail_path = null;
if (!isset($preview_path)) $preview_path = null;
if (!isset($fancybox_category)) $fancybox_category = "changeme";
if (!isset($information)) $information = array(
    array('key' => 'change', 'value' => 'me')
);
if (!isset($admin)) $admin = false;
?>

<div class="card d-inline-block p-0 my-2 mx-2" style="width: <?= $card_width; ?>;">
    <?php if ($embed): ?>
        <div style="overflow: hidden;">
            <?= $embed; ?>
        </div>
    <?php elseif ($thumbnail_path): ?>
        <a href="<?= $preview_path; ?>" data-fancybox="fb-<?= $fancybox_category; ?>">
            <img
                    class="card-img-top"
                    src="<?= $thumbnail_path; ?>"
                    alt="<?= $thumbnail_alt ?? "" ?>"
                    style="object-fit: cover; height: <?= $preview_height; ?>; "
            />
        </a>
    <?php endif; ?>
    <div class="card-body" style="height: 250px; max-height: 180px; overflow-y: auto;">
        <?php foreach ($information as $info): ?>
            <p>
                <span class="font-weight-bold text-capitalize"><?= $info['key']; ?>:</span>
                <span><?= $info['value']; ?></span>
            </p>
        <?php endforeach; ?>
    </div>
    <?php if ($admin): ?>
        <div class="card-footer">
            <a class="btn btn-primary" href="<?= $edit_url ?>">Edit</a>
            <a class="btn btn-danger" href="<?= $delete_url ?>">Delete</a>
        </div>
    <?php endif; ?>
</div>