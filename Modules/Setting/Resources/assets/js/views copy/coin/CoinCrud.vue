<template>
    <div>
        <!-- Form -->
        <v-dialog
            v-model="dialog"
            scrollable
            persistent
            max-width="500px"
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
                                <!-- name -->
                                <v-col cols="12" sm="12">
                                    <v-text-field outlined dense
                                        v-model="form.name"
                                        label="Nombre*"
                                        hide-details="auto"
                                        :error="form.errors.has('name')"
                                        :error-messages="form.errors.get('name')"
                                    ></v-text-field>
                                </v-col>
                                <!-- factor -->
                                <v-col cols="12" sm="6">
                                    <v-text-field outlined dense
                                        v-model="form.factor"
                                        label="Factor*"
                                        hide-details="auto"
                                        :error="form.errors.has('factor')"
                                        :error-messages="form.errors.get('factor')"
                                    ></v-text-field>
                                </v-col>

                                <!-- is_paper -->
                                <v-col cols="12" sm="6">
                                    <v-checkbox dense
                                        style="margin-top:8px;"
                                        v-model="form.is_paper"
                                        label="Es Billete*"
                                        hide-details="auto"
                                        :error="form.errors.has('is_paper')"
                                        :error-messages="form.errors.get('is_paper')"
                                    ></v-checkbox>
                                </v-col>

                                <!-- image_file -->
                                <v-col cols="12" sm="12">
                                    <v-file-input dense outlined
                                        full-width
                                        v-model="form.image_file"
                                        label="Firma (max: 3MB)"
                                        show-size
                                        prepend-icon=""
                                        append-icon="mdi-camera"
                                        hide-details="auto"
                                        :error="form.errors.has('image_file')"
                                        :error-messages="form.errors.get('image_file')"
                                        @change="generateUrl"
                                    ></v-file-input>
                                </v-col>

                                <!-- image -->
                                <v-col cols="12" sm="12">
                                    <v-img
                                        v-if="form.image_url!==null"
                                        :lazy-src="form.image_url"
                                        max-height="75"
                                        contain
                                        :src="form.image_url"
                                    ></v-img>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <small>*Campos requeridos</small>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text  outlined  @click="dialog = false" :disabled="saving">close</v-btn>
                    <v-btn color="primary" outlined @click="submit('create')" v-if="!form.id" :disabled="saving">Crear</v-btn>
                    <v-btn color="error" outlined @click="submit('delete')" v-if="form.id" :disabled="saving">Eliminar</v-btn>
                    <v-btn color="success" outlined @click="submit('edit')" v-if="form.id" :disabled="saving">Editar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- table -->
        <v-card>
            <v-card-title>
                <v-icon left>{{icon}}</v-icon>
                {{ title }}
                <v-btn x-small fab elevation="1"
                    class="ml-3"
                    color="primary" 
                    
                    @click="openForm()"
                ><v-icon>mdi-plus</v-icon></v-btn>

                <v-spacer></v-spacer>
                <v-text-field dense
                    type="search"
                    v-model="filter.search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>

            <v-data-table
                :headers="headers"
                :items="filteredItems"
                :loading="loading"
                :search="filter.search"
            >
                <template v-slot:[`item.action`]="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="openForm(item)"
                    >
                        mdi-pencil
                    </v-icon>
                </template>
            </v-data-table> 
        </v-card>
    </div>
</template>

<script>
export default {
    data () {
        return {
            icon: 'mdi-bitcoin',
            resource: 'setting/coins',
            title: 'Monedas',
            titleForm: 'Modena',
            dialog: false,
            loading: false,
            saving: false,

            filter: {
                name: null,
            },
            
            form: new FileForm({
                id: null,
                name: null,
                factor: null,
                image_url: null,
                image: null,
                image_file: null,
                is_paper: false,
                forever: false,
            }),

            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Nombre', value: 'name' },
                { text: 'Factor', value: 'factor' },
                { text: 'Accion', value: 'action' },
            ],

            items: [],

            meta: { procedure_groups: [], modules: [] },

            imageFormats: [ 'image/jpeg', 'image/jpg', 'image/png' ]
        }
    },

    computed: {
        actionCreate() {
          return this.form.id === null;
        },

        filteredItems() {
            return this.items.filter(item => {
                let matchName = true
                if( this.filter.name!==null && this.filter.name!=='') {
                    matchName = item.name.toUpperCase().includes(this.filter.name.toUpperCase())
                }
                return matchName;
            });
        },
    },

    mounted() {
        this.getMeta()
        this.getItems()
    },

    methods: {

        handleImage( e ){
            if( e.target.files && e.target.files[0] && this.imageFormats.includes(e.target.files[0].type))
            {
                this.form.image_file = e.target.files[0]
                var reader = new FileReader()
                let thisForm = this.form
                reader.onload = function(e){
                    thisForm.image_url = e.target.result
                }
                reader.readAsDataURL(e.target.files[0])
            }
        },

        openForm(item = null) {
            this.form.clear();
            this.form.reset();
            if (item !== null) {
                this.form.fill( JSON.parse(JSON.stringify(item)) )
            }
            this.dialog = true
        },

        closeForm() {
            this.itemIndex = null
            this.form.clear()
            this.form.reset()
            this.dialog.modal('hide')
        },

        async getMeta() {
            try {
                const params = { service: `get-meta-crud-${this.resource}` }
                const {data} = await this.form.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(params.service, 'danger') 
            }
        },

        async getItems() {
            try {
                this.loading = true
                const { data }  = await this.form.get(`/${this.resource}`)
                this.items = data
                console.log('data', data)
            } catch (error) {
                this.$toast(error.message, 'danger') 
            } finally {
                this.loading = false
            }
        },

        async submit(action='create') {
            try {
                this.saving = true
                const itemIndex = this.items.findIndex(x => x.id===this.form.id)

                if( action==='delete' && !confirm("¿Realmente desea eliminar el registro?") ){
                    this.dialog = false
                    return
                }

                const { data } = await this.form.req(`/${this.resource}`, action)

                if (action === 'create') {
                    this.items.unshift(data)
                    this.$toast('registro creado!', 'success')
                }
                if (action === 'edit') {
                    this.items.splice(itemIndex, 1, data)
                    this.$toast('registro actualizado!', 'success')
                }
                if (action === 'delete') {
                    this.items.splice(itemIndex, 1)
                    this.$toast('registro eliminado!', 'success')
                }
                this.dialog = false
            } catch (error) {
                // if (error.response && error.response.status !== 422) {
                    this.$toast(error.message, 'danger')
                // }
            } finally {
                this.saving = false
            }
        },

        generateUrl( file ){
                console.log('file', file)
            if( file!==null && this.imageFormats.includes(file.type)){
                var reader = new FileReader()
                let thisForm = this.form
                reader.onload = function(e){
                    thisForm.image_url = e.target.result
                }
                reader.readAsDataURL(file)
            }else {
                this.form.image_url = null
            }
        },
    },
}
</script>