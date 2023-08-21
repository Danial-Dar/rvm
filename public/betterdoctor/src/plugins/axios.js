import axios from "axios";
import Vue from "vue";
import router from "../router/index";
let api = axios.create({
  baseURL: process.env.VUE_APP_API_URL + "/api",
  timeout: 60000
});

api.interceptors.request.use(
  config => {
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);
api.interceptors.response.use(
  response => {
    if (response.status === 200 || response.status === 201) {
      return Promise.resolve(response);
    } else {
      return Promise.reject(response);
    }
  },
  error => {
    if (error.response.status) {
      switch (error.response.status) {
        case 400:
          Vue.prototype.$toasted.show(error.response.data).goAway(1500);
          throw new Error(error);
          break;
        case 403:
          router.replace({
            path: "/login",
            query: { redirect: router.currentRoute.fullPath }
          });
          break;
        case 500:
          Vue.prototype.$toasted.show("Something went wrong").goAway(1500);
          throw new Error(error);
          break;
      }
      return error;
    }
  }
);

export default api;
