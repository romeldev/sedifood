import Cookies from 'js-cookie';

const state = {
    token: Cookies.get('token') || null,
    id: null,
    name: null,
    email: null,
    menu: [],
    avatar: null,
}

const mutations = {
    SET_TOKEN: (state, value) => state.token = value,
    SET_ID: (state, value) => state.id = value,
    SET_NAME: (state, value) => state.name = value,
    SET_EMAIL: (state, value) => state.email = value,
    SET_MENU: (state, value) => state.menu = value,
    SET_AVATAR: (state, value) => state.avatar = value,
}

const actions = {
    getInfo( {commit, dispatch} ){
        const params = { client_code: this.getters.clientCode }
        return new Promise( (resolve, reject) => {
            axios({ method: 'get', url: '/api/user', params })
            .then( res => {
                dispatch('assignData', res.data)
                resolve(res)
            }).catch( err => {
                reject(err)
            })
        })
    },

    // remove token
    resetToken({ commit, dispatch }) {
        return new Promise(resolve => {
            dispatch('resetValues')
            resolve()
        });
    },

    resetValues({commit}){
        Cookies.remove('token');
        commit('SET_TOKEN', null)
        commit('SET_ID', null)
        commit('SET_NAME', null)
        commit('SET_EMAIL', null)
        commit('SET_MENU', [])
        commit('SET_AVATAR', null)
    },

    assignData({commit}, data ) {
        Cookies.set('token', 1)
        commit('SET_TOKEN', '1')
        commit('SET_ID', data.id)
        commit('SET_NAME', data.username)
        commit('SET_EMAIL', data.email)
        commit('SET_MENU', data.menu)
        commit('SET_AVATAR', data.avatar)
    },
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
}