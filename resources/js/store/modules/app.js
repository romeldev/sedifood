const state = {
    name: process.env.MIX_APP_NAME,
    baseUrl: process.env.MIX_BASE_API,

    logo: '/img/logo-app.svg',
    
    alert: {
        show: false,
        outlined: false,
        color: null,  
        icon: null,  
        message: null,
        btn_color: null,
        btn_text: 'cerrar',
        timeout: -1
    },

    paginate: {
        procedures: 5,
    }
}

const getters = {
    GET_ALERT(state) {
        return state.alert
    }
}

const mutations = {
    CLOSE_ALERT(state, vaue) {
        state.alert.show = false
    }
}

const actions = {
    closeAlert({commit}) {
        commit('CLOSE_ALERT')
    },
}


export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
}