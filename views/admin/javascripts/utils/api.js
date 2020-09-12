import Rest from "./rest";

export default class API {

    // ===================================================================================================================================================== \\

    static async getAllCountries() {
        return Rest.get("/rest-api/countries/").then((data) => data).catch((err) => { throw err; });
    }

    static async getCountry(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}`).then((data) => data).catch((err) => { throw err; });
    }

    static async addCountry(formData) {
        return Rest.post("/rest-api/countries/add", formData).then((data) => data).catch((err) => { throw err; });
    }

    static async updateCountry(countryToUpdate, formData) {
        return Rest.post(`/rest-api/countries/${countryToUpdate.id}`, formData).then((data) => data).catch((err) => { throw err; });
    }

    static async deleteCountry(countryToDelete) {
        return Rest.delete(`/rest-api/countries/${countryToDelete.id}`).then((data) => data).catch((err) => { throw err; });
    }

    // ===================================================================================================================================================== \\

    // static async getAllCities() {
    //     return Rest.get("/rest-api/countries/").then((data) => data).catch((err) => { throw err; });
    // }

    static async getCities(countryID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/`).then((data) => data).catch((err) => { throw err; });
    }

    static async getCity(countryID, cityID) {
        return Rest.get(`/rest-api/countries/${countryID}/cities/${cityID}`).then((data) => data).catch((err) => { throw err; });
    }

    static async addCity(countryID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/add`, formData).then((data) => data).catch((err) => { throw err; });
    }

    static async updateCity(countryID, cityID, formData) {
        return Rest.post(`/rest-api/countries/${countryID}/cities/${cityID}`, formData).then((data) => data).catch((err) => { throw err; });
    }

    static async deleteCity(countryID, cityID) {
        return Rest.delete(`/rest-api/countries/${countryID}/cities/${cityID}`).then((data) => data).catch((err) => { throw err; });
    }

}