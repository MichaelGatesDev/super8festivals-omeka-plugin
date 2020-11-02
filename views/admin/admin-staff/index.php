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
            $staffs = SuperEightFestivalsStaff::get_all();
            ?>
            <?php if (count($staffs) == 0): ?>
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
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <?php foreach ($staffs as $staff): ?>
                        <?php
                        $recordRootURL = "$rootURL/" . $staff->id;
                        ?>
                        <tr>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->id; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->first_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->last_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->organization_name; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->email; ?></span></td>
                            <td style="cursor: pointer;"><span class="title"><?= $staff->role; ?></span></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm" href="<?= $rootURL; ?>/<?= $staff->id; ?>/edit">Edit</a>
                                    <a class="btn btn-danger btn-sm" href="<?= $rootURL; ?>/<?= $staff->id; ?>/delete">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php echo foot(); ?>
