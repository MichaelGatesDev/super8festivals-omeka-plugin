<?php

class SuperEightFestivals_AdminController extends Omeka_Controller_AbstractActionController
{
    public function federationAction()
    {
    }

    public function debugAction()
    {
    }

    public function debugPurgeAllAction()
    {
    }

    public function debugPurgeUnusedAction()
    {
        foreach (get_all_festivals() as $record) if ($record->get_city() === null) $record->delete();
        foreach (get_all_cities() as $record) if ($record->get_country() === null) $record->delete();
        foreach (get_all_city_banners() as $record) if ($record->get_city() === null) $record->delete();
        foreach (get_all_film_catalogs() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (get_all_festival_filmmakers() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (get_all_memorabilia() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (get_all_photos() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (get_all_posters() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (get_all_print_media() as $record) if ($record->get_festival() === null) $record->delete();
    }

    public function debugCreateTablesAction()
    {
        create_tables();
    }

    public function debugCreateDirectoriesAction()
    {
        create_plugin_directories();
    }

    public function debugGenerateMissingThumbnailsAction()
    {
        generate_missing_thumbnails();
    }

    public function debugRegenerateAllThumbnailsAction()
    {
        regenerate_all_thumbnails();
    }

    public function debugGenerateAllThumbnailsAction()
    {
        generate_all_thumbnails();
    }

    public function debugDeleteAllThumbnailsAction()
    {
        delete_all_thumbnails();
    }

    public function debugFixFestivalsAction()
    {
        foreach (get_all_festivals() as $festival) {
            if ($festival->id === -1) $festival->id = 0;
            if ($festival->year === -1) $festival->year = 0;
            $festival->save();
        }
    }
}
