import Rest from "./rest";

export default class API {

    // ===================================================================================================================================================== \\

    /**
     * Returns a promise, whose success result is an array of country objects.
     * @returns {Promise<* | void>}
     */
    static async getAllCountries() {
        return Rest.get("/rest-api/countries/").then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Returns a promise, whose success result is a country object.
     * @returns {Promise<* | void>}
     */
    static async getCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}`).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Creates a new country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the created country object
     * @param countryObj - The object to take the info from.
     * @returns {Promise<* | void>}
     */
    static async addCountry(countryObj) {
        return Rest.post("/rest-api/countries/add", countryObj).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the updated country object.
     * @param countryObj - The object to take updated info from.
     * @returns {Promise<* | void>}
     */
    static async updateCountry(countryObj) {
        return Rest.post(`/rest-api/countries/${countryObj.id}`, countryObj).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Deletes a country object from the database.
     * Returns a promise, whose success result is the deleted country object.
     * @param countryID - The ID of the country to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCountry(countryID) {
        return Rest.delete(`/rest-api/countries/${countryID}`).then((data) => data).catch((err) => { throw err; });
    }

    // ===================================================================================================================================================== \\

    // static async getAllCities() {
    //     return Rest.get("/rest-api/countries/").then((data) => data).catch((err) => { throw err; });
    // }

    /**
     * Returns a promise, whose success result is an array of city objects for the specified country.
     * @param countryID - The ID of the country in which the cities exist.
     * @returns {Promise<* | void>}
     */
    static async getCitiesInCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/`).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Returns a promise, whose success result is a city object for the specified country ID and city ID.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityID - The ID of the city.
     * @returns {Promise<* | void>}
     */
    static async getCityInCountryWithID(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}`).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Returns a promise, whose success result is the added city object.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityObj - The object to take info from.
     * @returns {Promise<* | void>}
     */
    static async addCityToCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/add`, cityObj).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Returns a promise, whose success result is the updated city object.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityObj - The object to take updated info from.
     * @returns {Promise<* | void>}
     */
    static async updateCityInCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityObj.id}`, cityObj).then((data) => data).catch((err) => { throw err; });
    }

    /**
     * Deletes a city object from the database.
     * Returns a promise, whose success result is the deleted city object.
     * @param countryID - The ID of the country to delete.
     * @param cityID - The ID of the city to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCityFromCountry(countryID, cityID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}`).then((data) => data).catch((err) => { throw err; });
    }

}