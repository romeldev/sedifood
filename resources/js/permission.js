import router from './router'
import store from './store'

const whiteList = ['/login', '/auth-redirect']; 



router.beforeEach( async (to, from, next ) => {

    if( store.getters.isLogged ){
        if( to.path == '/login'){
            next({ path: '/home' })
        }else{
            if( store.getters.userId!==null ){
                next()
                // const routePermission = to.meta.permission || null
                // if( routePermission===null || hasPermission(routePermission) ) {
                //     next()
                // } else {
                //     next('/404')
                // }
            }else{
                console.log('rehidratar user')
                try {
                    const user  = await store.dispatch('user/getInfo')
                    next({ ...to, replace: true });
                } catch (error) {
                    console.log(error.message)
                    console.warn('error', 'la recuperacion del usuario a fallado')
                    await store.dispatch('user/resetValues');
                    next(`/login?redirect=${to.path}`);
                }
            }
        }
    }else{
        if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
            next()
        } else {
            next(`/login?redirect=${to.path}`);
        }
    }
})