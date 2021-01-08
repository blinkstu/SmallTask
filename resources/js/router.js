import VueRouter from 'vue-router';
import Vue from 'vue';
import Login from './page/Login.vue';
import Register from './page/Register.vue';
import Dashboard from './page/Dashboard.vue';
import Admin from './page/Admin.vue';
import Client from './page/Client.vue';
import NotFound from './page/NotFound.vue';
import NewTicket from './component/NewTicket';
import AddMessage from './component/AddMessage'
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
        component: Admin,
        meta: { role: 'admin' },
      },
      {
        path: 'client',
        component: Client,
        meta: { role: 'client' },
      },
      {
        path: '/tickets/new',
        component: NewTicket,
        meta: { role: 'client' },
      },
      {
        path: '/tickets/:id/add_message',
        component: AddMessage
      }
    ]
  },
  { path: '*', component: NotFound }
]

const router = new VueRouter({
  routes
})


//Protect frontend routes
router.beforeEach((to, from, next) => {

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      const user = store.state.user;
      if (user && to.meta.role == 'admin' && user.role != 'admin') {
        next('/client')
      }

      if (user && to.meta.role == 'client' && user.role != 'client') {
        next('/admin')
      }

      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

export default router