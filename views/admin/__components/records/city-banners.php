<style>
    #city-banners {
        margin-bottom: 1em;
        padding: 1em 0;
        /*border: 1px dashed red;*/
        overflow-x: scroll;
        height: 290px;
    }

    li.city-banner:not(:last-child) {
        margin-right: 1em;
    }

    li.city-banner {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    li.city-banner.active {
        border: 3px solid blue;
    }

    li.city-banner .button {
        margin: 0;
        padding: 0 1.25em;
    }

    li.city-banner .content > * {
        /*border: 1px dashed red;*/
        width: 300px;
        height: 182px;
    }

    li.city-banner .content {
    }

    li.city-banner .content img {
        object-fit: cover;
    }

    li.city-banner .content p {
        margin: 0;
        padding: 0;
    }
</style>
<ul id="city-banners">
    <?php foreach ($city_banners as $banner): ?>
        <li class="city-banner <?= $banner->active ? "active " : "" ?>">
            <a class="content" href="<?= get_relative_path($banner->get_path()); ?>" target="_blank">
                <img src="<?= get_relative_path($banner->get_thumbnail_path()); ?>" alt="<?= $banner->title; ?>"/>
            </a>
            <p style="text-align: center">
                <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($banner->get_country()->name); ?>/cities/<?= urlencode($banner->get_city()->name); ?>/banners/<?= $banner->id; ?>/edit">Edit</a>
                <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($banner->get_country()->name); ?>/cities/<?= urlencode($banner->get_city()->name); ?>/banners/<?= $banner->id; ?>/delete">Delete</a>
            </p>
        </li>
    <?php endforeach; ?>
</ul>
