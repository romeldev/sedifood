<template>
    <!-- Form -->
    <v-dialog
        v-model="dialog"
        scrollable
        persistent
        max-width="900px"
    >
        <v-card>
            <v-card-title>
                <span class="headline">
                    <v-icon left>{{icon}}</v-icon>
                    {{ titleForm }}
                </span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="pt-5">
                <v-row>
                    <v-col cols="12">
                        <v-row>
                            <!-- iddoc_id -->
                            <v-col cols="12" sm="6">
                                <v-select dense outlined
                                    v-model="form.iddoc_id"
                                    :items="meta.iddocs"
                                    label="Doc.Tipo"
                                    item-value="id"
                                    item-text="name_short"
                                    hide-details="auto"
                                    :error="form.errors.has('iddoc_id')"
                                    :error-messages="form.errors.get('iddoc_id')"
                                    clearable
                                    @change="handleSelectIddoc"
                                ></v-select>
                            </v-col>

                            <!-- iddoc_num -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.iddoc_num"
                                    label="Doc.Numero"
                                    hide-details="auto"
                                    :error="form.errors.has('iddoc_num')"
                                    :error-messages="form.errors.get('iddoc_num')"
                                    :append-icon="(form.iddoc_id===1 || form.iddoc_id===2)? 'mdi-magnify': null"
                                    @click:append="searchPerson"
                                    :loading="searching"
                                    :disabled="searching"
                                ></v-text-field>
                            </v-col>

                            <!-- fullname -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.fullname"
                                    label="Nombre"
                                    hide-details="auto"
                                    :error="form.errors.has('fullname')"
                                    :error-messages="form.errors.get('fullname')"
                                ></v-text-field>
                            </v-col>

                            <!-- tradename -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.tradename"
                                    label="Nombre Comercial"
                                    hide-details="auto"
                                    :error="form.errors.has('tradename')"
                                    :error-messages="form.errors.get('tradename')"
                                ></v-text-field>
                            </v-col>

                            <!-- department_id -->
                            <v-col cols="12" sm="6">
                                <!-- {{ form.department_id }} -->
                                <v-select dense outlined
                                    v-model="form.department_id"
                                    :items="departments"
                                    label="Departamento"
                                    item-value="id"
                                    item-text="name"
                                    hide-details="auto"
                                    :error="form.errors.has('department_id')"
                                    :error-messages="form.errors.get('department_id')"
                                    clearable
                                    @change="hadleSelectDepartment"
                                ></v-select>
                            </v-col>

                            <!-- province_id -->
                            <v-col cols="12" sm="6">
                                <!-- {{ form.province_id }} -->
                                <v-select dense outlined
                                    v-model="form.province_id"
                                    :items="provinces"
                                    label="Provincia"
                                    item-value="id"
                                    item-text="name"
                                    hide-details="auto"
                                    :error="form.errors.has('province_id')"
                                    :error-messages="form.errors.get('province_id')"
                                    clearable
                                    @change="hadleSelectProvince"
                                ></v-select>
                            </v-col>

                            <!-- district_id -->
                            <v-col cols="12" sm="6">
                                <!-- {{ form.district_id }} -->
                                <v-select dense outlined
                                    v-model="form.district_id"
                                    :items="districts"
                                    label="Distrito"
                                    item-value="id"
                                    item-text="name"
                                    hide-details="auto"
                                    :error="form.errors.has('district_id')"
                                    :error-messages="form.errors.get('district_id')"
                                    clearable
                                ></v-select>
                            </v-col>

                            <!-- address -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.address"
                                    label="Direccion"
                                    hide-details="auto"
                                    :error="form.errors.has('address')"
                                    :error-messages="form.errors.get('address')"
                                ></v-text-field>
                            </v-col>

                            <!-- phones -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.phones"
                                    label="Telefono"
                                    hide-details="auto"
                                    :error="form.errors.has('phones')"
                                    :error-messages="form.errors.get('phones')"
                                ></v-text-field>
                            </v-col>

                            <!-- email -->
                            <v-col cols="12" sm="6">
                                <v-text-field outlined dense
                                    v-model="form.email"
                                    label="Correo"
                                    hide-details="auto"
                                    :error="form.errors.has('email')"
                                    :error-messages="form.errors.get('email')"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                </v-row>
                <small>*Campos requeridos</small>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text  outlined  @click="dialog=false" :disabled="saving">close</v-btn>
                <v-btn color="primary" outlined @click="submit('create')" v-if="!form.id" :disabled="saving">Crear</v-btn>
                <v-btn color="error" outlined @click="submit('delete')" v-if="form.id" :disabled="saving">Eliminar</v-btn>
                <v-btn color="success" outlined @click="submit('edit')" v-if="form.id" :disabled="saving">Editar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

