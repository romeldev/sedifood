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
                        <!-- supply_type_id -->
                        <v-col cols="12" sm="12">
                            <v-select dense outlined
                                v-model="form.supply_type_id"
                                :items="meta.supply_types"
                                label="Tipo de Insumo*"
                                item-value="id"
                                item-text="descrip"
                                hide-details="auto"
                                :error="form.errors.has('supply_type_id')"
                                :error-messages="form.errors.get('supply_type_id')"
                            ></v-select>
                        </v-col>

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

                        <!-- unit_type -->
                        <v-col cols="12" sm="12">
                            <v-select dense outlined
                                v-model="form.unit_type"
                                :items="meta.unit_types"
                                label="Unidad*"
                                item-value="value"
                                item-text="text"
                                hide-details="auto"
                                :error="form.errors.has('unit_type')"
                                :error-messages="form.errors.get('unit_type')"
                            ></v-select>
                        </v-col>

                        <!-- net_weight -->
                        <v-col cols="12" sm="6">
                            <v-text-field outlined dense
                                v-model="form.net_weight"
                                label="Peso*"
                                hide-details="auto"
                                :error="form.errors.has('net_weight')"
                                :error-messages="form.errors.get('net_weight')"
                            ></v-text-field>
                        </v-col>

                        <!-- grams -->
                        <v-col cols="12" sm="6">
                            <v-text-field outlined dense
                                v-model="form.grams"
                                label="Gramos*"
                                hide-details="auto"
                                :error="form.errors.has('grams')"
                                :error-messages="form.errors.get('grams')"
                            ></v-text-field>
                        </v-col>

                        <!-- nutrients -->
                        <v-col cols="12" sm="12">
                           <v-data-table dense
                                :headers="nutrientHeaders"
                                :items="form.nutrients"
                                item-key="id"
                                class="elevation-1"
                                disable-sort
                                disable-pagination
                                hide-default-footer
                            >
                                <template v-slot:[`item.value`]="{ item }">
                                    <v-text-field dense type="number" min="0"
                                        v-model="item.value"
                                        hide-details="auto"
                                        :error="form.errors.has(`nutrients.${item.column}.value`)"
                                        :error-messages="form.errors.get(`nutrients.${item.column}.value`)"
                                    ></v-text-field>
                                </template>
                            </v-data-table>
                        </v-col>
                        
                    </v-row>
                    <small>*Campos requeridos</small>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="closeForm" :disabled="saving">close</v-btn>
                    <v-btn text color="primary" @click="submit('create')" v-if="!form.id" :disabled="saving">Crear</v-btn>
                    <v-btn text color="error" @click="submit('delete')" v-if="form.id" :disabled="saving">Eliminar</v-btn>
                    <v-btn text color="success" @click="submit('edit')" v-if="form.id" :disabled="saving">Editar</v-btn>
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
                    @search="getItems"
                ></v-text-field>

            </v-card-title>

            <v-data-table dense
                :headers="headers"
                :items="dataItems.data"
                :loading="loading"
                disable-sort
                disable-pagination
                hide-default-footer
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

            <v-card-actions>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <v-pagination
                            v-model="dataItems.meta.current_page"
                            :length="dataItems.meta.last_page"
                            :total-visible="7"
                            @input="getItems"
                        ></v-pagination>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    data () {
        return {
            icon: 'mdi-tag',
            resource: 'setting/supplies',
            title: 'Insumos',
            titleForm: 'Insumo',
            dialog: false,
            loading: false,
            saving: false,

            filter: {
                search: null,
            },

            form: new Form({
                id: null,
                name: null,
                unit_type: null,
                supply_type_id: null,
                
                net_weight: 0,
                grams: 0,
                nutrients: [],
            }),

            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Nomnbre', value: 'name' },
                { text: 'Unidad', value: 'unit_type_text' },
                { text: 'Tipo', value: 'supply_type_descrip' },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            nutrientHeaders: [
                { text: 'Nutriente', value: 'label' },
                { text: 'Valor', value: 'value', width:100 },
            ],

            dataItems: { meta: {}, data: [] },

            meta: { supply_types: [], unit_types: [], nutrient_columns: [] },
        }
    },

    computed: {

    },

    mounted() {
        this.getMeta();
        this.getItems();
    },

    methods: {
        async openForm(item = null) {
            this.form.clear()
            this.form.reset()
            if (item !== null) {
                try {
                    const { data }  = await this.form.get(`/${this.resource}/${item.id}`)
                    this.form.fill(data)
                } catch (error) {
                    this.$toast(error.message, 'danger')
                    return
                }
            }else {
                this.form.nutrients = this.meta.nutrient_columns.map(nc => {
                    let value = 0
                    return {
                        'label': nc.label,
                        'column': nc.column,
                        'value': value,
                    }
                })
            }

            this.dialog = true
        },

        closeForm() {
            this.dialog = false
        },

        async getMeta() {
            try {
                const params = { service: `get-meta-crud-supplies` }
                const {data} = await this.form.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(error.message, 'danger')
            }
        },

        async getItems( page=1 ) {
            try {
                const params = {
                    page: page,
                    search: this.filter.search
                }

                this.loading = true
                const { data }  = await this.form.get(`/${this.resource}`, {params})
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
                const itemIndex = this.dataItems.data.findIndex(x => x.id===this.form.id)

                if( action==='delete' && !confirm("¿Realmente desea eliminar el registro?") ){
                    this.dialog = false
                    return
                }

                const { data } = await this.form.req(`/${this.resource}`, action)

                if (action === 'create') {
                    this.filter.search=null
                    this.getItems()
                }
                if (action === 'edit') {
                    this.dataItems.data.splice(itemIndex, 1, data)
                    this.$toast('registro actualizado!', 'success')
                }
                if (action === 'delete') {
                    this.filter.search=null
                    this.getItems()
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