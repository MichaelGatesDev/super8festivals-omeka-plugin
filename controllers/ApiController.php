<?php

class SuperEightFestivals_ApiController extends Omeka_Controller_AbstractActionController
{
    // ======================================================================================================================== \\

    /**
     * Initialize this controller.
     */
    public function init()
    {
        // Actions should use the jsonApi action helper to render JSON data.
        $this->_helper->viewRenderer->setNoRender();
    }

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
            $this->_helper->json($this->getJsonResponse("success", "Successfully fetched all countries", get_all_countries()));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    public function singleCountryAction()
    {
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? get_country_by_id($country_param) : get_country_by_name($country_param);
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched country", $country));
            } else if ($request->isPost()) {
                $country_name = $_POST["country-name"];
                $country_latitude = $_POST["country-latitude"];
                $country_longitude = $_POST["country-longitude"];

                $country->name = $country_name;
                $country->latitude = $country_latitude;
                $country->longitude = $country_longitude;
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
        try {
            $request = $this->getRequest();

            $user = current_user();
            if ($user->role !== "super") {
                $this->_helper->json($this->getJsonResponse("error", "Must be signed in to use Rest API"));
                return;
            }

            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }

            $country_name = $_POST["country-name"];
            $country_latitude = $_POST["country-latitude"];
            $country_longitude = $_POST["country-longitude"];

            $added_country = add_country($country_name, $country_latitude, $country_longitude);
            $this->_helper->json($this->getJsonResponse("success", "Successfully created country", $added_country));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\

    public function allCitiesAction()
    {
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? get_country_by_id($country_param) : get_country_by_name($country_param);
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $cities = get_all_cities_in_country($country->id);
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
            $country = is_numeric($country_param) ? get_country_by_id($country_param) : get_country_by_name($country_param);
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $city_param = $request->getParam('city');
            $city = is_numeric($city_param) ? get_city_by_id($city_param) : get_city_by_name($country->id, $city_param);
            if (!$city || $city->country_id != $country->id) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a city with that ID/Name: " . $city_param));
                return;
            }

            if ($request->isGet()) {
                $this->_helper->json($this->getJsonResponse("success", "Successfully fetched city", $city));
            } else if ($request->isPost()) {
                $city_name = $_POST["city-name"];
                $city_latitude = $_POST["city-latitude"];
                $city_longitude = $_POST["city-longitude"];
                $city_description = $_POST["city-description"];

                $city->name = $city_name;
                $city->latitude = $city_latitude;
                $city->longitude = $city_longitude;
                $city->description = $city_description;
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
        try {
            $request = $this->getRequest();

            $country_param = $request->getParam('country');
            $country = is_numeric($country_param) ? get_country_by_id($country_param) : get_country_by_name($country_param);
            if (!$country) {
                $this->_helper->json($this->getJsonResponse("error", "Failed to find a country with that ID/Name: " . $country_param));
                return;
            }

            $user = current_user();
            if ($user->role !== "super") {
                $this->_helper->json($this->getJsonResponse("error", "Must be signed in to use Rest API"));
                return;
            }

            if (!$request->isPost()) {
                $this->_helper->json($this->getJsonResponse("error", "Can only add countries by POST request"));
                return;
            }

            $city_name = $_POST["city-name"];
            $city_latitude = $_POST["city-latitude"];
            $city_longitude = $_POST["city-longitude"];
            $city_description = $_POST["city-description"];

            $created = add_city($country->id, $city_name, $city_latitude, $city_longitude, $city_description);
            $this->_helper->json($this->getJsonResponse("success", "Successfully created city", $created));
        } catch (Throwable $e) {
            $this->_helper->json($this->getJsonResponse("error", $e->getMessage()));
        }
    }

    // ======================================================================================================================== \\


}
