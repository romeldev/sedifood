<template>
    <v-row>
        <!-- company -->
        <v-col cols="12" md="12">
            <v-card>
                <v-card-subtitle>
                    EMPRESA
                </v-card-subtitle>
                <v-card-text>
                    <v-row>
                        <!-- company.name -->
                        <v-col cols="12">
                            <v-text-field dense
                                v-model="form.company.name"
                                label="Nombre*"
                                append-icon="mdi-domain"
                                hide-details="auto"
                                :error="form.errors.has('company.name')"
                                :error-messages="form.errors.get('company.name')"
                            ></v-text-field>
                        </v-col>

                        <!-- company.ruc -->
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field dense
                                v-model="form.company.ruc"
                                label="RUC"
                                hide-details="auto"
                                :error="form.errors.has('company.ruc')"
                                :error-messages="form.errors.get('company.ruc')"
                            ></v-text-field>
                        </v-col>

                        <!-- company.email -->
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field dense
                                v-model="form.company.email"
                                label="Correo"
                                append-icon="mdi-email"
                                hide-details="auto"
                                :error="form.errors.has('company.email')"
                                :error-messages="form.errors.get('company.email')"
                            ></v-text-field>
                        </v-col>

                        <!-- company.phone -->
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field dense
                                v-model="form.company.phone"
                                label="Telefono"
                                append-icon="mdi-phone"
                                hide-details="auto"
                                :error="form.errors.has('company.phone')"
                                :error-messages="form.errors.get('company.phone')"
                            ></v-text-field>
                        </v-col>

                        <!-- company.whatsapp -->
                        <v-col cols="12" sm="6" md="3">
                            <v-text-field dense
                                v-model="form.company.whatsapp"
                                label="Whatsapp"
                                append-icon="mdi-whatsapp"
                                hide-details="auto"
                                :error="form.errors.has('company.whatsapp')"
                                :error-messages="form.errors.get('company.whatsapp')"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>

        <!-- print -->
        <v-col cols="12" md="6">
            <v-card>
                <v-card-subtitle>
                    Impresion
                </v-card-subtitle>
                <v-card-text>
                    <v-row>
                        <!-- print.server -->
                        <v-col cols="12">
                            <v-text-field dense
                                v-model="form.print.server"
                                label="Server"
                                append-icon="mdi-web"
                                hide-details="auto"
                                :error="form.errors.has('print.server')"
                                :error-messages="form.errors.get('print.server')"
                            ></v-text-field>
                        </v-col>
                        <!-- print.server_enable -->
                        <v-col cols="12" sm="6">
                            <v-switch dense inset
                                class="mt-0"
                                v-model="form.print.server_enable"
                                hide-details="auto"
                                :label="`Activar servidor`"
                            ></v-switch>
                        </v-col>
                        <!-- print.auto_print_tickets -->
                        <v-col cols="12" sm="6">
                            <v-switch dense inset
                                class="mt-0"
                                v-model="form.print.auto_print_tickets"
                                hide-details="auto"
                                :label="`Imprimir tikets en automatico`"
                            ></v-switch>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>
        
        <!-- facturator -->
        <v-col cols="12" md="6">
            <v-card>
                <v-card-subtitle>
                    FACTURADOR
                </v-card-subtitle>
                <v-card-text>
                    <v-row>
                        <!-- facturator.url -->
                        <v-col cols="12">
                            <v-text-field dense
                                v-model="form.facturator.url"
                                label="URL"
                                append-icon="mdi-web"
                                hide-details="auto"
                                :error="form.errors.has('facturator.url')"
                                :error-messages="form.errors.get('facturator.url')"
                            ></v-text-field>
                        </v-col>
                        <!-- facturator.token -->
                        <v-col cols="12">
                            <v-text-field dense
                                v-model="form.facturator.token"
                                label="Token"
                                append-icon="mdi-key-variant"
                                hide-details="auto"
                                :error="form.errors.has('facturator.token')"
                                :error-messages="form.errors.get('facturator.token')"
                            ></v-text-field>
                        </v-col>
                        <!-- facturator.certificate -->
                        <v-col cols="12">
                            <v-textarea dense rows="3"
                                v-model="form.facturator.certificate"
                                label="Certificado"
                                append-icon="mdi-certificate-outline"
                                hide-details="auto"
                                :error="form.errors.has('facturator.certificate')"
                                :error-messages="form.errors.get('facturator.certificate')"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-card-text>

            </v-card>
        </v-col>

        <v-col cols="12" class="text-right">
            <v-btn class="primary" @click="save()">
                <v-icon left dark>
                    mdi-content-save
                </v-icon>
                GUARDAR
            </v-btn>
        </v-col>
    </v-row>
        
</template>

<script>
export default {
    data() {
        return {
            resource: 'setting/config',
            loading: false,
            saving: false,

            form: new FileForm({
                company: {
                    name: null,
                    ruc: null,
                    phone: null,
                    email: null,
                    whatsapp: null,
                    image: null,
                    descrip: null,
                },
                facturator: {
                    url: null,
                    token: null,
                    certificate: null,
                },
                print: {
                    server: null,
                    server_enable: false,
                    auto_print_tickets: false,
                }
            })
        }
    },

    mounted() {
        this.getConfig()
    },

    methods: {
        async getConfig() {
            try {
                this.loading = true
                const { data }  = await this.form.get(`/${this.resource}`)
                console.log('data', data)
                this.form.fill(data)
            } catch (error) {
                this.$toast(error.message, 'danger')
            } finally {
                this.loading = false
            }
        },

        async save(action = 'create') {
            try {
                this.form.clear()
                this.saving = true

                const { data } = await this.form.req(`/${this.resource}`)
                this.$toast('Configuracion actualizada', 'success')
            } catch (error) {
                // if (error.response && error.response.status !== 422) {
                    this.$toast(error.message, 'danger')
                // }
            } finally {
                this.saving = false
            }
        },
    }
}
</script>

<style>

</style>