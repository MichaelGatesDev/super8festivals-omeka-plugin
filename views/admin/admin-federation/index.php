<?php
echo head(array(
    'title' => "Federation"
));

$bylaws = SuperEightFestivalsFederationBylaw::get_all();
$magazines = SuperEightFestivalsFederationMagazine::get_all();
$newsletters = SuperEightFestivalsFederationNewsletter::get_all();
$photos = SuperEightFestivalsFederationPhoto::get_all();
?>

<section class="container">

    <?= $this->partial("__partials/flash.php"); ?>

    <div class="row">
        <div class="col">
            <?= $this->partial("__components/breadcrumbs.php"); ?>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <h2>Federation</h2>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                By-Laws
                <a class="btn btn-sm btn-success" href="/admin/super-eight-festivals/federation/bylaws/add/">Add</a>
            </h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File Name</th>
                    <th>Thumbnail File Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bylaws as $bylaw): ?>
                    <tr>
                        <td><?= $bylaw->id; ?></td>
                        <td><?= html_escape($bylaw->title); ?></td>
                        <td><?= html_escape($bylaw->description); ?></td>
                        <td><a href="<?= get_relative_path($bylaw->get_path()) ?>" target="_blank"><?= $bylaw->file_name; ?></a></td>
                        <td><a href="<?= get_relative_path($bylaw->get_thumbnail_path()) ?>" target="_blank"><?= $bylaw->thumbnail_file_name; ?></a></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" href="/admin/super-eight-festivals/federation/bylaws/<?= $bylaw->id; ?>/edit/">Edit</a>
                                <a class="btn btn-sm btn-danger" href="/admin/super-eight-festivals/federation/bylaws/<?= $bylaw->id; ?>/delete/">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Magazines
                <a class="btn btn-sm btn-success" href="/admin/super-eight-festivals/federation/magazines/add/">Add</a>
            </h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File Name</th>
                    <th>Thumbnail File Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($magazines as $magazine): ?>
                    <tr>
                        <td><?= $magazine->id; ?></td>
                        <td><?= html_escape($magazine->title); ?></td>
                        <td><?= html_escape($magazine->description); ?></td>
                        <td><a href="<?= get_relative_path($magazine->get_path()) ?>" target="_blank"><?= $magazine->file_name; ?></a></td>
                        <td><a href="<?= get_relative_path($magazine->get_thumbnail_path()) ?>" target="_blank"><?= $magazine->thumbnail_file_name; ?></a></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" href="/admin/super-eight-festivals/federation/magazines/<?= $magazine->id; ?>/edit/">Edit</a>
                                <a class="btn btn-sm btn-danger" href="/admin/super-eight-festivals/federation/magazines/<?= $magazine->id; ?>/delete/">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <h3>
                Newsletters
                <a class="btn btn-sm btn-success" href="/admin/super-eight-festivals/federation/newsletters/add/">Add</a>
            </h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File Name</th>
                    <th>Thumbnail File Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($newsletters as $newsletter): ?>
                    <tr>
                        <td><?= $newsletter->id; ?></td>
                        <td><?= html_escape($newsletter->title); ?></td>
                        <td><?= html_escape($newsletter->description); ?></td>
                        <td><a href="<?= get_relative_path($newsletter->get_path()) ?>" target="_blank"><?= $newsletter->file_name; ?></a></td>
                        <td><a href="<?= get_relative_path($newsletter->get_thumbnail_path()) ?>" target="_blank"><?= $newsletter->thumbnail_file_name; ?></a></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" href="/admin/super-eight-festivals/federation/newsletters/<?= $newsletter->id; ?>/edit/">Edit</a>
                                <a class="btn btn-sm btn-danger" href="/admin/super-eight-festivals/federation/newsletters/<?= $newsletter->id; ?>/delete/">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>
                Photos
                <a class="btn btn-sm btn-success" href="/admin/super-eight-festivals/federation/photos/add/">Add</a>
            </h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>File Name</th>
                    <th>Thumbnail File Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($photos as $photo): ?>
                    <tr>
                        <td><?= $photo->id; ?></td>
                        <td><?= html_escape($photo->title); ?></td>
                        <td><?= html_escape($photo->description); ?></td>
                        <td><a href="<?= get_relative_path($photo->get_path()) ?>" target="_blank"><?= $photo->file_name; ?></a></td>
                        <td><a href="<?= get_relative_path($photo->get_thumbnail_path()) ?>" target="_blank"><?= $photo->thumbnail_file_name; ?></a></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" href="/admin/super-eight-festivals/federation/photos/<?= $photo->id; ?>/edit/">Edit</a>
                                <a class="btn btn-sm btn-danger" href="/admin/super-eight-festivals/federation/photos/<?= $photo->id; ?>/delete/">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</section>

<?php echo foot(); ?>

