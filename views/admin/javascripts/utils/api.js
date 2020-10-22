import Rest from "./rest.js";

export default class API {

    // ===================================================================================================================================================== \\

    /**
     * Returns a promise, whose success result is an array of country objects.
     * @returns {Promise<* | void>}
     */
    static async getAllFilmmakers() {
        return Rest.get("/rest-api/filmmakers/");
    }

    /**
     * Returns a promise, whose success result is a country object.
     * @returns {Promise<* | void>}
     */
    static async getFilmmaker(filmmakerID) {
        return Rest.get(`/rest-api/countries/${filmmakerID}/`);
    }

    /**
     * Creates a new country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the created country object
     * @param filmmakerObj - The object to take the info from.
     * @returns {Promise<* | void>}
     */
    static async addFilmmaker(filmmakerObj) {
        return Rest.post("/rest-api/filmmakers/add/", filmmakerObj);
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the updated country object.
     * @param filmmakerObj - The object to take updated info from.
     * @returns {Promise<* | void>}
     */
    static async updateFilmmaker(filmmakerObj) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerObj.id}/`, filmmakerObj);
    }

    /**
     * Deletes a country object from the database.
     * Returns a promise, whose success result is the deleted country object.
     * @param filmmakerID - The ID of the country to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteFilmmaker(filmmakerID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * Returns a promise, whose success result is an array of country objects.
     * @returns {Promise<* | void>}
     */
    static async getAllCountries() {
        return Rest.get("/rest-api/countries/");
    }

    /**
     * Returns a promise, whose success result is a country object.
     * @returns {Promise<* | void>}
     */
    static async getCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/`);
    }

    /**
     * Creates a new country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the created country object
     * @param countryObj - The object to take the info from.
     * @returns {Promise<* | void>}
     */
    static async addCountry(countryObj) {
        return Rest.post("/rest-api/countries/add/", countryObj);
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * Returns a promise, whose success result is the updated country object.
     * @param countryObj - The object to take updated info from.
     * @returns {Promise<* | void>}
     */
    static async updateCountry(countryObj) {
        return Rest.post(`/rest-api/countries/${countryObj.id}/`, countryObj);
    }

    /**
     * Deletes a country object from the database.
     * Returns a promise, whose success result is the deleted country object.
     * @param countryID - The ID of the country to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCountry(countryID) {
        return Rest.delete(`/rest-api/countries/${countryID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * Returns a promise, whose success result is an array of all city objects in the database.
     * @returns {Promise<* | void>}
     */
    static async getAllCities() {
        return Rest.get("/rest-api/cities/");
    }

    /**
     * Returns a promise, whose success result is an array of city objects for the specified country.
     * @param countryID - The ID of the country in which the cities exist.
     * @returns {Promise<* | void>}
     */
    static async getCitiesInCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/`);
    }

    /**
     * Returns a promise, whose success result is a city object for the specified country ID and city ID.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityID - The ID of the city.
     * @returns {Promise<* | void>}
     */
    static async getCityInCountry(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    /**
     * Returns a promise, whose success result is the added city object.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityObj - The object to take info from.
     * @returns {Promise<* | void>}
     */
    static async addCityToCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/add/`, cityObj);
    }

    /**
     * Returns a promise, whose success result is the updated city object.
     * @param countryID - The ID of the country in which the city exists.
     * @param cityObj - The object to take updated info from.
     * @returns {Promise<* | void>}
     */
    static async updateCityInCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityObj.id}/`, cityObj);
    }

    /**
     * Deletes a city object from the database.
     * Returns a promise, whose success result is the deleted city object.
     * @param countryID - The ID of the country to delete.
     * @param cityID - The ID of the city to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCityFromCountry(countryID, cityID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * Returns a promise, whose success result is an array of all city objects in the database.
     * @returns {Promise<* | void>}
     */
    static async getAllFestivals() {
        return Rest.get("/rest-api/festivals/");
    }

    /**
     * Returns a promise, whose success result is an array of city objects for the specified country.
     * @param cityID - The ID of the city in which the festivals exist.
     * @returns {Promise<* | void>}
     */
    static async getAllFestivalsInCity(cityID) {
        return Rest.get(`/rest-api/cities/${cityID}/festivals/`);
    }

    /**
     * Returns a promise, whose success result is the added festival object.
     * @param cityID - The ID of the city in which the festival exists.
     * @param festivalObj - The object to take info from.
     * @returns {Promise<* | void>}
     */
    static async addFestival(cityID, festivalObj) {
        return Rest.post(`/rest-api/cities/${cityID}/festivals/add/`, festivalObj);
    }

    /**
     * Returns a promise, whose success result is the updated festival object.
     * @param festivalObj - The updated festival object.
     * @returns {Promise<* | void>}
     */
    static async updateFestival(festivalObj) {
        return Rest.post(`/rest-api/festivals/${festivalObj.id}`, festivalObj);
    }

    /**
     * Returns a promise, whose success result is the deleted festival object.
     * @param festivalID - The festival ID to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteFestival(festivalID) {
        return Rest.delete(`/rest-api/festivals/${festivalID}/`);
    }

    // ===================================================================================================================================================== \\
}
