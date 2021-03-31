const getters = {
    isLogged: state => state.user.token!==null && state.user.token!=='',
    userId: state => state.user.id,
    username: state => state.user.name,
    email: state => state.user.email,
    token: state => state.user.token,
    menu: state => state.user.menu,
    avatar: state => state.user.avatar,
    warehouseId: state => state.user.warehouse_id,

    appLogo: state => state.app.logo,
    appName: state => state.app.name,
}

export default getters