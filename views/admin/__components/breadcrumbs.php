<?php

function getUrlParts()
{
    $currentURL = current_url();
    return array_filter(explode("/", $currentURL), function ($part) {
        return !empty($part);
    });
}

function constructURLTrail($parts, $part)
{
    $result = "";
    $idxOfPart = array_search($part, $parts);
    foreach ($parts as $index => $value) {
        if ($index <= $idxOfPart) {
            $result .= "/" . $value;
        }
    }
    return $result;
}

?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb my-4">
        <?php foreach ($parts = getUrlParts() as $part): ?>
            <li class="breadcrumb-item"><a href="<?= constructURLTrail($parts, $part); ?>"><?= urldecode($part); ?></a></li>
        <?php endforeach; ?>
    </ol>
</nav>