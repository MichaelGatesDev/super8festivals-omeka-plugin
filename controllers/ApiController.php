<?php

class SuperEightFestivals_ApiController extends Omeka_Controller_AbstractActionController
{
    // ======================================================================================================================== \\

    public function indexAction()
    {
        $this->authCheck();
    }

    private function getJsonResponse($status, $message, $data = null)
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
            $this->_helper->json($this->getJsonResponse("error", "You must be signed in to access the S8F REST API."));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all users", $users));
            } else if ($request->isPost()) {
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", filter_array($user, ["password", "salt"])));
            } else if ($request->isPost()) {
            } else if ($request->isDelete()) {
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all contributors", $contributors));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully created contributor", $contributor->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function contributorAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $contributor = get_request_param_by_id($request, SuperEightFestivalsContributor::class, "contributor");

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched contributor", $contributor->to_array()));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated contributor", $contributor->to_array()));
            } else if ($request->isDelete()) {
                $arr = $contributor->to_array();
                $contributor->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted contributor", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all staff", $staffs));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully created staff", $staff->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function staffAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $staff = get_request_param_by_id($request, SuperEightFestivalsStaff::class, "staff");

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched staff", $staff->to_array()));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated staff", $staff->to_array()));
            } else if ($request->isDelete()) {
                $arr = $staff->to_array();
                $staff->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted staff", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all filmmakers", $filmmakers));
            } else if ($request->isPost()) {
                $filmmaker = SuperEightFestivalsFilmmaker::create([
                    "person" => [
                        "first_name" => $request->getParam("first-name", ""),
                        "last_name" => $request->getParam("last-name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization-name", ""),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully created filmmaker", $filmmaker->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function filmmakerAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmaker");

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched filmmaker", $filmmaker->to_array()));
            } else if ($request->isPost()) {
                $filmmaker->update([
                    "person_id" => $request->getParam("person-id", ""),
                    "person" => [
                        "first_name" => $request->getParam("first-name", ""),
                        "last_name" => $request->getParam("last-name", ""),
                        "email" => $request->getParam("email", ""),
                        "organization_name" => $request->getParam("organization-name", ""),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated filmmaker", $filmmaker->to_array()));
            } else if ($request->isDelete()) {
                $arr = $filmmaker->to_array();
                $filmmaker->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted filmmaker", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all filmmaker photos", $photos));
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
                    $this->_helper->json($this->getJsonResponse("success", "Successfully created filmmaker photo", $photo->to_array()));
                } catch (Exception $e) {
                    if ($photo->id !== 0) $photo->delete();
                    throw $e;
                }
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched filmmaker photo", $photo->to_array()));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated filmmaker photo", $photo->to_array()));
            } else if ($request->isDelete()) {
                $arr = $photo->to_array();
                $photo->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted filmmaker photo", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all filmmaker films", $films));
            } else if ($request->isPost()) {
                $film = SuperEightFestivalsFilmmakerFilm::create([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                        "embed" => $request->getParam("embed", ""),
                    ],
                ]);
                $this->_helper->json($this->getJsonResponse("success", "Successfully created filmmaker film", $film->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched filmmaker film", $film->to_array()));
            } else if ($request->isPost()) {
                $film->update([
                    "filmmaker_id" => $filmmaker->id,
                    "embed" => [
                        "title" => $request->getParam("title", ""),
                        "description" => $request->getParam("description", ""),
                        "embed" => $request->getParam("embed", ""),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated filmmaker film", $film->to_array()));
            } else if ($request->isDelete()) {
                $arr = $film->to_array();
                $film->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted filmmaker film", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities", $cities));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function cityAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched city", $city->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals", $cities));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function festivalAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all countries", $countries));
            } else if ($request->isPost()) {
                $country = SuperEightFestivalsCountry::create([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully created country", $country->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function countryAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $country = get_request_param_by_id($request, SuperEightFestivalsCountry::class, "country");

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", $country->to_array()));
            } else if ($request->isPost()) {
                $country->update([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated country", $country->to_array()));
            } else if ($request->isDelete()) {
                $arr = $country->to_array();
                $country->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted country", $arr));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities", $cities));
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

                $this->_helper->json($this->getJsonResponse("success", "Successfully created city", $city->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched city", $city->to_array()));
            } else if ($request->isPost()) {
                $city->update([
                    "location" => [
                        "name" => $request->getParam("name", ""),
                        "description" => $request->getParam('description', ""),
                        "latitude" => $request->getParam("latitude", 0),
                        "longitude" => $request->getParam("longitude", 0),
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated city", $city->to_array()));
            } else if ($request->isDelete()) {
                $city->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted city", $city->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities", $festivals));
            } else if ($request->isPost()) {
                $festival = SuperEightFestivalsFestival::create([
                    "city_id" => $city->id,
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
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

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched festival", $festival->to_array()));
            } else if ($request->isPost()) {
                $festival->update([
                    "year" => $request->getParam("year", 0),
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated festival", $festival->to_array()));
            } else if ($request->isDelete()) {
                $festival->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\
}
