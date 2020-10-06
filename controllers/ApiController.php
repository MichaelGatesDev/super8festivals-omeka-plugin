<?php

class SuperEightFestivals_ApiController extends Omeka_Controller_AbstractActionController
{
    // ======================================================================================================================== \\

    public function indexAction()
    {
    }

    private function getJsonResponse($status, $message, $data = null)
    {
        return array(
            "status" => $status,
            "message" => $message,
            "data" => $data,
        );
    }

    // ======================================================================================================================== \\

    public function allUsersAction()
    {
        try {
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all users", get_all_users()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function allCountriesAction()
    {
        try {
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all countries", SuperEightFestivalsCountry::get_all()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleCountryAction()
    {
        $user = current_user();
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", $country));
            } else {
                if ($user->role !== "super") {
                    $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
                    return;
                }

                if ($request->isPost()) {
                    $raw_json = file_get_contents('php://input');
                    $json = json_decode($raw_json, TRUE);

                    $country->name = $json['name'];
                    $country->latitude = $json['latitude'];
                    $country->longitude = $json['longitude'];
                    $country->save();

                    $this->_helper->json($this->getJsonResponse("success", "Successfully updated country", $country));
                } else if ($request->isDelete()) {
                    $country->delete();
                    $this->_helper->json($this->getJsonResponse("success", "Successfully deleted country", $country));
                }
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function addCountryAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
            return;
        }

        try {
            $request = $this->getRequest();

            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }

            $raw_json = file_get_contents('php://input');
            $json = json_decode($raw_json, TRUE);

            $country = new SuperEightFestivalsCountry();
            $country->name = $json['name'];
            $country->latitude = $json['latitude'];
            $country->longitude = $json['longitude'];
            $country->save();

            $this->_helper->json($this->getJsonResponse("success", "Successfully created country", $country));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function allCitiesAction()
    {
        try {
            $cities = SuperEightFestivalsCity::get_all();
            foreach ($cities as $city) {
                $city['country'] = $city->get_country();
            }
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities", $cities));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleCityAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched city", $city));
            } else {
                $user = current_user();
                if ($user->role !== "super") {
                    $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
                    return;
                }

                if ($request->isPost()) {

                    $raw_json = file_get_contents('php://input');
                    $json = json_decode($raw_json, TRUE);

                    $city->name = $json['name'];
                    $city->latitude = $json['latitude'];
                    $city->longitude = $json['longitude'];
                    $city->description = $json['description'];
                    $city->save();

                    $this->_helper->json($this->getJsonResponse("success", "Successfully updated city", $city));
                } else if ($request->isDelete()) {
                    $city->delete();
                    $this->_helper->json($this->getJsonResponse("success", "Successfully deleted city", $city));
                }
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function countryAllCitiesAction()
    {
        try {
            $request = $this->getRequest();
            $country = get_request_param_country($request);
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities for country", $country->get_cities()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function countrySingleCityAction()
    {
        $request = $this->getRequest();
        $city = get_request_param_city($request);
        $this->redirect("/rest-api/cities/" . $city->id . "/");
    }

    public function countryAddCityAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
            return;
        }

        try {
            $request = $this->getRequest();
            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }
            $country = get_request_param_country($request);

            $raw_json = file_get_contents('php://input');
            $json = json_decode($raw_json, TRUE);

            $city = new SuperEightFestivalsCity();
            $city->country_id = $country->id;
            $city->name = $json['name'];
            $city->latitude = $json['latitude'];
            $city->longitude = $json['longitude'];
            $city->description = $json['description'];
            $city->save();

            $this->_helper->json($this->getJsonResponse("success", "Successfully created city", $city));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function allFestivalsAction()
    {
        try {
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals for city", SuperEightFestivalsFestival::get_all()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleFestivalAction()
    {
        try {
            $request = $this->getRequest();
            $festival = get_request_param_festival($request);

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched festival", $festival));
            } else {
                $user = current_user();
                if ($user->role !== "super") {
                    $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
                    return;
                }

                $raw_json = file_get_contents('php://input');
                $json = json_decode($raw_json, TRUE);

                if ($request->isPost()) {
                    $festival_year = $json["year"];

                    $festival->year = $festival_year;
                    $festival->save();

                    $this->_helper->json($this->getJsonResponse("success", "Successfully updated festival", $festival));
                } else if ($request->isDelete()) {
                    $festival->delete();
                    $this->_helper->json($this->getJsonResponse("success", "Successfully deleted festival", $festival));
                }
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function cityAllFestivalsAction()
    {
        try {
            $request = $this->getRequest();
            $city = get_request_param_city($request);
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals for city", $city->get_festivals()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function citySingleFestivalAction()
    {
        $request = $this->getRequest();
        $festival = get_request_param_festival($request);
        $this->redirect("/rest-api/festivals/" . $festival->id . "/");
    }

    public function cityAddFestivalAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "You must be signed in to do this."));
            return;
        }

        try {
            $request = $this->getRequest();
            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }
            $city = get_request_param_city($request);

            $raw_json = file_get_contents('php://input');
            $json = json_decode($raw_json, TRUE);

            $festival = new SuperEightFestivalsFestival();
            $festival->city_id = $city->id;
            $festival->year = $json['year'];
            $festival->save();

            $this->_helper->json($this->getJsonResponse("success", "Successfully created festival", $festival));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\


}
