import Layout from '@/templates/master/Layout'

const settingRoutes = {
    path: '/setting',
    component: Layout,
    meta: {},
    children: [
        { 
            path: '/setting/regimes', 
            name: 'setting.regimes', 
            component: () => import('@module-setting/views/regime/RegimeCrud'),
            meta: { permission: 'menu.setting.regimes'} 
        },
        { 
            path: '/setting/supply-types', 
            name: 'setting.supply-types', 
            component: () => import('@module-setting/views/supply-type/SupplyTypeCrud'),
            meta: { permission: 'menu.setting.supply-types'} 
        },
        { 
            path: '/setting/preparation-types', 
            name: 'setting.preparation-types', 
            component: () => import('@module-setting/views/preparation-type/PreparationTypeCrud'),
            meta: { permission: 'menu.setting.preparation-types'} 
        },
        { 
            path: '/setting/food-types', 
            name: 'setting.food-types', 
            component: () => import('@module-setting/views/food-type/FoodTypeCrud'),
            meta: { permission: 'menu.setting.food-types'} 
        },
        { 
            path: '/setting/coins', 
            name: 'setting.coins', 
            component: () => import('@module-setting/views/coin/CoinCrud'),
            meta: { permission: 'menu.setting.coins'} 
        },
        { 
            path: '/setting/professionals', 
            name: 'setting.professionals', 
            component: () => import('@module-setting/views/professional/ProfessionalCrud'),
            meta: { permission: 'menu.setting.professionals'} 
        },
        { 
            path: '/setting/supplies', 
            name: 'setting.supplies', 
            component: () => import('@module-setting/views/supply/SupplyCrud'),
            meta: { permission: 'menu.setting.supplies'} 
        },
    ],
}

export default settingRoutes