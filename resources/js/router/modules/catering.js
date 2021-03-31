import Layout from '@/templates/master/Layout'

const routes = {
    path: '/catering',
    component: Layout,
    meta: {},
    children: [
        { 
            path: '/catering/preparations', 
            name: 'catering.preparations', 
            component: () => import('@module-catering/views/preparation/PreparationCrud'),
            meta: { permission: 'menu.catering.preparations'} 
        },
        { 
            path: '/catering/programmings', 
            name: 'catering.programmings', 
            component: () => import('@module-catering/views/programming/ProgrammingCrud'),
            meta: { permission: 'menu.catering.programmings'} 
        },

        { 
            path: '/report/supply-order', 
            name: 'report.supply-order', 
            component: () => import('@module-catering/views/report/SupplyOrder'),
            meta: { permission: 'menu.report.supply-order'} 
        },

        { 
            path: '/stats/nutritional-content', 
            name: 'stats.nutritional-content', 
            component: () => import('@module-catering/views/stats/NutritionalContent'),
            meta: { permission: 'menu.stats.nutritional-content'} 
        },

        { 
            path: '/stats/preparation-content', 
            name: 'stats.preparation-content', 
            component: () => import('@module-catering/views/stats/PreparationContent'),
            meta: { permission: 'menu.stats.preparation-content'} 
        },
    ],
}

export default routes