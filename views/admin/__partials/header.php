<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($title) ? $title : "Untitled" ?></title>


    <link rel="stylesheet" href="/plugins/SuperEightFestivals/views/shared/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/plugins/SuperEightFestivals/views/shared/css/vendor/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/plugins/SuperEightFestivals/views/shared/css/vendor/jquery-ui.css">
    <link rel="stylesheet" href="/plugins/SuperEightFestivals/views/shared/css/vendor/ol.css">

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-modal.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-alerts-area.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-table.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-form.js'></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/admin/">Omeka Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/admin/super-eight-festivals/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/super-eight-festivals/countries">Countries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/super-eight-festivals/federation/">Federation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/super-eight-festivals/filmmakers/">Filmmakers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/super-eight-festivals/contributors/">Contributors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/super-eight-festivals/staff/">Site Staff</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/" tabindex="-1" aria-disabled="true">Site Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>