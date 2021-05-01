<?php

class SuperEightFestivals_ApiController extends Omeka_Controller_AbstractActionController
{
    // ======================================================================================================================== \\

    public function indexAction()
    {
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $users = [];
                foreach (get_all_users() as $user) {
                    array_push($users, filter_array($user, ["password", "salt"]));
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all users", $users));
            } else if ($request->isPost()) {
                $this->authCheck();
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function singleUserAction()
    {
        try {
            $request = $this->getRequest();
            $user_id = $request->getParam("user");
            $user = get_db()->getTable("User")->find($user_id);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched country", filter_array($user, ["password", "salt"])));
            } else if ($request->isPost()) {
                $this->authCheck();
            } else if ($request->isDelete()) {
                $this->authCheck();
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function migrationsAction()
    {
        try {
            $request = $this->getRequest();
            $migration_name = $request->getParam("migration-name");
            $migration_direction = $request->getParam("migration-direction");

            $migration_script_file_path = __DIR__ . "/../migrations/" . "$migration_name";
            if (!file_exists($migration_script_file_path)) {
                throw new Exception("Migration file does not exist: {$migration_script_file_path}");
            }

            include_once $migration_script_file_path;

            $class = str_replace(".php", "", $migration_name);
            if (!class_exists($class)) {
                throw new Exception("No class with name $class exists in file: $migration_script_file_path");
            }

            $reflect = new ReflectionClass($class);
            if ($reflect->isAbstract() || !$reflect->isSubclassOf(S8FDatabaseMigration::class)) {
                throw new Exception("Class is either abstract or is not subclass of S8FDatabaseMigration");
            }

            $instance = new $class;
            if ($migration_direction == "forward") {
                $instance->apply();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Applied migration $migration_name"));
            } else if ($migration_direction == "backward") {
                $instance->undo();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Reversed migration $migration_name"));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function federationNewslettersAction()
    {
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $newsletters = [];
                foreach (SuperEightFestivalsFederationNewsletter::get_all() as $newsletter) {
                    array_push($newsletters, $newsletter->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation newsletters", $newsletters));
            } else if ($request->isPost()) {
                $this->authCheck();

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $newsletter = new SuperEightFestivalsFederationNewsletter();
                try {
                    $newsletter->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $newsletter->update([
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $newsletter = get_request_param_by_id($request, SuperEightFestivalsFederationNewsletter::class, "newsletterID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation newsletter", $newsletter->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $newsletter->get_file()) $file->delete();
                    $newsletter->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $newsletter->update([
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation newsletter", $newsletter->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $photos = [];
                foreach (SuperEightFestivalsFederationPhoto::get_all() as $photo) {
                    array_push($photos, $photo->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation photos", $photos));
            } else if ($request->isPost()) {
                $this->authCheck();

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsFederationPhoto();
                try {
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                    $photo->update([
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $photo = get_request_param_by_id($request, SuperEightFestivalsFederationPhoto::class, "photoID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation photo", $photo->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                }
                $photo->update([
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $bylaws = [];
                foreach (SuperEightFestivalsFederationBylaw::get_all() as $bylaw) {
                    array_push($bylaws, $bylaw->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation by-laws", $bylaws));
            } else if ($request->isPost()) {
                $this->authCheck();

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $bylaw = new SuperEightFestivalsFederationBylaw();
                try {
                    $bylaw->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $bylaw->update([
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $bylaw = get_request_param_by_id($request, SuperEightFestivalsFederationBylaw::class, "bylawID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation by-law", $bylaw->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $bylaw->get_file()) $file->delete();
                    $bylaw->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $bylaw->update([
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation by-law", $bylaw->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $magazines = [];
                foreach (SuperEightFestivalsFederationMagazine::get_all() as $magazine) {
                    array_push($magazines, $magazine->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all federation magazines", $magazines));
            } else if ($request->isPost()) {
                $this->authCheck();

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $magazine = new SuperEightFestivalsFederationMagazine();
                try {
                    $magazine->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $magazine->update([
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $magazine = get_request_param_by_id($request, SuperEightFestivalsFederationMagazine::class, "magazineID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched federation magazine", $magazine->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $magazine->get_file()) $file->delete();
                    $magazine->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $magazine->update([
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated federation magazine", $magazine->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $contributors = [];
                foreach (SuperEightFestivalsContributor::get_all() as $contributor) {
                    array_push($contributors, $contributor->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all contributors", $contributors));
            } else if ($request->isPost()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();
            $contributor = get_request_param_by_id($request, SuperEightFestivalsContributor::class, "contributor");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched contributor", $contributor->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
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
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $staffs = [];
                foreach (SuperEightFestivalsStaff::get_all() as $staff) {
                    array_push($staffs, $staff->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all staff", $staffs));
            } else if ($request->isPost()) {
                $this->authCheck();

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
                    $staff->upload_file("file", array_merge(supported_image_mimes));
                    $staff->save();
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created staff", $staff->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function staffAction()
    {
        try {
            $request = $this->getRequest();
            $staff = get_request_param_by_id($request, SuperEightFestivalsStaff::class, "staff");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched staff", $staff->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();

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
                    $staff->upload_file("file", array_merge(supported_image_mimes));
                    $staff->save();
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated staff", $staff->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $filmmakers = [];
                foreach (SuperEightFestivalsFilmmaker::get_all() as $filmmaker) {
                    array_push($filmmakers, $filmmaker->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all filmmakers", $filmmakers));
            } else if ($request->isPost()) {
                $this->authCheck();
                $filmmaker = SuperEightFestivalsFilmmaker::create([
                    "bio" => $request->getParam("bio", ""),
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
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker", $filmmaker->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                $filmmaker->update([
                    "bio" => $request->getParam("bio", ""),
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
                $this->authCheck();
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
                $this->authCheck();

                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsFilmmakerPhoto();
                try {
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                    $photo->update([
                        "filmmaker_id" => $filmmaker->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");
            $photo = get_request_param_by_id($request, SuperEightFestivalsFilmmakerPhoto::class, "photo");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker photo", $photo->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                }
                $photo->update([
                    "filmmaker_id" => $filmmaker->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
                $this->authCheck();
                $film = SuperEightFestivalsFilmmakerFilm::create([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");
            $film = get_request_param_by_id($request, SuperEightFestivalsFilmmakerFilm::class, "film");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched filmmaker film", $film->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                $film->update([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                        "embed" => $request->getParam("embed", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated filmmaker film", $film->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();

            if ($request->isGet()) {
                $countries = [];
                foreach (SuperEightFestivalsCountry::get_all() as $country) {
                    array_push($countries, $country->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all countries", $countries));
            } else if ($request->isPost()) {
                $this->authCheck();
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
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched country", $country->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                $country->update([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated country", $country->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
                $this->authCheck();
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
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched city", $city->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
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
                $this->authCheck();
                $arr = $city->to_array();
                $city->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted city", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityBannerAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $banner = $city->get_banner();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched banner", $banner ? $banner->to_array() : null));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $banner = new SuperEightFestivalsCityBanner();
                try {
                    $banner->upload_file("file", array_merge(supported_image_mimes));
                    $banner->update([
                        "city_id" => $city->id,
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created banner", $banner->to_array()));
                } catch (Exception $e) {
                    if ($banner->id !== 0) $banner->delete();
                    throw $e;
                }
            } else if ($request->isDelete()) {
                $this->authCheck();
                $banner = $city->get_banner();
                $arr = $banner->to_array();
                $banner->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted banner", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalsAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $festivals = [];
                foreach ($city->get_festivals() as $festival) {
                    array_push($festivals, $festival->to_array());
                }
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festivals", $festivals));
            } else if ($request->isPost()) {
                $this->authCheck();
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
                $this->authCheck();
                $festival->update([
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated festival", $festival->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                if ($festival->year === 0) {
                    throw new Exception("The default festival can not be deleted!");
                }
                $arr = $festival->to_array();
                $festival->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted festival", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPostersAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $posters = [];
                foreach ($festival->get_posters() as $film) {
                    array_push($posters, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival posters", $posters));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $poster = new SuperEightFestivalsFestivalPoster();
                try {
                    $poster->upload_file("file", array_merge(supported_image_mimes));
                    $poster->update([
                        "festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival poster", $poster->to_array()));
                } catch (Exception $e) {
                    if ($poster->id !== 0) $poster->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPosterAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $poster = get_request_param_by_id($request, SuperEightFestivalsFestivalPoster::class, "posterID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched poster", $poster->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $poster->get_file()) $file->delete();
                    $poster->upload_file("file", array_merge(supported_image_mimes));
                }
                $poster->update([
                    "festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated poster", $poster->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $poster->to_array();
                $poster->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted poster", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPhotosAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $photos = [];
                foreach ($festival->get_photos() as $film) {
                    array_push($photos, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival photos", $photos));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsFestivalPhoto();
                try {
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                    $photo->update([
                        "festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival photo", $photo->to_array()));
                } catch (Exception $e) {
                    if ($photo->id !== 0) $photo->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPhotoAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $photo = get_request_param_by_id($request, SuperEightFestivalsFestivalPhoto::class, "photoID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched photo", $photo->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                }
                $photo->update([
                    "festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $photo->to_array();
                $photo->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPrintMediaAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $print_media = [];
                foreach ($festival->get_print_media() as $film) {
                    array_push($print_media, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival print media", $print_media));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $print_medium = new SuperEightFestivalsFestivalPrintMedia();
                try {
                    $print_medium->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $print_medium->update([
                        "festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival print medium", $print_medium->to_array()));
                } catch (Exception $e) {
                    if ($print_medium->id !== 0) $print_medium->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalPrintMediumAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $print_medium = get_request_param_by_id($request, SuperEightFestivalsFestivalPrintMedia::class, "printMediaID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched print medium", $print_medium->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $print_medium->get_file()) $file->delete();
                    $print_medium->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $print_medium->update([
                    "festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated print medium", $print_medium->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $print_medium->to_array();
                $print_medium->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted print medium", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmsAction()
    {
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
                $this->authCheck();

                $filmmaker_film_id = (int) $request->getParam("filmmaker_film_id");
                if ($filmmaker_film_id == 0) {
                    throw new Error("You must select a film!");
                }

                $film = SuperEightFestivalsFestivalFilm::create([
                    "festival_id" => $festival->id,
                    "filmmaker_film_id" => $filmmaker_film_id,
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival film", $film->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalFilmAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $film = get_request_param_by_id($request, SuperEightFestivalsFestivalFilm::class, "filmID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched festival film", $film->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();

                $filmmaker_film_id = (int) $request->getParam("filmmaker_film_id");
                if ($filmmaker_film_id == 0) {
                    throw new Error("You must select a film!");
                }

                $film->update([
                    "festival_id" => $festival->id,
                    "filmmaker_film_id" => $filmmaker_film_id,
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated festival film", $film->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
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
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $film_catalog = new SuperEightFestivalsFestivalFilmCatalog();
                try {
                    $film_catalog->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $film_catalog->update([
                        "festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
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
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
            $film_catalog = get_request_param_by_id($request, SuperEightFestivalsFestivalFilmCatalog::class, "filmCatalogID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched film catalog", $film_catalog->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $film_catalog->get_file()) $file->delete();
                    $film_catalog->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $film_catalog->update([
                    "festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated film catalog", $film_catalog->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $film_catalog->to_array();
                $film_catalog->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted film catalog", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalsAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $festivals = [];
                foreach ($city->get_nearby_festivals() as $festival) {
                    array_push($festivals, $festival->to_array());
                }
                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully fetched all nearby festivals",
                        $festivals
                    )
                );
            } else if ($request->isPost()) {
                $this->authCheck();
                $festival = SuperEightFestivalsNearbyFestival::create([
                    "city_id" => $city->id,
                    "city_name" => $request->getParam("name", ""),
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully created nearby festival",
                        $festival->to_array()
                    )
                );
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson(
                $this->getJsonResponseArray(
                    "error",
                    $e->getMessage()
                )
            );
        }
    }

    public function countryCityNearbyFestivalAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);
            $festival = get_request_param_by_id($request, SuperEightFestivalsNearbyFestival::class, "festival");
            if ($festival->city_id !== $city->id) {
                throw new Exception("There is no nearby festival within city of ID {$city->id} with ID: {$festival->id}");
            }

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully fetched nearby festival",
                        $festival->to_array()
                    )
                );
            } else if ($request->isPost()) {
                $this->authCheck();
                $festival->update([
                    "year" => $request->getParam("year", 0),
                    "city_name" => $request->getParam("name", ""),
                ]);

                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully updated nearby festival",
                        $festival->to_array()
                    )
                );
            } else if ($request->isDelete()) {
                $this->authCheck();
                if ($festival->year === 0) {
                    throw new Exception("The default nearby festival can not be deleted!");
                }
                $arr = $festival->to_array();
                $festival->delete();
                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully deleted nearby festival",
                        $arr
                    )
                );
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalPhotosAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsNearbyFestival::class, "festival");

            if ($request->isGet()) {
                $photos = [];
                foreach ($festival->get_photos() as $film) {
                    array_push($photos, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival photos", $photos));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $photo = new SuperEightFestivalsNearbyFestivalPhoto();
                try {
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                    $photo->update([
                        "nearby_festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival photo", $photo->to_array()));
                } catch (Exception $e) {
                    if ($photo->id !== 0) $photo->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalPhotoAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsNearbyFestival::class, "festival");
            $photo = get_request_param_by_id($request, SuperEightFestivalsNearbyFestivalPhoto::class, "photoID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched photo", $photo->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $photo->get_file()) $file->delete();
                    $photo->upload_file("file", array_merge(supported_image_mimes));
                }
                $photo->update([
                    "nearby_festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $photo->to_array();
                $photo->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalPrintMediaAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsNearbyFestival::class, "festival");

            if ($request->isGet()) {
                $print_media = [];
                foreach ($festival->get_print_media() as $film) {
                    array_push($print_media, $film->to_array());
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all festival print media", $print_media));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (!has_temporary_file("file")) {
                    throw new Error("There was no file selected for upload.");
                }

                $print_medium = new SuperEightFestivalsNearbyFestivalPrintMedia();
                try {
                    $print_medium->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                    $print_medium->update([
                        "nearby_festival_id" => $festival->id,
                        "file" => [
                            "contributor_id" => $request->getParam("contributor_id"),
                            "title" => $request->getParam("title", ""),
                            "description" => $request->getParam("description", ""),
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created festival print medium", $print_medium->to_array()));
                } catch (Exception $e) {
                    if ($print_medium->id !== 0) $print_medium->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalPrintMediumAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsNearbyFestival::class, "festival");
            $print_medium = get_request_param_by_id($request, SuperEightFestivalsNearbyFestivalPrintMedia::class, "printMediaID");

            if ($request->isGet()) {
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched print medium", $print_medium->to_array()));
            } else if ($request->isPost()) {
                $this->authCheck();
                if (has_temporary_file("file")) {
                    if ($file = $print_medium->get_file()) $file->delete();
                    $print_medium->upload_file("file", array_merge(supported_image_mimes, supported_document_mimes));
                }
                $print_medium->update([
                    "nearby_festival_id" => $festival->id,
                    "file" => [
                        "contributor_id" => $request->getParam("contributor_id"),
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                    ],
                ]);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully updated print medium", $print_medium->to_array()));
            } else if ($request->isDelete()) {
                $this->authCheck();
                $arr = $print_medium->to_array();
                $print_medium->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted print medium", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function countryCityPostersAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $posters = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_posters() as $poster) {
                        array_push($posters, $poster->to_array());
                    }
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city posters", $posters));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityPhotosAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $photos = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_photos() as $photo) {
                        array_push($photos, $photo->to_array());
                    }
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city photos", $photos));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityPrintMediaAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $print_medias = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_print_media() as $print_media) {
                        array_push($print_medias, $print_media->to_array());
                    }
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city print media", $print_medias));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFilmsAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $films = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_films() as $film) {
                        array_push($films, $film->to_array());
                    }
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city films", $films));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFilmmakersAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $filmmakers = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_filmmakers() as $filmmaker) {
                        array_push($filmmakers, $filmmaker->to_array());
                    }
                }
                $filmmakers = array_unique($filmmakers, SORT_REGULAR);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city filmmakers", $filmmakers));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityFilmCatalogsAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $film_catalogs = [];
                foreach ($city->get_festivals() as $festival) {
                    foreach ($festival->get_film_catalogs() as $film_catalog) {
                        array_push($film_catalogs, $film_catalog->to_array());
                    }
                }

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all city film catalogs", $film_catalogs));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityNearbyFestivalsPhotosAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $photos = [];
                foreach ($city->get_nearby_festivals() as $festival) {
                    foreach ($festival->get_photos() as $photo) {
                        array_push($photos, $photo->to_array());
                    }
                }
                $photos = array_unique($photos, SORT_REGULAR);

                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully fetched all nearby festival festival photos", $photos));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    public function countryCityTimelineAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $timeline = $city->get_timeline();
                $this->_helper->getHelper("json")->sendJson(
                    $this->getJsonResponseArray(
                        "success",
                        "Successfully fetched timeline",
                        $timeline == null ? null : $timeline->to_array(),
                    )
                );
            } else if ($request->isPost()) {
                $this->authCheck();

                try {
                    $timeline = SuperEightFestivalsCityTimeline::create([
                        "city_id" => $city->id,
                        "timeline" => [
                            "embed" => [
                                "embed" => $request->getParam("embed", ""),
                            ],
                        ],
                    ]);
                    $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully created timeline", $timeline->to_array()));
                } catch (Exception $e) {
                    if ($timeline->id !== 0) $timeline->delete();
                    throw $e;
                }
            } else if ($request->isDelete()) {
                $this->authCheck();
                $timeline = $city->get_timeline();
                $arr = $timeline->to_array();
                $timeline->delete();
                $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("success", "Successfully deleted timeline", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->getHelper("json")->sendJson($this->getJsonResponseArray("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

}
