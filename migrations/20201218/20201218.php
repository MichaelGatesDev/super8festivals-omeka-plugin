<?php

class S8F_DB_Migration_20201218 extends S8FDatabaseMigration
{
    function migrate_staff($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 8) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Staff");
                continue;
            }

            $id = $exploded[0];
            $role = $exploded[1];
            $first_name = $exploded[2];
            $last_name = $exploded[3];
            $organization_name = $exploded[4];
            $email = $exploded[5];
            $file_name = $exploded[6];
            $thumbnail_file_name = $exploded[7];

            try {
                $staff = new SuperEightFestivalsStaff();
                $staff->id = (int) $id;
                $staff->role = (string) $role;

                $person = new SuperEightFestivalsPerson();
                $person->first_name = (string) $first_name;
                $person->last_name = (string) $last_name;
                $person->organization_name = (string) $organization_name;
                $person->email = (string) $email;
                $person->save();
                $staff->person_id = $person->id;

                $file = new SuperEightFestivalsFile();
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->save();
                $staff->file_id = $file->id;

                $staff->save();
            } catch (Exception $e) {
                if ($staff) $staff->delete();
                if ($person) $person->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_contributors($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 5) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Contributors");
                continue;
            }

            $id = $exploded[0];
            $first_name = $exploded[1];
            $last_name = $exploded[2];
            $organization_name = $exploded[3];
            $email = $exploded[4];

            try {
                $contributor = new SuperEightFestivalsContributor();
                $contributor->id = (int) $id;

                $person = new SuperEightFestivalsPerson();
                $person->first_name = (string) $first_name;
                $person->last_name = (string) $last_name;
                $person->organization_name = (string) $organization_name;
                $person->email = (string) $email;
                $person->save();
                $contributor->person_id = $person->id;

                $contributor->save();
            } catch (Exception $e) {
                if ($contributor) $contributor->delete();
                if ($person) $person->delete();
            }
        }
    }

    function migrate_countries($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 4) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Countries");
                continue;
            }

            $id = $exploded[0];
            $name = $exploded[1];
            $latitude = $exploded[2];
            $longitude = $exploded[3];;

            try {
                $country = new SuperEightFestivalsCountry();
                $country->id = (int) $id;

                $location = new SuperEightFestivalsLocation();
                $location->latitude = (float) $latitude;
                $location->longitude = (float) $longitude;
                $location->name = (string) $name;
                $location->save();
                $country->location_id = $location->id;

                $country->save();
            } catch (Exception $e) {
                if ($location) $location->delete();
                if ($country) $country->delete();
            }
        }
    }

    function migrate_cities($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Cities");
                continue;
            }

            $id = $exploded[0];
            $country_id = $exploded[1];
            $name = $exploded[2];
            $latitude = $exploded[3];
            $longitude = $exploded[4];
            $description = $exploded[5];

            try {
                $city = new SuperEightFestivalsCity();
                $city->id = (int) $id;
                $city->country_id = (int) $country_id;

                $location = new SuperEightFestivalsLocation();
                $location->latitude = (float) $latitude;
                $location->longitude = (float) $longitude;
                $location->name = (string) $name;
                $location->description = (string) $description;
                $location->save();
                $city->location_id = $location->id;

                $city->save();
            } catch (Exception $e) {
                if ($location) $location->delete();
                if ($city) $city->delete();
            }
        }
    }

    function migrate_city_banners($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 8) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: City Banners");
                continue;
            }

            $id = $exploded[0];
            $city_id = $exploded[1];
            $contributor_id = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $file_name = $exploded[6];
            $active = $exploded[7];

            try {
                $city_banner = new SuperEightFestivalsCityBanner();
                $city_banner->id = (int) $id;
                $city_banner->city_id = (int) $city_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $city_banner->file_id = $file->id;

                $city_banner->save();
            } catch (Exception $e) {
                if ($city_banner) $city_banner->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_festivals($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 5) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Festivals");
                continue;
            }

            $id = $exploded[0];
            $city_id = $exploded[1];
            $year = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];

            try {
                $festival = new SuperEightFestivalsFestival();
                $festival->id = (int) $id;
                $festival->city_id = (int) $city_id;
                $festival->year = (int) $year;

                $festival->save();
            } catch (Exception $e) {
                if ($festival) $festival->delete();
            }
        }
    }

    function migrate_festival_film_catalogs($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 7) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Festival Film Catalogs");
                continue;
            }

            $id = $exploded[0];
            $festival_id = $exploded[1];
            $contributor_id = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $file_name = $exploded[6];

            try {
                $film_catalog = new SuperEightFestivalsFestivalFilmCatalog();
                $film_catalog->id = (int) $id;
                $film_catalog->festival_id = (int) $festival_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $film_catalog->file_id = $file->id;

                $film_catalog->save();
            } catch (Exception $e) {
                if ($film_catalog) $film_catalog->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_festival_photos($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 7) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Festival Photos");
                continue;
            }

            $id = $exploded[0];
            $festival_id = $exploded[1];
            $contributor_id = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $file_name = $exploded[6];

            try {
                $photo = new SuperEightFestivalsFestivalPhoto();
                $photo->id = (int) $id;
                $photo->festival_id = (int) $festival_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $photo->file_id = $file->id;

                $photo->save();
            } catch (Exception $e) {
                if ($photo) $photo->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_festival_posters($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 7) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Festival Posters");
                continue;
            }

            $id = $exploded[0];
            $festival_id = $exploded[1];
            $contributor_id = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $file_name = $exploded[6];

            try {
                $poster = new SuperEightFestivalsFestivalPoster();
                $poster->id = (int) $id;
                $poster->festival_id = (int) $festival_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $poster->file_id = $file->id;

                $poster->save();
            } catch (Exception $e) {
                if ($poster) $poster->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_festival_print_media($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 7) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Festival Print Media");
                continue;
            }

            $id = $exploded[0];
            $festival_id = $exploded[1];
            $contributor_id = $exploded[2];
            $title = $exploded[3];
            $description = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $file_name = $exploded[6];

            try {
                $print_media = new SuperEightFestivalsFestivalPrintMedia();
                $print_media->id = (int) $id;
                $print_media->festival_id = (int) $festival_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $print_media->file_id = $file->id;

                $print_media->save();
            } catch (Exception $e) {
                if ($print_media) $print_media->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_federation_bylaws($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Federation By-Laws");
                continue;
            }

            $id = $exploded[0];
            $title = $exploded[1];
            $description = $exploded[2];
            $file_name = $exploded[3];
            $thumbnail_file_name = $exploded[4];
            $contributor_id = $exploded[5];

            try {
                $federation_bylaw = new SuperEightFestivalsFederationBylaw();
                $federation_bylaw->id = (int) $id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $federation_bylaw->file_id = $file->id;

                $federation_bylaw->save();
            } catch (Exception $e) {
                if ($federation_bylaw) $federation_bylaw->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_federation_magazines($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Federation Magazines");
                continue;
            }

            $id = $exploded[0];
            $title = $exploded[1];
            $description = $exploded[2];
            $file_name = $exploded[3];
            $thumbnail_file_name = $exploded[4];
            $contributor_id = $exploded[5];

            try {
                $federation_magazine = new SuperEightFestivalsFederationMagazine();
                $federation_magazine->id = (int) $id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $federation_magazine->file_id = $file->id;

                $federation_magazine->save();
            } catch (Exception $e) {
                if ($federation_magazine) $federation_magazine->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_federation_newsletters($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Federation Newsletters");
                continue;
            }

            $id = $exploded[0];
            $title = $exploded[1];
            $description = $exploded[2];
            $file_name = $exploded[3];
            $thumbnail_file_name = $exploded[4];
            $contributor_id = $exploded[5];

            try {
                $federation_newsletter = new SuperEightFestivalsFederationNewsletter();
                $federation_newsletter->id = (int) $id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $federation_newsletter->file_id = $file->id;

                $federation_newsletter->save();
            } catch (Exception $e) {
                if ($federation_newsletter) $federation_newsletter->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_federation_photos($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Federation Photos");
                continue;
            }

            $id = $exploded[0];
            $contributor_id = $exploded[1];
            $title = $exploded[2];
            $description = $exploded[3];
            $thumbnail_file_name = $exploded[4];
            $file_name = $exploded[5];

            try {
                $federation_photo = new SuperEightFestivalsFederationPhoto();
                $federation_photo->id = (int) $id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $federation_photo->file_id = $file->id;

                $federation_photo->save();
            } catch (Exception $e) {
                if ($federation_photo) $federation_photo->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_filmmakers($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 6) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Filmmakers");
                continue;
            }

            $id = $exploded[0];
            $city_id = $exploded[1];
            $first_name = $exploded[2];
            $last_name = $exploded[3];
            $organization_name = $exploded[4];
            $email = $exploded[5];

            try {
                $filmmaker = new SuperEightFestivalsFilmmaker();
                $filmmaker->id = (int) $id;

                $person = new SuperEightFestivalsPerson();
                $person->first_name = (string) $first_name;
                $person->last_name = (string) $last_name;
                $person->organization_name = (string) $organization_name;
                $person->email = (string) $email;
                $person->save();
                $filmmaker->person_id = $person->id;

                $filmmaker->save();
            } catch (Exception $e) {
                if ($filmmaker) $filmmaker->delete();
                if ($person) $person->delete();
            }
        }
    }

    function migrate_filmmaker_photos($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 7) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Filmmaker Photos");
                continue;
            }

            $id = $exploded[0];
            $filmmaker_id = $exploded[1];
            $title = $exploded[2];
            $description = $exploded[3];
            $file_name = $exploded[4];
            $thumbnail_file_name = $exploded[5];
            $contributor_id = $exploded[6];

            try {
                $filmmaker_photo = new SuperEightFestivalsFilmmakerPhoto();
                $filmmaker_photo->id = (int) $id;
                $filmmaker_photo->filmmaker_id = (int) $filmmaker_id;

                $file = new SuperEightFestivalsFile();
                $file->title = (string) $title;
                $file->description = (string) $description;
                $file->file_name = (string) $file_name;
                $file->thumbnail_file_name = (string) $thumbnail_file_name;
                $file->contributor_id = (int) $contributor_id;
                $file->save();
                $filmmaker_photo->file_id = $file->id;

                $filmmaker_photo->save();
            } catch (Exception $e) {
                if ($filmmaker_photo) $filmmaker_photo->delete();
                if ($file) $file->delete();
            }
        }
    }

    function migrate_films($csv_lines)
    {
        foreach ($csv_lines as $index => $line) {
            $exploded = explode("|", $line);
            if (count($exploded) != 10) {
                logger_log(LogLevel::Warning, "Malformed line size at line ${index} of: Films");
                continue;
            }
            $id = $exploded[0];
            $festival_id = $exploded[1];
            $filmmaker_id = $exploded[2];
            $contributor_id = $exploded[3];
            $title = $exploded[4];
            $description = $exploded[5];
            $thumbnail_file_name = $exploded[6];
            $thumbnail_url_web = $exploded[7];
            $embed_src = $exploded[8];
            $file_name = $exploded[9];

            try {
                $filmmaker_film = new SuperEightFestivalsFilmmakerFilm();
                $filmmaker_film->id = (int) $id;
                $filmmaker_film->filmmaker_id = (int) $filmmaker_id;

                $embed = new SuperEightFestivalsEmbed();
                $embed->title = (string) $title;
                $embed->description = (string) $description;
                $embed->contributor_id = (int) $contributor_id;
                $embed->embed = $embed_src;
                $embed->save();
                $filmmaker_film->embed_id = $embed->id;

                $filmmaker_film->save();

                $festival_film = new SuperEightFestivalsFestivalFilm();
                $festival_film->festival_id = $festival_id;
                $festival_film->filmmaker_film_id = $filmmaker_film->id;
                $festival_film->save();
            } catch (Exception $e) {
                if ($filmmaker_film) $filmmaker_film->delete();
                if ($embed) $embed->delete();
                if ($festival_film) $festival_film->delete();
            }
        }
    }

    function run_migrations()
    {
        $this->migrate_contributors($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_contributors.csv"));
        $this->migrate_staff($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_staffs.csv"));
        $this->migrate_federation_bylaws($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_federation_bylaws.csv"));
        $this->migrate_federation_magazines($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_federation_magazines.csv"));
        $this->migrate_federation_newsletters($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_federation_newsletters.csv"));
        $this->migrate_federation_photos($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_federation_photos.csv"));
        $this->migrate_countries($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_countries.csv"));
        $this->migrate_cities($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_cities.csv"));
        $this->migrate_city_banners($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_city_banners.csv"));
        $this->migrate_festivals($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festivals.csv"));
        $this->migrate_festival_film_catalogs($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festival_film_catalogs.csv"));
        $this->migrate_festival_photos($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festival_photos.csv"));
        $this->migrate_festival_posters($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festival_posters.csv"));
        $this->migrate_festival_print_media($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festival_print_medias.csv"));
        $this->migrate_filmmakers($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_filmmakers.csv"));
        $this->migrate_filmmaker_photos($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_filmmaker_photos.csv"));
        $this->migrate_films($this->get_csv_lines(__DIR__ . "/csv/superfes_om2_table_om_super_eight_festivals_festival_films.csv"));
    }
}