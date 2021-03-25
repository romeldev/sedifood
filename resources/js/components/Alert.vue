<template>
    <v-snackbar
        right top
        v-model="alert.show"
        :color="alert.color"
        :outlined="alert.outlined"
        :timeout="alert.timeout"
        :app="true"
    >
        <v-icon>{{ alert.icon }}</v-icon>
        {{ alert.message }}
        <template v-slot:action="{ attrs }">
            <v-btn
                :color="alert.btn_color"
                :text="true"
                v-bind="attrs"
                @click="alert.show=false"
            >
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
        }
    },

    computed: {
        ...mapGetters({
            alert: 'app/GET_ALERT',
        })
    },

    methods: {

    },
}
</script>

<style>

</style>