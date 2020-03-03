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
<style>
    #breadcrumbs {
        background-color: #f9f9f9;
        padding: 0.5em;
        border: 1px solid black;
        margin-bottom: 1em;
    }

    #breadcrumbs ul {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    #breadcrumbs ul li {
        display: inline-block;
        list-style-type: circle;
        text-transform: lowercase;
    }

    #breadcrumbs ul li a, #breadcrumbs ul li a:visited {
        color: #c76941;
    }

    #breadcrumbs ul li a:hover {
        color: #e88347;
    }

    #breadcrumbs ul li:not(:last-child):after {
        content: " • ";
    }
</style>

<div id="breadcrumbs">
    <span>Navigation: </span>
    <ul>
        <?php foreach ($parts = getUrlParts() as $part): ?>
            <li><a href="<?= constructURLTrail($parts, $part); ?>"><?= urldecode($part); ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
