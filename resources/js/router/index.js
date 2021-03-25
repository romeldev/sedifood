import Vue from 'vue'
import VueRouter from 'vue-router'

import { AppLayout, AuthLayout } from '@/templates'

import NotFound from '../components/NotFound'
import Home from '@/views/Home'
import Login from '@/views/Auth/Login'

Vue.use(VueRouter)

import settingRoutes from './modules/setting'
import cateringRoutes from './modules/catering'

const routes = [

    { path: '/login', component: AuthLayout, 
        children: [
            { path: '', component: Login },
        ]
    },

    { path: '', component: AppLayout,
        children: [
            { path: '/', name: 'home', component: Home },
        ] 
    },
    
    settingRoutes,
    cateringRoutes,
    
    // not found
    // { path: '/not-found', name:  'NotFound', component: NotFound },
    // { path: '*', name:  'NotFoundAll', component: NotFound },
    
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router;