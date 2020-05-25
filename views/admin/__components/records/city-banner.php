<style>
    .city-banner {
        line-height: 0;
        list-style-type: none;
        border: 1px solid black;
        display: inline-block;
        padding: 0.5em;
        margin-bottom: 1em;
    }

    .city-banner .button {
        margin: 0;
        padding: 0 1.25em;
    }

    .city-banner .content > * {
        border: 1px dashed black;
        width: 300px;
        height: 182px;
    }

    .city-banner .content {
    }

    .city-banner .content img {
        object-fit: cover;
    }

    .city-banner .content p {
        margin: 0;
        padding: 0;
    }
</style>
<div class="city-banner">
    <a class="content" href="<?= get_relative_path($city_banner->get_path()); ?>" target="_blank">
        <img src="<?= get_relative_path($city_banner->get_thumbnail_path()); ?>" alt="<?= $city_banner->title; ?>" style="object-fit: contain"/>
    </a>
    <p style="text-align: center">
        <a class="button blue" href="/admin/super-eight-festivals/countries/<?= urlencode($city_banner->get_country()->name); ?>/cities/<?= urlencode($city_banner->get_city()->name); ?>/banners/<?= $city_banner->id; ?>/edit">Edit</a>
        <a class="button red" href="/admin/super-eight-festivals/countries/<?= urlencode($city_banner->get_country()->name); ?>/cities/<?= urlencode($city_banner->get_city()->name); ?>/banners/<?= $city_banner->id; ?>/delete">Delete</a>
    </p>
</div>