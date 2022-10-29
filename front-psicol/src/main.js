import { createApp } from 'vue'
import App from './App.vue'
import {createRouter, createWebHashHistory} from 'vue-router'
import Customer from './components/Customer';
import Event from './components/Event'
import ViewEvent from './components/ViewEvent'


const routes = [
    { path: '/customers', component: Customer },
    { path: '/events', component: Event },
    { path: '/events/:id', component: ViewEvent, props: true }
  ]
  
  const router = createRouter({
    history: createWebHashHistory(),
    routes,
  })
  
  createApp(App).use(router).mount('#app')

  
