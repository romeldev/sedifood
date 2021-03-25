<template>
    <div>
        <ClientForm ref="clientForm" @submited="handleClientForm" />

        <!-- table -->
        <v-card>
            <v-card-title>
                <v-icon left>{{icon}}</v-icon>
                {{ title }}
                <v-btn x-small fab elevation="1"
                    class="ml-3"
                    color="primary" 
                    
                    @click="openClientForm()"
                ><v-icon>mdi-plus</v-icon></v-btn>

                <v-spacer></v-spacer>
                <v-text-field dense
                    type="search"
                    v-model="filter.search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                    @search="getItems()"
                ></v-text-field>

            </v-card-title>

            <v-data-table
                :headers="headers"
                :items="dataItems.data"
                :loading="loading"
            >
                <template v-slot:[`item.roles`]="{ item }">
                    {{ item.roles.map( r => r.name).toString() }}
                </template>
                <template v-slot:[`item.action`]="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="openClientForm(item)"
                    >
                        mdi-pencil
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
import ClientForm from './components/ClientForm'
export default {
    components: { ClientForm },
    data () {
        return {
            icon: 'mdi-folder-account-outline',
            resource: 'setting/clients',
            title: 'Clientes',
            loading: false,

            filter: {
                search: null,
            },

            headers: [
                { text: 'Doc', value: 'iddoc.name_short' },
                { text: 'Numero', value: 'iddoc_num' },
                { text: 'Cliente', value: 'title' },
                { text: 'CodigoZip', value: 'zipcode' },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            form: new Form({}),

            dataItems: { data: [] },

            itemIndex: null,
        }
    },

    computed: {
        actionCreate() {
          return this.form.id === null;
        },
    },


    mounted() {
        this.getItems();
    },

    methods: {
        openClientForm(item = null) {
            this.itemIndex = item? this.dataItems.data.findIndex(i => i.id === item.id): null
            this.$refs.clientForm.form.id = item? item.id: null
            this.$refs.clientForm.dialog = true
        },

        handleClientForm( data ) {
            if (data.action === 'create') {
                this.$toast('registro creado!', 'success')
                this.filter.search = data.client.iddoc_num
                this.getItems()
            }
            if (data.action === 'edit') {
                this.dataItems.data.splice(this.itemIndex, 1, data.client)
                this.$toast('registro actualizado!', 'success')
            }
            if (data.action === 'delete') {
                this.$toast('registro eliminado!', 'success')
                // this.filter.search = null
                this.getItems()
            }
            this.$refs.clientForm.dialog = false
        },

        async getItems() {
            try {
                this.loading = true
                const params = { search: this.filter.search }
                const { data }  = await this.form.get(`/${this.resource}`, { params })
                this.dataItems = data
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