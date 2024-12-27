import axios from "axios";

const server = axios.create({
    baseURL: "http://127.0.0.1:8000/api/",
    timeout: 15000,
});

const token = window.sessionStorage.getItem('token');

if (token !== null) {
    server.defaults.headers.common['Authorization'] = 'Bearer ' + token;
}

export default server;