<?php
echo head(array(
    'title' => 'Staff',
));
$rootURL = "/admin/super-eight-festivals/staff";
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h2>
                Staff
                <a class="btn btn-success" href="<?= $rootURL; ?>/add">Add Staff</a>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php
            $staff = get_all_staffs();
            ?>
            <?php if (count($staff) == 0): ?>
                <p>There are no staff available.</p>
            <?php else: ?>
                <table id="staff" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <td style="width: 1px;">ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Organization</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td style="width: 1px;"></td>
                        <td style="width: 1px;"></td>
                    </tr>
                    </thead>
                    <?php foreach ($staff as $contributor): ?>
                        <?php
                        $recordRootURL = "$rootURL/" . $contributor->id;
                        ?>
                        <tr>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->id; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->first_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->last_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->organization_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->email; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $contributor->role; ?></span></td>
                            <td><a class="btn btn-primary btn-sm" href="<?= $rootURL; ?>/<?= $contributor->id; ?>/edit">Edit</a></td>
                            <td><a class="btn btn-danger btn-sm" href="<?= $rootURL; ?>/<?= $contributor->id; ?>/delete">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
