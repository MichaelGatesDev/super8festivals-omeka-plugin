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
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created filmmaker object.
     */
    static async addFilmmaker(formData) {
        return Rest.post("/rest-api/filmmakers/", formData);
    }

    /**
     * Updates a filmmaker object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated filmmaker object.
     */
    static async updateFilmmaker(formData) {
        return Rest.post(`/rest-api/filmmakers/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker object from the database.
     * @param filmmakerID - The ID of the filmmaker to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted filmmaker object.
     */
    static async deleteFilmmaker(filmmakerID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of filmmaker photo objects.
     */
    static async getAllFilmmakerPhotos(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/photos/`);
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is a filmmaker photo object.
     */
    static async getFilmmakerPhoto(filmmakerID, filmmakerPhotoID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/photos/${filmmakerPhotoID}/`);
    }

    /**
     * Creates a new filmmaker photo object in the database based on info from the passed object.
     * @param filmmakerID - The ID of the filmmaker.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created filmmaker photo object.
     */
    static async addFilmmakerPhoto(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/photos/`, formData);
    }

    /**
     * Updates a filmmaker photo object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated filmmaker photo object.
     */
    static async updateFilmmakerPhoto(formData) {
        return Rest.post(`/rest-api/filmmakers/${formData.get("filmmaker-id")}/photos/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker photo object from the database.
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerPhotoID - The ID of the filmmaker photo to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted filmmaker photo object.
     */
    static async deleteFilmmakerPhoto(filmmakerID, filmmakerPhotoID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/photos/${filmmakerPhotoID}/`);
    }

    /**
     * @param filmmakerID - The ID of the filmmaker.
     * @returns {Promise<* | void>} a promise, whose success result is an array of filmmaker film objects.
     */
    static async getAllFilmmakerFilms(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/films/`);
    }

    /**
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerFilmID - The ID of the filmmaker film to delete.
     * @returns {Promise<* | void>} a promise, whose success result is a filmmaker film object.
     */
    static async getFilmmakerFilm(filmmakerID, filmmakerFilmID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/films/${filmmakerFilmID}/`);
    }

    /**
     * Creates a new filmmaker film object in the database based on info from the passed object.
     * @param filmmakerID - The ID of the filmmaker.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created filmmaker film object.
     */
    static async addFilmmakerFilm(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/films/`, formData);
    }

    /**
     * Updates a filmmaker film object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated filmmaker film object.
     */
    static async updateFilmmakerFilm(formData) {
        return Rest.post(`/rest-api/filmmakers/${formData.get("filmmaker-id")}/films/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker film object from the database.
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerFilmID - The ID of the filmmaker film to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted filmmaker film object.
     */
    static async deleteFilmmakerFilm(filmmakerID, filmmakerFilmID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/films/${filmmakerFilmID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>} a promise, whose success result is an array of contributor objects.
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
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created contributor object.
     */
    static async addContributor(formData) {
        return Rest.post("/rest-api/contributors/", formData);
    }

    /**
     * Updates a contributor object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated contributor object.
     */
    static async updateContributor(formData) {
        return Rest.post(`/rest-api/contributors/${formData.get("id")}/`, formData);
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
     * @returns {Promise<* | void>} a promise, whose success result is an array of staff objects.
     */
    static async getAllStaff() {
        return Rest.get("/rest-api/staff/");
    }

    /**
     * @returns {Promise<* | void>} a promise, whose success result is a staff object.
     */
    static async getStaff(staffID) {
        return Rest.get(`/rest-api/staff/${staffID}/`);
    }

    /**
     * Creates a new staff object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created staff object.
     */
    static async addStaff(formData) {
        return Rest.post("/rest-api/staff/", formData);
    }

    /**
     * Updates a staff object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated staff object.
     */
    static async updateStaff(formData) {
        return Rest.post(`/rest-api/staff/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a staff object from the database.
     * @param staffID - The ID of the staff to delete.
     * @returns {Promise<* | void>} a promise, whose success result is the deleted staff object.
     */
    static async deleteStaff(staffID) {
        return Rest.delete(`/rest-api/staff/${staffID}/`);
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
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the created country object.
     */
    static async addCountry(formData) {
        return Rest.post("/rest-api/countries/", formData);
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated country object.
     */
    static async updateCountry(formData) {
        return Rest.post(`/rest-api/countries/${formData.get("id")}/`, formData);
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
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the added city object.
     */
    static async addCityToCountry(countryID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/`, formData);
    }

    /**
     * @param countryID - The ID of the country to fetch the city from.
     * @param formData - FormData object
     * @returns {Promise<* | void>} a promise, whose success result is the updated city object.
     */
    static async updateCityInCountry(countryID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${formData.get("id")}/`, formData);
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
