import Vue from 'vue';
import App from './page/app.vue';
import ElementUI from 'element-ui';
import { message } from 'ant-design-vue';
import router from './router';
import store from './store';
import axios from './axios';

Vue.use(ElementUI);
Vue.use(message);

//handle Http errors
axios.interceptors.response.use(function (response) {
  return response;
}, function (error) {
  if (error.response) {
    if (error.response.status == 401) {
      store.dispatch('logout');
    }
    if (error.response.data.error) {
      Vue.prototype.$message.error(error.response.data.error);
    }
  } else {
    Vue.prototype.$message.error(error.message);
  }
  return Promise.reject(error);
});

Vue.prototype.$http = axios;

const app = new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})

export default { axios }