export default {
    data () {
        return {
            icon: 'mdi-folder-account-outline',
            resource: 'setting/clients',
            titleForm: 'Cliente',
            saving: false,
            searching: false,
            dialog: false,

            form: new Form({
                id: null,
                iddoc_id: 2,
                // iddoc_num: null,
                // iddoc_num: '20605889906', //sedi 
                iddoc_num: '20389230724', //sodimac
                fullname: null,
                tradename: null,
                zipcode: null,
                address: null,
                phones: null,
                email: null,
                points: null,

                department_id: null,
                province_id: null,
                district_id: null,
            }),

            meta: { iddocs: [], departments: [] },
            lunchEdit: true,
        }
    },

    watch: {
        dialog(newValue) {
            if( newValue ){
                this.openForm()
            }else{
                this.closeForm()
            }
        },
    },

    computed: {
        actionCreate() {
            return this.form.id===null
        },

        departments() {
            return this.meta.departments;
        },

        provinces() {
            const department = this.departments.find( d => d.id === this.form.department_id);
            return typeof department === 'undefined'? []: department.provinces
        },

        districts() {
            const province = this.provinces.find( p => p.id === this.form.province_id);
            return typeof province === 'undefined'? []: province.districts
        }
    },

    mounted() {
        this.getMeta()
    },

    methods: {

        hadleSelectDepartment( value ) {
            this.form.province_id = null
            this.form.district_id = null
        },

        hadleSelectProvince( value ) {
            this.form.district_id = null
        },

        handleSelectIddoc() {
            this.form.fullname = null
            this.form.tradename = null
            this.form.zipcode = null
            this.form.address = null
            this.form.phones = null
            this.form.email = null
            this.form.points = null
            this.form.department_id = null
            this.form.province_id = null
            this.form.district_id = null
        },

        async searchPerson() {
            this.searching = true
            this.handleSelectIddoc()

            try {
                const params = { iddoc_id: this.form.iddoc_id, iddoc_num: this.form.iddoc_num }
                const { data } = await this.form.get(`/${this.resource}/search-person`, {params})

                if( data.success ){
                    if( this.form.iddoc_id === this.$param('IDDOC_DNI_ID')){
                        this.form.fullname = `${data.data.nombres} ${data.data.apellido_paterno} ${data.data.apellido_materno}`
                        this.form.tradename = `${data.data.nombres} ${data.data.apellido_paterno} ${data.data.apellido_materno}`
                    }

                    if( this.form.iddoc_id === this.$param('IDDOC_RUC_ID')){
                        this.form.fullname = data.data.nombre_o_razon_social
                        this.form.tradename = data.data.nombre_o_razon_social
                        this.form.department_id = this.checkValidLocation(data.data.ubigeo[0])
                        this.form.province_id = this.checkValidLocation(data.data.ubigeo[1])
                        this.form.district_id = this.checkValidLocation(data.data.ubigeo[2])
                        this.form.address = data.data.direccion_completa
                    }
                }
            } catch (error) {
                this.$toast(error.message, 'danger')
            } finally {
                this.searching = false
            }
            
        },

        checkValidLocation(location) {
            if(location){
                return location!=='-'? location: null
            }else {
                return null
            }
        },

        async openForm() {
            this.loading = true
            try {
                if (this.form.id !== null) {
                    this.lunchEdit = true
                    this.supplyUnits = true
                    const { data } = await this.form.get(`/${this.resource}/${this.form.id}`)
                    this.form.fill(data)
                }
                this.modal = true
            } catch (error) {
                this.$toast('No se pudo recuperar el producto', 'danger')
                return
            } finally {
                this.loading = false
            }
        },

        closeForm() {
            this.lunchEdit = false
            this.form.clear()
            this.form.reset()
        },

        async getMeta() {
            try {
                const params = { service: `get-meta-crud-clients` }
                const {data} = await this.form.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(error.message, 'danger')
            }
        },

        async submit(action = 'create') {
            try {
                this.form.clear()
                this.saving = true
                let { data } = await this.form.req(`/${this.resource}`, action)
                console.log('data', data)
                this.$emit('submited', { action, 'client': data })
            } catch (error) {
                if (error.response) {
                    if( error.response.status !== 422 ) {
                        this.$toast(error.message, 'danger')
                    }
                }else {
                    this.$toast(error.message, 'danger')
                }
            } finally {
                this.saving = false
            }
        },
    },
}
</script>