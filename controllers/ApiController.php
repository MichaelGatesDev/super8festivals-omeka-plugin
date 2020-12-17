<?php

class SuperEightFestivals_ApiController extends Omeka_Controller_AbstractActionController
{
    // ======================================================================================================================== \\

    public function indexAction()
    {
        $this->authCheck();
    }

    private function getJsonResponseArray($status, $message, $data = null)
    {
        return array(
            "status" => $status,
            "message" => $message,
            "data" => $data,
        );
    }

    public function authCheck()
    {
        $user = current_user();
        if (!$user || $user->role !== "super") {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", "You must be signed in to access the S8F REST API."));
            return;
        }
    }

    // ======================================================================================================================== \\

    public function allUsersAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $users = [];
                foreach (get_all_users() as $user) {
                    array_push($users, filter_array($user, ["password", "salt"]));
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all users", $users));
            } else if ($request->isPost()) {
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function singleUserAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $user_id = $request->getParam("user");
            $user = get_db()->getTable("User")->find($user_id);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched country", filter_array($user, ["password", "salt"])));
            } else if ($request->isPost()) {
            } else if ($request->isDelete()) {
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function migrationsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $migration_name = $request->getParam("migration-name");

            $migration_script_file_path = __DIR__ . "/../migrations/" . $migration_name . "/" . "$migration_name.php";
            if (!file_exists($migration_script_file_path)) {
                throw new Exception("Migration file does not exist: {$migration_script_file_path}");
            }

            $class = "S8F_DB_Migration_" . $migration_name;
            if (!class_exists($class)) {
                throw new Exception("No class exists in file: ${migration_script_file_path}");
            }

            $reflect = new ReflectionClass($class);
            if ($reflect->isAbstract() || !$reflect->isSubclassOf(S8FDatabaseMigration::class)) {
                throw new Exception("Class is either abstract or is not subclass of S8FDatabaseMigration");
            }

            $instance = new $class;
            $instance->run_migrations();

            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Performed migration $migration_name"));
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function federationNewslettersAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $newsletters = [];
                foreach (SuperEightFestivalsFederationNewsletter::get_all() as $newsletter) {
                    array_push($newsletters, $newsletter->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation newsletters", $newsletters));
            } else if ($request->isPost()) {

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $newsletter = new SuperEightFestivalsFederationNewsletter();
                try {
                    $newsletter->upload_file("file");
                    $newsletter->update([
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created federation newsletter", $newsletter->to_array()));
                } catch (Exception $e) {
                    if ($newsletter->id !== 0) $newsletter->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationNewsletterAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $newsletter = get_request_param_by_id($request, SuperEightFestivalsFederationNewsletter::class, "newsletterID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation newsletter", $newsletter->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $newsletter->get_file()) $file->delete();
                    $newsletter->upload_file("file");
                }
                $newsletter->update([
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation newsletter", $newsletter->to_array()));
            } else if ($request->isDelete()) {
                $arr = $newsletter->to_array();
                $newsletter->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted federation newsletter", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationPhotosAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $photos = [];
                foreach (SuperEightFestivalsFederationPhoto::get_all() as $photo) {
                    array_push($photos, $photo->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation photos", $photos));
            } else if ($request->isPost()) {

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsFederationPhoto();
                try {
                    $photo->upload_file("file");
                    $photo->update([
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created federation photo", $photo->to_array()));
                } catch (Exception $e) {
                    if ($photo->id !== 0) $photo->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationPhotoAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $photo = get_request_param_by_id($request, SuperEightFestivalsFederationPhoto::class, "photoID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation photo", $photo->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file");
                }
                $photo->update([
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $arr = $photo->to_array();
                $photo->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted federation photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationBylawsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $bylaws = [];
                foreach (SuperEightFestivalsFederationBylaw::get_all() as $bylaw) {
                    array_push($bylaws, $bylaw->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation by-laws", $bylaws));
            } else if ($request->isPost()) {

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $bylaw = new SuperEightFestivalsFederationBylaw();
                try {
                    $bylaw->upload_file("file");
                    $bylaw->update([
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created federation by-law", $bylaw->to_array()));
                } catch (Exception $e) {
                    if ($bylaw->id !== 0) $bylaw->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationBylawAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $bylaw = get_request_param_by_id($request, SuperEightFestivalsFederationBylaw::class, "bylawID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation by-law", $bylaw->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $bylaw->get_file()) $file->delete();
                    $bylaw->upload_file("file");
                }
                $bylaw->update([
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation by-law", $bylaw->to_array()));
            } else if ($request->isDelete()) {
                $arr = $bylaw->to_array();
                $bylaw->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted federation by-law", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationMagazinesAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $magazines = [];
                foreach (SuperEightFestivalsFederationMagazine::get_all() as $magazine) {
                    array_push($magazines, $magazine->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation magazines", $magazines));
            } else if ($request->isPost()) {

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $magazine = new SuperEightFestivalsFederationMagazine();
                try {
                    $magazine->upload_file("file");
                    $magazine->update([
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created federation magazine", $magazine->to_array()));
                } catch (Exception $e) {
                    if ($magazine->id !== 0) $magazine->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function federationMagazineAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $magazine = get_request_param_by_id($request, SuperEightFestivalsFederationMagazine::class, "magazineID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation magazine", $magazine->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $magazine->get_file()) $file->delete();
                    $magazine->upload_file("file");
                }
                $magazine->update([
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation magazine", $magazine->to_array()));
            } else if ($request->isDelete()) {
                $arr = $magazine->to_array();
                $magazine->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted federation magazine", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function contributorsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $contributors = [];
                foreach (SuperEightFestivalsContributor::get_all() as $contributor) {
                    array_push($contributors, $contributor->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all contributors", $contributors));
            } else if ($request->isPost()) {
                $contributor = SuperEightFestivalsContributor::create([
                    "role" => $request->getParam("role", ""),
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
//                if (has_temporary_file("file")) {
//                    $contributor->upload_file("file");
//                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created contributor", $contributor->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function contributorAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $contributor = get_request_param_by_id($request, SuperEightFestivalsContributor::class, "contributor");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched contributor", $contributor->to_array()));
            } else if ($request->isPost()) {
                $contributor->update([
                    "role" => $request->getParam("role", ""),
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
//                if (has_temporary_file("file")) {
//                    if ($file = $contributor->get_file()) $file->delete();
//                    $contributor->upload_file("file");
//                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated contributor", $contributor->to_array()));
            } else if ($request->isDelete()) {
                $arr = $contributor->to_array();
                $contributor->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted contributor", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function staffsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $staffs = [];
                foreach (SuperEightFestivalsStaff::get_all() as $staff) {
                    array_push($staffs, $staff->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all staff", $staffs));
            } else if ($request->isPost()) {
                $staff = SuperEightFestivalsStaff::create([
                    "role" => $request->getParam("role", ""),
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
                if (has_temporary_file("file")) {
                    $staff->upload_file("file");
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created staff", $staff->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function staffAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $staff = get_request_param_by_id($request, SuperEightFestivalsStaff::class, "staff");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched staff", $staff->to_array()));
            } else if ($request->isPost()) {
                $staff->update([
                    "role" => $request->getParam("role", ""),
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
                if (has_temporary_file("file")) {
                    if ($file = $staff->get_file()) $file->delete();
                    $staff->upload_file("file");
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated staff", $staff->to_array()));
            } else if ($request->isDelete()) {
                $arr = $staff->to_array();
                $staff->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted staff", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function filmsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $films = [];
                foreach (SuperEightFestivalsFilmmakerFilm::get_all() as $film) {
                    array_push($films, $film->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all filmmaker films", $films));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakersAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $filmmakers = [];
                foreach (SuperEightFestivalsFilmmaker::get_all() as $filmmaker) {
                    array_push($filmmakers, $filmmaker->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all filmmakers", $filmmakers));
            } else if ($request->isPost()) {
                $filmmaker = SuperEightFestivalsFilmmaker::create([
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
//                if (has_temporary_file("file")) {
//                    $filmmaker->upload_file("file");
//                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created filmmaker", $filmmaker->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakerAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker", $filmmaker->to_array()));
            } else if ($request->isPost()) {
                $filmmaker->update([
                    "person" => [
                        "first_name" => $request->getParam("first_name", ""),
                        "last_name" => $request->getParam("last_name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization_name", ""),
                    ],
                ]);
//                if (has_temporary_file("file")) {
//                    if ($file = $filmmaker->get_file()) $file->delete();
//                    $filmmaker->upload_file("file");
//                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker", $filmmaker->to_array()));
            } else if ($request->isDelete()) {
                $arr = $filmmaker->to_array();
                $filmmaker->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted filmmaker", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakerPhotosAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");

            if ($request->isGet()) {
                $photos = [];
                foreach ($filmmaker->get_photos() as $photo) {
                    array_push($photos, $photo->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all filmmaker photos", $photos));
            } else if ($request->isPost()) {

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsFilmmakerPhoto();
                try {
                    $photo->upload_file("file");
                    $photo->update([
                        "filmmaker_id" => $filmmaker->id,
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created filmmaker photo", $photo->to_array()));
                } catch (Exception $e) {
                    if ($photo->id !== 0) $photo->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakerPhotoAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");
            $photo = get_request_param_by_id($request, SuperEightFestivalsFilmmakerPhoto::class, "photo");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker photo", $photo->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file");
                }
                $photo->update([
                    "filmmaker_id" => $filmmaker->id,
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $arr = $photo->to_array();
                $photo->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted filmmaker photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakerFilmsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");

            if ($request->isGet()) {
                $films = [];
                foreach ($filmmaker->get_films() as $film) {
                    array_push($films, $film->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all filmmaker films", $films));
            } else if ($request->isPost()) {
                $film = SuperEightFestivalsFilmmakerFilm::create([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                        "embed" => $request->getParam("embed", ""),
                    ],
                ]);
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created filmmaker film", $film->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function filmmakerFilmAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");
            $film = get_request_param_by_id($request, SuperEightFestivalsFilmmakerFilm::class, "film");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker film", $film->to_array()));
            } else if ($request->isPost()) {
                $film->update([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                        "embed" => $request->getParam("embed", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker film", $film->to_array()));
            } else if ($request->isDelete()) {
                $arr = $film->to_array();
                $film->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted filmmaker film", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function citiesAction()
    {
        $this->authCheck();
        try {
            $cities = [];
            foreach (SuperEightFestivalsCity::get_all() as $city) {
                array_push($cities, $city->to_array());
            }
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all cities", $cities));
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function cityAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched city", $city->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function festivalsAction()
    {
        $this->authCheck();
        try {
            $cities = [];
            foreach (SuperEightFestivalsFestival::get_all() as $festival) {
                array_push($cities, $festival->to_array());
            }
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festivals", $cities));
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function festivalAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function countriesAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $countries = [];
                foreach (SuperEightFestivalsCountry::get_all() as $country) {
                    array_push($countries, $country->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all countries", $countries));
            } else if ($request->isPost()) {
                $country = SuperEightFestivalsCountry::create([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created country", $country->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched country", $country->to_array()));
            } else if ($request->isPost()) {
                $country->update([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated country", $country->to_array()));
            } else if ($request->isDelete()) {
                $arr = $country->to_array();
                $country->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted country", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCitiesAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);

            if ($request->isGet()) {
                $cities = [];
                foreach ($country->get_cities() as $city) {
                    array_push($cities, $city->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all cities", $cities));
            } else if ($request->isPost()) {
                $city = SuperEightFestivalsCity::create([
                    "country_id" => $country->id,
                    "location" => [
                        "name" => $request->getParam('name', ""),
                        "description" => $request->getParam('description', ""),
                        "latitude" => $request->getParam('latitude', 0),
                        "longitude" => $request->getParam('longitude', 0),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created city", $city->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched city", $city->to_array()));
            } else if ($request->isPost()) {
                $city->update([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "description" => $request->getParam('description', ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated city", $city->to_array()));
            } else if ($request->isDelete()) {
                $arr = $city->to_array();
                $city->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted city", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $festivals = [];
                foreach ($city->get_festivals() as $festival) {
                    array_push($festivals, $festival->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all cities", $festivals));
            } else if ($request->isPost()) {
                $festival = SuperEightFestivalsFestival::create([
                    "city_id" => $city->id,
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            if ($festival->city_id !== $city->id) {
                throw new Exception("There is no festival within city of ID " . $city->id . " with ID: " . $festival->id);
            }

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched festival", $festival->to_array()));
            } else if ($request->isPost()) {
                $festival->update([
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated festival", $festival->to_array()));
            } else if ($request->isDelete()) {
                $arr = $festival->to_array();
                $festival->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted festival", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $films = [];
                foreach ($festival->get_films() as $film) {
                    array_push($films, $film->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival films", $films));
            } else if ($request->isPost()) {
                $film = SuperEightFestivalsFestivalFilm::create([
                    "festival_id" => $festival->id,
                    "filmmaker_film_id" => $request->getParam("filmmaker_film_id", ""),
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival film", $film->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $film = get_request_param_by_id($request, SuperEightFestivalsFestivalFilm::class, "film");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched festival film", $film->to_array()));
            } else if ($request->isPost()) {
                $film->update([
                    "festival_id" => $festival->id,
                    "filmmaker_film_id" => $request->getParam("filmmaker_film_id", ""),
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated festival film", $film->to_array()));
            } else if ($request->isDelete()) {
                $arr = $film->to_array();
                $film->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted festival film", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmCatalogsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $film_catalogs = [];
                foreach ($festival->get_film_catalogs() as $film) {
                    array_push($film_catalogs, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival film catalogs", $film_catalogs));
            } else if ($request->isPost()) {
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $film_catalog = new SuperEightFestivalsFestivalFilmCatalog();
                try {
                    $film_catalog->upload_file("file");
                    $film_catalog->update([
                        "festival_id" => $festival->id,
                        "file" => [
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival film catalog", $film_catalog->to_array()));
                } catch (Exception $e) {
                    if ($film_catalog->id !== 0) $film_catalog->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmCatalogAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $film_catalog = get_request_param_by_id($request, SuperEightFestivalsFestivalFilmCatalog::class, "filmCatalogID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker photo", $film_catalog->to_array()));
            } else if ($request->isPost()) {
                if (has_temporary_file("file")) {
                    if ($file = $film_catalog->get_file()) $file->delete();
                    $film_catalog->upload_file("file");
                }
                $film_catalog->update([
                    "festival_id" => $festival->id,
                    "file" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker photo", $film_catalog->to_array()));
            } else if ($request->isDelete()) {
                $arr = $film_catalog->to_array();
                $film_catalog->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted filmmaker photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\
}
