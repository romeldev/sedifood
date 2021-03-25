import store from '@/store'

export function hasRole( ...roles ){
    if (roles.length===0) return false
    if( roles.length===1 ) return store.getters.roles.includes( roles[0] )
    for(let i=0; i< roles.length; i++){
        if( store.getters.roles.includes( roles[i] ) ) {
            return true
        }
    }
    return false
} 

export function hasPermission( ...permissions ){
    if (permissions.length===0) return false
    if( permissions.length===1 ) return store.getters.permissions.includes( permissions[0] )
    for(let i=0; i< permissions.length; i++){
        if( store.getters.permissions.includes( permissions[i] ) ) {
            return true
        }
    }
    return false
} 