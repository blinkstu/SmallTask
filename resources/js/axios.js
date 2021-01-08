import Axios from 'axios';

//Axios service
const axios = Axios.create({
  baseURL: '/api',
  timeout: 20000,
  headers: { 'X-Custom-Header': 'foobar' }
});;

axios.interceptors.request.use(
  config => {
    config.headers.authorization = 'Bearer ' + localStorage.getItem("token");
    return config;
  },
  error => Promise.reject(error)
);

export default axios;