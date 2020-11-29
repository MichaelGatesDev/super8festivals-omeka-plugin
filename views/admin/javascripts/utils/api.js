import Rest from "./rest.js";

export default class API {

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of filmmaker objects.
     */
    static async getAllFilmmakers() {
        return Rest.get("/rest-api/filmmakers/");
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is a filmmaker object.
     */
    static async getFilmmaker(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    /**
     * Creates a new filmmaker object in the database based on info from the passed object.
     * @param filmmakerObj - The object to take the info from.
     * @returns {Promise<* | void>} a promise, whose success result is the created filmmaker object.
     */
    static async addFilmmaker(filmmakerObj) {
        return Rest.post("/rest-api/filmmakers/", filmmakerObj);
    }

    /**
     * Updates a filmmaker object in the database based on info from the passed object.
     * @param filmmakerObj - The object to take updated info from.
     * @returns {Promise<* | void>} a promise, whose success result is the updated filmmaker object.
     */
    static async updateFilmmaker(filmmakerObj) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerObj.id}/`, filmmakerObj);
    }

    /**
     * Deletes a filmmaker object from the database.
     * @param filmmakerID - The ID of the filmmaker to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted filmmaker object.
     */
    static async deleteFilmmaker(filmmakerID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of filmmaker objects.
     */
    static async getAllContributors() {
        return Rest.get("/rest-api/contributors/");
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is a contributor object.
     */
    static async getContributor(contributorID) {
        return Rest.get(`/rest-api/contributors/${contributorID}/`);
    }

    /**
     * Creates a new contributor object in the database based on info from the passed object.
     * @param contributorObj - The object to take the info from.
     * @returns {Promise<* | void>} a promise, whose success result is the created contributor object.
     */
    static async addContributor(contributorObj) {
        return Rest.post("/rest-api/contributors/", contributorObj);
    }

    /**
     * Updates a contributor object in the database based on info from the passed object.
     * @param contributorObj - The object to take updated info from.
     * @returns {Promise<* | void>} a promise, whose success result is the updated contributor object.
     */
    static async updateContributor(contributorObj) {
        return Rest.post(`/rest-api/contributors/${contributorObj.id}/`, contributorObj);
    }

    /**
     * Deletes a contributor object from the database.
     * @param contributorID - The ID of the contributor to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted contributor object.
     */
    static async deleteContributor(contributorID) {
        return Rest.delete(`/rest-api/contributors/${contributorID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of country objects.
     */
    static async getCountries() {
        return Rest.get("/rest-api/countries/");
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is a country object.
     */
    static async getCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/`);
    }

    /**
     * Creates a new country object in the database based on info from the passed object.
     * @param countryObj - The object to take the info from.
     * @returns {Promise<* | void>} a promise, whose success result is the created country object.
     */
    static async addCountry(countryObj) {
        return Rest.post("/rest-api/countries/", countryObj);
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * @param countryObj - The object to take updated info from.
     * @returns {Promise<* | void>} a promise, whose success result is the updated country object.
     */
    static async updateCountry(countryObj) {
        return Rest.post(`/rest-api/countries/${countryObj.id}/`, countryObj);
    }

    /**
     * Deletes a country object from the database.
     * @param countryID - The ID of the country to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted country object.
     */
    static async deleteCountry(countryID) {
        return Rest.delete(`/rest-api/countries/${countryID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of all city objects in the database.
     */
    static async getCities() {
        return Rest.get("/rest-api/cities/");
    }

    /**
     * @param countryID - The ID of the country to fetch the cities from.
     * @returns {Promise<* | void>} a promise, whose success result is an array of city objects for the specified country.
     */
    static async getCitiesInCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/`);
    }

    /**
     * @param countryID - The ID of the country to fetch the city from.
     * @param cityID - The ID of the city.
     * @returns {Promise<* | void>} a promise, whose success result is a city object for the specified country ID and city ID.
     */
    static async getCityInCountry(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    /**
     * @param countryID - The ID of the country to fetch the city from.
     * @param cityObj - The object to take info from.
     * @returns {Promise<* | void>} a promise, whose success result is the added city object.
     */
    static async addCityToCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/`, cityObj);
    }

    /**
     * @param countryID - The ID of the country to fetch the city from.
     * @param cityObj - The object to take updated info from.
     * @returns {Promise<* | void>} a promise, whose success result is the updated city object.
     */
    static async updateCityInCountry(countryID, cityObj) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityObj.id}/`, cityObj);
    }

    /**
     * Deletes a city object from the database.
     * @param countryID - The ID of the country to delete.
     * @param cityID - The ID of the city to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted city object.
     */
    static async deleteCityFromCountry(countryID, cityID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of all city objects in the database.
     */
    static async getFestivals() {
        return Rest.get("/rest-api/festivals/");
    }

    /**
     * @param cityID - The ID of the city to fetch the festivals from.
     * @returns {Promise<* | void>} a promise, whose success result is an array of city objects for the specified country.
     */
    static async getFestivalsInCity(cityID) {
        return Rest.get(`/rest-api/cities/${cityID}/festivals/`);
    }

    /**
     * @param cityID - The ID of the city to fetch the festival from.
     * @param festivalObj - The object to take info from.
     * @returns {Promise<* | void>} a promise, whose success result is the added festival object.
     */
    static async addFestival(cityID, festivalObj) {
        return Rest.post(`/rest-api/cities/${cityID}/festivals/`, festivalObj);
    }

    /**
     * @param festivalObj - The updated festival object.
     * @returns {Promise<* | void>} a promise, whose success result is the updated festival object.
     */
    static async updateFestival(festivalObj) {
        return Rest.post(`/rest-api/festivals/${festivalObj.id}`, festivalObj);
    }

    /**
     * @param festivalID - The festival ID to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted festival object.
     */
    static async deleteFestival(festivalID) {
        return Rest.delete(`/rest-api/festivals/${festivalID}/`);
    }

    // ===================================================================================================================================================== \\
}
