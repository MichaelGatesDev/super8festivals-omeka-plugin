export default class Rest {

    static async _sendWithData(method, endpoint, data) {
        return fetch(endpoint, {
            method: method,
            body:  JSON.stringify(data),
        }).then(resp => resp.json()).then((json) => {
            if (json.status === 'error') throw new Error(json.message);
            return json.data;
        });
    }

    static async get(endpoint) {
        return fetch(endpoint)
            .then(resp => resp.json())
            .then((json) => {
                if (json.status === 'error') throw new Error(json.message);
                return json.data;
            });
    }

    static async post(endpoint, data) {
        return this._sendWithData("POST", endpoint, data);
    }

    static async update(endpoint, data) {
        return this._sendWithData("PUT", endpoint, data);
    }

    static async delete(endpoint, data) {
        return this._sendWithData("DELETE", endpoint, data);
    }

}