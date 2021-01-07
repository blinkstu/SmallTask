import Vue from 'vue'
import Vuex from 'vuex'
import axios from './axios';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('token') || '',
    user: null
  },
  mutations: {
    auth_success(state, token) {
      state.status = 'success'
      state.token = token
    },
    logout(state) {
      state.status = ''
      state.user = null
      state.token = ''
    },
    save_user_info(state, user) {
      state.user = user;
    }
  },
  actions: {
    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        axios.post('/auth/login', user).then(resp => {
          const token = resp.data.token
          localStorage.setItem('token', token)
          commit('auth_success', token)
          resolve(resp)
        })
          .catch(err => {
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        axios.post('/auth/register', user)
          .then(resp => {
            const token = resp.data.token
            const user = resp.data.user
            localStorage.setItem('token', token)
            commit('auth_success', token, user)
            resolve(resp)
          })
          .catch(err => {
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    userInfo({ commit }) {
      return new Promise((resolve, reject) => {
        axios.get('/auth/me')
          .then(resp => {
            const user = resp.data;
            commit('save_user_info', user)
            resolve(resp)
          })
          .catch(err => {
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        commit('logout')
        localStorage.removeItem('token')
        resolve()
      })
    }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
  }
})