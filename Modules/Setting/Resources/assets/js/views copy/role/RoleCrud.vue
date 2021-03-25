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
                                <!-- permissions -->
                                <v-col cols="12" sm="12">
                                    <v-data-table dense
                                        v-model="form.permissions"
                                        :headers="permissionHeaders"
                                        :items="orderedPermissions"
                                        item-key="id"
                                        show-select
                                        class="elevation-1"
                                        disable-sort
                                        disable-pagination
                                        hide-default-footer
                                    ></v-data-table>
                                    <small class="error--text"
                                        v-if="form.errors.has('permissions')"
                                        v-html="form.errors.get('permissions')"
                                    ></small>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <small>*Campos requeridos</small>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text  outlined  @click="closeForm" :disabled="saving">close</v-btn>
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
                :items="items"
                :loading="loading"
                :search="filter.search"
            >
                <template v-slot:[`item.permissions`]="{ item }">
                    {{ item.permissions.length }}
                </template>
                <template v-slot:[`item.action`]="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="openForm(item)"
                        v-if="!item.forever"
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
            icon: 'mdi-shield-account',
            resource: 'setting/roles',
            title: 'Roles',
            titleForm: 'Rol',
            dialog: false,
            loading: false,
            saving: false,

            filter: {
                search: null,
            },

            form: new Form({
                id: null,
                name: null,
                forever: false,
                permissions: [],
            }),

            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Nombre', value: 'name' },
                { text: 'Permisos', value: 'permissions' },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            permissionHeaders: [
                { text: 'Permiso', value: 'name' },
            ],

            items: [],

            meta: { permissions: [] },
        }
    },

    computed: {
        actionCreate() {
          return this.form.id === null;
        },

        orderedPermissions() {
            return this.meta.permissions.sort((a, b) => a.name.localeCompare(b.name) );
        },
    },


    mounted() {
        this.getMeta()
        this.getItems()
    },

    methods: {
        openForm(item = null) {
            this.form.clear()
            this.form.reset()
            if (item !== null) {
                this.form.fill(JSON.parse(JSON.stringify(item)))
            }
            this.dialog = true
        },

        closeForm() {
            this.dialog = false
        },

        async getMeta() {
            try {
                const params = { service: `get-meta-crud-roles` }
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
            } catch (error) {
                this.$toast(error.message, 'danger')
            } finally {
                this.loading = false
            }
        },

        async submit(action = 'create') {
            try {
                this.form.clear()
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
    },

}
</script>