<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php
    if (isset($title)) {
        $titleParts[] = strip_formatting($title);
    }
    $titleParts[] = option('site_title');
    $titleParts[] = __('Omeka Admin');
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.2.1/font/bootstrap-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Mono&display=swap"/>

    <link rel="stylesheet" href="<?= css_src("admin"); ?>">

    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-modal.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-alerts-area.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-table.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-records-table.js'></script>
    <script type='module' src='/plugins/SuperEightFestivals/views/admin/javascripts/components/s8f-form.js'></script>
</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar-primary">
        <div class="container">
            <a class="navbar-brand" href="/"><?= option("site_title"); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto ms-2 mb-lg-0">
                </ul>
                <ul class="navbar-nav ms-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/plugins/">Plugins</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/appearance/">Appearance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/users/">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/admin/settings/">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="container">
    <div class="row pt-4">
        <div class="col-2">
        </div>
        <div class="col-10">
            <div class="row">
                <div class="col">
                    <?= $this->partial("__partials/flash.php"); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <s8f-alerts-area id="alerts"></s8f-alerts-area>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h2 class="mb-2"><?= $title; ?></h2>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?= $this->partial("__components/breadcrumbs.php"); ?>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="omeka-panel px-4">