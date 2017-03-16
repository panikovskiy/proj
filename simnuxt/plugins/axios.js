import Vue from 'vue'
import axios from 'axios'

let axiosInit = axios.create({
  baseURL: process.env.baseUrl
})

Vue.prototype.$axios = axiosInit
