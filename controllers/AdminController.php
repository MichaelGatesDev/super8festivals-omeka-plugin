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
        foreach (SuperEightFestivalsCity::get_all() as $record) if ($record->get_country() === null) $record->delete();

        foreach (SuperEightFestivalsFestival::get_all() as $record) if ($record->get_city() === null) $record->delete();
        foreach (SuperEightFestivalsCityBanner::get_all() as $record) if ($record->get_city() === null) $record->delete();
        foreach (SuperEightFestivalsFilmmaker::get_all() as $record) if ($record->get_city() === null) $record->delete();

        foreach (SuperEightFestivalsFestivalFilmCatalog::get_all() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (SuperEightFestivalsFestivalMemorabilia::get_all() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (SuperEightFestivalsFestivalPhoto::get_all() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (SuperEightFestivalsFestivalPoster::get_all() as $record) if ($record->get_festival() === null) $record->delete();
        foreach (SuperEightFestivalsFestivalPrintMedia::get_all() as $record) if ($record->get_festival() === null) $record->delete();
    }

    public function debugCreateTablesAction()
    {
        create_tables();
    }

    public function debugCreateMissingColumnsAction()
    {
        create_all_missing_columns();
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
        foreach (SuperEightFestivalsFestival::get_all() as $festival) {
            if ($festival->id === -1) $festival->id = 0;
            if ($festival->year === -1) $festival->year = 0;
            $festival->save();
        }
    }
}
