<template>
    <v-app id="inspire">
        <Alert/>
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md5 lg4>
                        <router-view></router-view>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Alert from '@/components/Alert'
export default {
    components: { Alert },
    data() {
        return {
            drawer: null,
        }
    },

    methods: {

    }
}
</script>