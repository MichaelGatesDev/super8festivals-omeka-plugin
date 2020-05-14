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
        $countries = get_all_countries();

        $cities = get_all_cities();
        foreach ($cities as $city) {
            if ($city->get_country() === null) {
                $city->delete();
            }
        }

        $festivals = get_all_festivals();
        foreach ($festivals as $festival) {
            if ($festival->get_city() === null) {
                $festival->delete();
            }
        }
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
}
