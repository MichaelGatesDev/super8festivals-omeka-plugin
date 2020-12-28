<?php

const supported_image_mimes = [
    "image/png",
    "image/jpeg",
];

const supported_document_mimes = [
    "application/pdf",
];

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
    if(!is_uploaded_file($tmpFileName)) {
        throw new Exception("File upload failed. Try another file format.");
    }
    $ext = pathinfo($tmpFileOriginalName, PATHINFO_EXTENSION);
    $tmpFileMime = mime_content_type($tmpFileName);

    return array(
        $tmpFileOriginalName,
        $tmpFileName,
        $ext,
        $tmpFileMime,
    );
}

/**
 * Moves a file from its current location to a new directory with a new name
 * @param $fromPath
 * @param $newFileName
 * @param $newFileDir
 */
function move_tempfile_to_dir($fromPath, $newFileName, $newFileDir): void
{
    if (!is_dir($newFileDir)) {
        mkdir($newFileDir, 0775, true);
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

function find_path_to_file($file_name)
{
    $di = new RecursiveDirectoryIterator(get_project_dir(), RecursiveDirectoryIterator::SKIP_DOTS);
    $it = new RecursiveIteratorIterator($di);
    $results = [];
    foreach ($it as $file) {
        if (strpos($file, $file_name)) {
            array_push($results, $file);
        }
    }
    return $results;
}

// ============================================================================================================================================================= \\

function create_plugin_directories()
{
    if (!file_exists(get_project_dir())) {
        mkdir(get_project_dir(), 0775, true);
    }
    if (!file_exists(get_uploads_dir())) {
        mkdir(get_uploads_dir(), 0775, true);
    }
    if (!file_exists(get_logs_dir())) {
        mkdir(get_logs_dir(), 0775, true);
    }
}

function delete_plugin_directories()
{
    if (file_exists(get_project_dir())) {
        rrmdir(get_project_dir());
    }
}

function get_root_dir()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function get_project_dir()
{
    return get_root_dir() . "/super-eight-festivals";
}

function get_uploads_dir()
{
    return get_project_dir() . "/uploads";
}

function get_logs_dir()
{
    return get_project_dir() . "/logs";
}

function get_relative_path($dir)
{
    return str_replace(get_root_dir(), "", $dir);
}

function generate_missing_thumbnails()
{
    generate_missing_thumbnails_for_all(SuperEightFestivalsCityBanner::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFederationNewsletter::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFederationBylaw::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFestivalFilmCatalog::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFestivalPhoto::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFestivalPoster::get_all());
    generate_missing_thumbnails_for_all(SuperEightFestivalsFestivalPrintMedia::get_all());
}

function generate_all_thumbnails()
{
    generate_thumbnails_for_all(SuperEightFestivalsCityBanner::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFederationNewsletter::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFederationBylaw::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFestivalFilmCatalog::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFestivalPhoto::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFestivalPoster::get_all());
    generate_thumbnails_for_all(SuperEightFestivalsFestivalPrintMedia::get_all());
}

function delete_all_thumbnails()
{
    delete_thumbnails_for_all(SuperEightFestivalsCityBanner::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFederationNewsletter::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFederationPhoto::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFederationBylaw::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFestivalFilmCatalog::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFestivalPhoto::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFestivalPoster::get_all());
    delete_thumbnails_for_all(SuperEightFestivalsFestivalPrintMedia::get_all());
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