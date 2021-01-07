import VueRouter from 'vue-router';
import Vue from 'vue';
import Login from './page/Login.vue';
import Register from './page/Register.vue';
import Dashboard from './page/Dashboard.vue';
import Admin from './page/Admin.vue';
import Client from './page/Client.vue';
import NotFound from './page/NotFound.vue';
import NewRequest from './component/NewRequest';
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
      {
        path: 'admin',
        component: Admin
      },
      {
        path: 'client',
        component: Client
      },
      {
        path: 'new_request',
        component: NewRequest
      }
    ]
  },
  { path: '*', component: NotFound }
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