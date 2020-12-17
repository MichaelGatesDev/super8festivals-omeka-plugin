import Rest from "./rest.js";

export const HTTPRequestMethod = {
    GET: "GET",
    POST: "POST",
    PUT: "PUT",
    DELETE: "DELETE",
};

export default class API {

    // ===================================================================================================================================================== \\

    static constructURL(parts) {
        return `/rest-api/${parts.join("/")}/`;
    }

    /**
     * @param url
     * @param {string} method
     * @param {FormData | null} formData
     * @returns {Promise<void>}
     */
    static submitRequest(url, method, formData = null) {
        switch (method) {
            default:
                break;
            case HTTPRequestMethod.GET:
                return Rest.get(url);
            case HTTPRequestMethod.POST:
                return Rest.post(url, formData);
            case HTTPRequestMethod.PUT:
                return Rest.post(url, formData);
            case HTTPRequestMethod.DELETE:
                return Rest.delete(url);
        }
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getAllFilmmakers() {
        return Rest.get("/rest-api/filmmakers/");
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getFilmmaker(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    /**
     * Creates a new filmmaker object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addFilmmaker(formData) {
        return Rest.post("/rest-api/filmmakers/", formData);
    }

    /**
     * Updates a filmmaker object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateFilmmaker(formData) {
        return Rest.post(`/rest-api/filmmakers/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker object from the database.
     * @param filmmakerID - The ID of the filmmaker to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteFilmmaker(filmmakerID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/`);
    }

    /**
     * @param filmmakerID - The ID of the filmmaker.
     * @returns {Promise<* | void>}
     */
    static async getAllFilmmakerFilms(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/films/`);
    }

    /**
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerFilmID - The ID of the filmmaker film to delete.
     * @returns {Promise<* | void>}
     */
    static async getFilmmakerFilm(filmmakerID, filmmakerFilmID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/films/${filmmakerFilmID}/`);
    }

    /**
     * Creates a new filmmaker film object in the database based on info from the passed object.
     * @param filmmakerID - The ID of the filmmaker.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addFilmmakerFilm(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/films/`, formData);
    }

    /**
     * Updates a filmmaker film object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateFilmmakerFilm(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/films/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker film object from the database.
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerFilmID - The ID of the filmmaker film to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteFilmmakerFilm(filmmakerID, filmmakerFilmID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/films/${filmmakerFilmID}/`);
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getAllFilmmakerPhotos(filmmakerID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/photos/`);
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getFilmmakerPhoto(filmmakerID, filmmakerPhotoID) {
        return Rest.get(`/rest-api/filmmakers/${filmmakerID}/photos/${filmmakerPhotoID}/`);
    }

    /**
     * Creates a new filmmaker photo object in the database based on info from the passed object.
     * @param filmmakerID - The ID of the filmmaker.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addFilmmakerPhoto(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/photos/`, formData);
    }

    /**
     * Updates a filmmaker photo object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateFilmmakerPhoto(filmmakerID, formData) {
        return Rest.post(`/rest-api/filmmakers/${filmmakerID}/photos/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a filmmaker photo object from the database.
     * @param filmmakerID - The ID of the filmmaker.
     * @param filmmakerPhotoID - The ID of the filmmaker photo to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteFilmmakerPhoto(filmmakerID, filmmakerPhotoID) {
        return Rest.delete(`/rest-api/filmmakers/${filmmakerID}/photos/${filmmakerPhotoID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getAllContributors() {
        return Rest.get("/rest-api/contributors/");
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getContributor(contributorID) {
        return Rest.get(`/rest-api/contributors/${contributorID}/`);
    }

    /**
     * Creates a new contributor object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addContributor(formData) {
        return Rest.post("/rest-api/contributors/", formData);
    }

    /**
     * Updates a contributor object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateContributor(formData) {
        return Rest.post(`/rest-api/contributors/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a contributor object from the database.
     * @param contributorID - The ID of the contributor to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteContributor(contributorID) {
        return Rest.delete(`/rest-api/contributors/${contributorID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getAllStaff() {
        return Rest.get("/rest-api/staff/");
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getStaff(staffID) {
        return Rest.get(`/rest-api/staff/${staffID}/`);
    }

    /**
     * Creates a new staff object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addStaff(formData) {
        return Rest.post("/rest-api/staff/", formData);
    }

    /**
     * Updates a staff object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateStaff(formData) {
        return Rest.post(`/rest-api/staff/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a staff object from the database.
     * @param staffID - The ID of the staff to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteStaff(staffID) {
        return Rest.delete(`/rest-api/staff/${staffID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getCountries() {
        return Rest.get("/rest-api/countries/");
    }

    /**
     * @returns {Promise<* | void>}
     */
    static async getCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/`);
    }

    /**
     * Creates a new country object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addCountry(formData) {
        return Rest.post("/rest-api/countries/", formData);
    }

    /**
     * Updates a country object in the database based on info from the passed object.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateCountry(formData) {
        return Rest.post(`/rest-api/countries/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a country object from the database.
     * @param {number} countryID - The ID of the country to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCountry(countryID) {
        return Rest.delete(`/rest-api/countries/${countryID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getCities() {
        return Rest.get("/rest-api/cities/");
    }

    /**
     * @param {number} countryID - The ID of the country to fetch the cities from.
     * @returns {Promise<* | void>}
     */
    static async getCitiesInCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/`);
    }

    /**
     * @param {number} countryID - The ID of the country to fetch the city from.
     * @param {number} cityID - The ID of the city.
     * @returns {Promise<* | void>}
     */
    static async getCityInCountry(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    /**
     * @param {number} countryID - The ID of the country to fetch the city from.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async addCityToCountry(countryID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/`, formData);
    }

    /**
     * @param {number} countryID - The ID of the country to fetch the city from.
     * @param formData
     * @returns {Promise<* | void>}
     */
    static async updateCityInCountry(countryID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${formData.get("id")}/`, formData);
    }

    /**
     * Deletes a city object from the database.
     * @param {number} countryID - The ID of the country to delete.
     * @param {number} cityID - The ID of the city to delete.
     * @returns {Promise<* | void>}
     */
    static async deleteCityFromCountry(countryID, cityID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getFestivals() {
        return Rest.get("/rest-api/festivals/");
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city to fetch the festivals from.
     * @returns {Promise<* | void>}
     */
    static async getFestivalsInCity(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/`);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city to fetch the festival from.
     * @param {FormData} formData
     * @returns {Promise<* | void>}
     */
    static async addFestivalToCity(countryID, cityID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/`, formData);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city to fetch the festival from.
     * @param {FormData} formData
     * @returns {Promise<* | void>}
     */
    static async updateFestivalInCity(countryID, cityID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${formData.get("id")}/`, formData);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city to fetch the festival from.
     * @param festivalID - The ID of the festival to delete
     * @returns {Promise<* | void>}
     */
    static async deleteFestivalFromCity(countryID, cityID, festivalID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${festivalID}/`);
    }

    // ===================================================================================================================================================== \\

    /**
     * @returns {Promise<* | void>}
     */
    static async getAllFilms() {
        return Rest.get(`/rest-api/films/`);
    }


    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city the festival exists in
     * @param {number} festivalID - The ID of the festival the films exist in
     * @returns {Promise<* | void>}
     */
    static async getFilmsForFestival(countryID, cityID, festivalID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${festivalID}/films/`);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city the festival exists in
     * @param {number} festivalID - The ID of the festival the films exist in
     * @param {FormData} formData
     * @returns {Promise<* | void>}
     */
    static async addFilmToFestival(countryID, cityID, festivalID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${festivalID}/films/`, formData);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city the festival exists in
     * @param {number} festivalID - The ID of the festival the films exist in
     * @param {FormData} formData
     * @returns {Promise<* | void>}
     */
    static async updateFilmForFestival(countryID, cityID, festivalID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${festivalID}/films/${formData.get("id")}/`, formData);
    }

    /**
     * @param {number} countryID - The ID of the country the city exists in
     * @param {number} cityID - The ID of the city the festival exists in
     * @param {number} festivalID - The ID of the festival the films exist in
     * @param filmID - The ID of the film to delete
     * @returns {Promise<* | void>}
     */
    static async deleteFilmFromFestival(countryID, cityID, festivalID, filmID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}/festivals/${festivalID}/films/${filmID}`);
    }

    // ===================================================================================================================================================== \\
}
