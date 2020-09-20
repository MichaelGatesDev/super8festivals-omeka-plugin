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
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", $country));
            } else if ($request->isPost()) {

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
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function addCountryAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "Must be signed in to use Rest API"));
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
            $request = $this->getRequest();

            $cities = SuperEightFestivalsCity::get_all();
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities", $cities));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function countryCitiesAction()
    {
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $cities = SuperEightFestivalsCity::get_by_param('country_id', $country->id);
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all cities for country", $cities));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleCityAction()
    {
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $city_param = $request->getParam('city');
            $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCountry::get_by_params(array('country_id' => $country->id, 'name' => $city_param, 1))[0];
            if (!$city || $city->country_id != $country->id) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a city with that ID/Name: " . $city_param));
                return;
            }

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched city", $city));
            } else if ($request->isPost()) {

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
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function addCityAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "Must be signed in to use Rest API"));
            return;
        }

        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }

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
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $city_param = $request->getParam('city');
            $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCountry::get_by_params(array('country_id' => $country->id, 'name' => $city_param, 1))[0];
            if (!$city) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a city with that ID/Name: " . $city_param));
                return;
            }

            $festivals = SuperEightFestivalsFestival::get_by_param('city_id', $city->id);
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all festivals for city", $festivals));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleFestivalAction()
    {
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $city_param = $request->getParam('city');
            $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCountry::get_by_params(array('country_id' => $country->id, 'name' => $city_param, 1))[0];
            if (!$city) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a city with that ID/Name: " . $city_param));
                return;
            }

            $festival_param = $request->getParam('festival');
            $festival = SuperEightFestivalsFestival::get_by_id($festival_param);
            if (!$festival) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a festival with that ID: " . $festival_param));
                return;
            }

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched festival", $festival));
            } else if ($request->isPost()) {
                $festival_year = $_POST["festival-year"];
                $festival_title = $_POST["festival-title"];
                $festival_description = $_POST["festival-description"];

                $festival->year = $festival_year;
                $festival->title = $festival_title;
                $festival->description = $festival_description;
                $festival->save();

                $this->_helper->json($this->getJsonResponse("success", "Successfully updated festival", $festival));
            } else if ($request->isDelete()) {
                $festival->delete();
                $this->_helper->json($this->getJsonResponse("success", "Successfully deleted festival", $festival));
            }
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function addFestivalAction()
    {
        $user = current_user();
        if ($user->role !== "super") {
            $this->_helper->json($this->getJsonResponse("error", "Must be signed in to use Rest API"));
            return;
        }

        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $city_param = $request->getParam('city');
            $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCountry::get_by_params(array('country_id' => $country->id, 'name' => $city_param, 1))[0];
            if (!$city) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a city with that ID/Name: " . $city_param));
                return;
            }

            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }

            $festival_year = $_POST["festival-year"];
            $festival_title = $_POST["festival-title"];
            $festival_description = $_POST["festival-description"];

            $festival = new SuperEightFestivalsFestival();
            $festival->city_id = $city->id;
            $festival->year = $festival_year;
            $festival->title = $festival_title;
            $festival->description = $festival_description;
            $festival->save();

            $this->_helper->json($this->getJsonResponse("success", "Successfully created festival", $festival));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\


}
