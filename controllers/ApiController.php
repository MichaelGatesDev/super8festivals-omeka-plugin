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
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $filmmaker = SuperEightFestivalsFilmmaker::create([
                    "person" => [
                        "first_name" => $json['first_name'],
                        "last_name" => $json['last_name'],
                        "email" => $json['email'],
                        "organization_name" => $json['organization_name'],
                    ],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully created country", $filmmaker->to_array()));
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
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $filmmaker->get_person()->update([
                    "first_name" => $json['first_name'],
                    "last_name" => $json['last_name'],
                    "email" => $json['email'],
                    "organization_name" => $json['organization_name'],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated filmmaker", $filmmaker->to_array()));
            } else if ($request->isDelete()) {
                $filmmaker->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted filmmaker", $filmmaker->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

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
            } else if ($request->isPost()) {
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $city->get_location()->update([
                    "name" => $json['name'],
                    "description" => $json['description'],
                    "latitude" => $json['latitude'],
                    "longitude" => $json['longitude'],
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

    public function cityFestivalsAction()
    {
        $this->authCheck();
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            $festivals = [];
            foreach (SuperEightFestivalsFestival::get_by_param('city_id', $city->id) as $festival) {
                array_push($festivals, $festival->to_array());
            }
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals", $festivals));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function cityFestivalAction()
    {
        $this->authCheck();
        $request = $this->getRequest();
        $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
        $this->redirect("/rest-api/festivals/{$festival->id}");
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
            } else if ($request->isPost()) {
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $festival->update([
                    "year" => $json['year'],
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
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $country = SuperEightFestivalsCountry::create([
                    "location" => [
                        "name" => $json['name'],
                        "latitude" => $json['latitude'],
                        "longitude" => $json['longitude'],
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
            $country = get_request_param_country($request);

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", $country->to_array()));
            } else if ($request->isPost()) {
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $country->get_location()->update([
                    "name" => $json['name'],
                    "description" => $json['description'],
                    "latitude" => $json['latitude'],
                    "longitude" => $json['longitude'],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated country", $country->to_array()));
            } else if ($request->isDelete()) {
                $country->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted country", $country->to_array()));
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
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $city = SuperEightFestivalsCity::create([
                    "country_id" => $country->id,
                    "location" => [
                        "name" => $json['name'],
                        "description" => $json['description'],
                        "latitude" => $json['latitude'],
                        "longitude" => $json['longitude'],
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
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $city->get_location()->update([
                    "name" => $json['name'],
                    "description" => $json['description'],
                    "latitude" => $json['latitude'],
                    "longitude" => $json['longitude'],
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
                foreach (SuperEightFestivalsFestival::get_by_param('city_id', $city->id) as $festival) {
                    array_push($festivals, $festival->to_array());
                }
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals", $festivals));
            } else if ($request->isPost()) {
                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                $festival = SuperEightFestivalsFestival::create([
                    "city_id" => $city->id,
                    "year" => $json['year'],
                ]);

                $this->_helper->json($this->getJsonResponse("success", "Successfully created festival", $festival->to_array()));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function countryCityFestivalAction()
    {
        $this->authCheck();
        $request = $this->getRequest();
        $festival = get_request_param_by_id($request, SuperEightFestivalsFestival::class, "festival");
        $this->redirect("/rest-api/festivals/{$festival->id}");
    }

    // ======================================================================================================================== \\
}
