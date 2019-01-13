import axios from 'axios';

class Network {
    constructor(axiosInstance) {
        this.axios = axiosInstance;
    }

    get(url, params) {
        return this.axios.get(url, params);
    }

    post(url, data, params = null) {
        return this.axios.post(url, data, params);
    }
}

const instance = axios.create({
    baseURL: 'http://localhost',
    withCredentials: true
});

export default new Network(instance);
