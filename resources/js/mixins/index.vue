<script>
import { mapGetters } from 'vuex';
import 'print-js'

export default {

    data() {
        return {
           
        }
    },

    computed: {
        ...mapGetters({
            alert: 'app/GET_ALERT',
            params: 'params'
        })
    },

    methods: {

        $print( source, type = 'image', $newTab = false) {
            printJS(source, type)
        },

        $param(key){
            return this.params[key]
        },

        $toast(message, type=null, timeout=3000) {

            let color = null
            let icon = null
            switch(type) {
                case 'success': 
                    color = 'success'
                    icon = 'mdi-check-bold'
                    break
                case 'warning': 
                    color = 'yellow darken-2'
                    icon = 'mdi-alert'
                    break
                case 'danger': 
                    color = 'error'
                    icon = 'mdi-close-octagon'
                    break
                case 'info': 
                    color = 'light-blue'
                    icon = 'mdi-information-variant'
                    break
            }
            this.alert.color = color
            this.alert.icon = icon
            this.alert.timeout = timeout
            this.alert.message = message
            this.alert.show = true
        }
    },
};
</script>
