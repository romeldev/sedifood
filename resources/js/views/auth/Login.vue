<template>
    <v-card class="elevation-12">
        <v-toolbar dark color="primary">
            <v-toolbar-title>Login</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                    v-model="form.username"
                    prepend-icon="mdi-account"
                    name="login"
                    label="Usuario"
                    type="text"
                    :error="form.errors.has('username')"
                    :error-messages="form.errors.get('username')"
                ></v-text-field>
                <v-text-field
                    v-model="form.password"
                    prepend-icon="mdi-lock"
                    name="password"
                    label="Contraseña"
                    type="text"
                    :error="form.errors.has('password')"
                    :error-messages="form.errors.get('password')"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary"
                @click="login"
                :loading="loading"
            >Login</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            drawer: null,
            loading: false,
            form: new Form({
                username: null,
                password: null,
            })
        }
    },

    methods: {
        async login() {
            try {
                this.form.clear()
                this.loading = true
                const resCsrf = await axios.get('/sanctum/csrf-cookie')
                // console.log('resCsrf', resCsrf)
                const {data} = await this.form.req('/login')
                this.$store.dispatch('user/assignData', data)
                this.$router.push({ path: this.redirect || '/', query: this.otherQuery }, onAbort => {})
            } catch (error) {
                if( error.response ) {
                    if( error.response.status===422){
                        this.$toast('Acceso no autorizado', 'danger')
                    }else {
                        this.$toast(error.message, 'danger')
                    }
                }else {
                    this.$toast(error.message, 'danger')
                }
            } finally {
                this.loading = false
            }
        },

        getOtherQuery(query) {
            return Object.keys(query).reduce((acc, cur) => {
                if (cur !== 'redirect') {
                    acc[cur] = query[cur];
                }
                return acc;
            }, {});
        },
    }
}
</script>

<style>

</style>