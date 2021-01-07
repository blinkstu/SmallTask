import VueRouter from 'vue-router'
import Vue from 'vue'
import Login from './vue/Login.vue';
import Register from './vue/Register.vue';
import Dashboard from './vue/Dashboard.vue';
import Admin from './vue/Admin.vue';
import Client from './vue/Client.vue';
import store from './store';

Vue.use(VueRouter)

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {
    path: '/',
    component: Dashboard, 
    meta: { requiresAuth: true },
    children: [
    ]
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
  console.log(store.state.user);
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

export default router