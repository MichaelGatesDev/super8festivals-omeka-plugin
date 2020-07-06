<?php

function is_image($path)
{
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    return in_array($ext, get_image_types());
}

function get_image_types()
{
    return array(
        "png",
        "jpg",
        "jpeg",
    );
}

function get_document_types()
{
    return array(
        "pdf",
        "docx",
        "doc",
        "rtf",
    );
}

function get_form_accept_string($arr)
{
    $result = "";
    for ($i = 0; $i < count($arr); $i++) {
        $result .= "." . $arr[$i];
        if ($i < count($arr) - 1) $result .= ",";
    }
    return $result;
}

// ============================================================================================================================================================= \\

function has_temporary_file($inputName)
{
    return $_FILES[$inputName]['name'] != "";
}

/**
 * @param $inputName
 * @return array Returns an array with the original name, temporary name, and extension of the temporary file.
 */
function get_temporary_file($inputName): array
{
    $tmpFileOriginalName = $_FILES[$inputName]['name'];
    $tmpFileName = $_FILES[$inputName]['tmp_name'];
    $ext = pathinfo($tmpFileOriginalName, PATHINFO_EXTENSION);
    return array(
        $tmpFileOriginalName,
        $tmpFileName,
        $ext,
    );
}

/**
 * Moves a file from its current location to a new directory with a new name
 * @param $fromPath
 * @param $newFileName
 * @param $newFileDir
 */
function move_to_dir($fromPath, $newFileName, $newFileDir): void
{
    if (!is_dir($newFileDir)) {
        mkdir($newFileDir, 0777, true);
    }
    move_uploaded_file($fromPath, $newFileDir . "/" . $newFileName);
}

/**
 * Recursively removes directory and all of its contents
 * @param $dir
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}

/**
 * Deletes a file
 * @param $filePath
 */
function delete_file($filePath)
{
    if (!file_exists($filePath) || is_dir($filePath)) return;
    unlink($filePath);
}

/**
 * Deletes directory and all of its contents
 * @param $dirPath
 */
function delete_dir($dirPath)
{
    if (!file_exists($dirPath) || !is_dir($dirPath)) return;
    rrmdir($dirPath);
}


// ============================================================================================================================================================= \\

function create_plugin_directories()
{
    if (!file_exists(get_project_dir())) {
        mkdir(get_project_dir(), 0777, true);
    }
    if (!file_exists(get_countries_dir())) {
        mkdir(get_countries_dir(), 0777, true);
    }
    if (!file_exists(get_federation_dir())) {
        mkdir(get_federation_dir(), 0777, true);
    }
}

function delete_plugin_directories()
{
    if (file_exists(get_project_dir())) {
        rrmdir(get_project_dir());
    }
}

function get_relative_path($dir)
{
    return str_replace(get_root_dir(), "", $dir);
}

function get_root_dir()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function get_project_dir()
{
    return get_root_dir() . "/super-eight-festivals";
}

function get_countries_dir()
{
    return get_project_dir() . "/countries";
}

function get_federation_dir()
{
    return get_project_dir() . "/federation";
}

function generate_missing_thumbnails()
{
    generate_missing_thumbnails_for_all(get_all_city_banners());
    generate_missing_thumbnails_for_all(get_all_federation_newsletters());
    generate_missing_thumbnails_for_all(get_all_federation_photos());
    generate_missing_thumbnails_for_all(get_all_federation_magazines());
    generate_missing_thumbnails_for_all(get_all_federation_bylaws());
    generate_missing_thumbnails_for_all(get_all_film_catalogs());
    generate_missing_thumbnails_for_all(get_all_memorabilia());
    generate_missing_thumbnails_for_all(get_all_photos());
    generate_missing_thumbnails_for_all(get_all_posters());
    generate_missing_thumbnails_for_all(get_all_print_media());
}

function generate_all_thumbnails()
{
    generate_thumbnails_for_all(get_all_city_banners());
    generate_thumbnails_for_all(get_all_federation_newsletters());
    generate_thumbnails_for_all(get_all_federation_photos());
    generate_thumbnails_for_all(get_all_federation_magazines());
    generate_thumbnails_for_all(get_all_federation_bylaws());
    generate_thumbnails_for_all(get_all_film_catalogs());
    generate_thumbnails_for_all(get_all_memorabilia());
    generate_thumbnails_for_all(get_all_photos());
    generate_thumbnails_for_all(get_all_posters());
    generate_thumbnails_for_all(get_all_print_media());
}

function delete_all_thumbnails()
{
    delete_thumbnails_for_all(get_all_city_banners());
    delete_thumbnails_for_all(get_all_federation_newsletters());
    delete_thumbnails_for_all(get_all_federation_photos());
    delete_thumbnails_for_all(get_all_federation_magazines());
    delete_thumbnails_for_all(get_all_federation_bylaws());
    delete_thumbnails_for_all(get_all_film_catalogs());
    delete_thumbnails_for_all(get_all_memorabilia());
    delete_thumbnails_for_all(get_all_photos());
    delete_thumbnails_for_all(get_all_posters());
    delete_thumbnails_for_all(get_all_print_media());
}

function regenerate_all_thumbnails()
{
    delete_all_thumbnails();
    generate_all_thumbnails();
}

function generate_thumbnails_for_all($records)
{
    foreach ($records as $record) {
        $record->create_thumbnail();
    }
}

function delete_thumbnails_for_all($records)
{
    foreach ($records as $record) {
        $record->delete_thumbnail();
    }
}

function generate_missing_thumbnails_for_all($records)
{
    foreach ($records as $record) {
        if ($record->thumbnail_file_name !== "") continue;
        if (!$record->create_thumbnail()) continue;
        $record->save();
    }
}


// ============================================================================================================================================================= \\