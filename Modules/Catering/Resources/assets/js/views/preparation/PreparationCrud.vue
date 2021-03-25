<template>
    <div>
        <!-- Form -->
        <v-dialog
            v-model="dialog"
            scrollable
            persistent
            max-width="600"
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
                        <!-- preparation_type_id -->
                        <v-col cols="12" sm="6">
                            <v-select dense outlined
                                v-model="form.preparation_type_id"
                                :items="meta.preparation_types"
                                label="Tipo de preparacion*"
                                item-value="id"
                                item-text="descrip"
                                hide-details="auto"
                                :error="form.errors.has('preparation_type_id')"
                                :error-messages="form.errors.get('preparation_type_id')"
                            ></v-select>
                        </v-col>

                        <!-- descrip -->
                        <v-col cols="12" sm="6">
                            <v-text-field outlined dense
                                v-model="form.descrip"
                                label="Descripcion*"
                                hide-details="auto"
                                :error="form.errors.has('descrip')"
                                :error-messages="form.errors.get('descrip')"
                            ></v-text-field>
                        </v-col>

                        <!-- preparation_details -->
                        <v-col cols="12" sm="12">
                            <v-card>
                                <v-toolbar class="elevation-1">
                                    <v-autocomplete dense single-line
                                        ref="autocompleteSupply"
                                        v-model="searchedSupply"
                                        :items="orderedSupplies"
                                        label="Agregar insumo"
                                        item-text="name"
                                        return-object
                                        hide-details="auto"
                                        @change="addSupply"
                                    ></v-autocomplete>
                                </v-toolbar>

                                <v-data-table dense
                                    :headers="supplyHeaders"
                                    :items="form.preparation_details"
                                    disable-sort
                                    disable-pagination
                                    hide-default-footer
                                >
                                    <!-- quantity -->
                                    <template v-slot:[`item.amount`]="{ item, index }">
                                        <v-text-field dense type="number" min="0"
                                            v-model="item.amount"
                                            :suffix="item.unit_abrev"
                                            hide-details="auto"
                                            :error="form.errors.has(`preparation_details.${index}.amount`)"
                                            :title="form.errors.has(`preparation_details.${index}.amount`)? form.errors.get(`preparation_details.${index}.amount`): null"
                                        ></v-text-field>
                                    </template>

                                    <template v-slot:[`item.action`]="{ item, index }">
                                        <v-icon
                                            small
                                            class="mr-2"
                                            @click="removeSupply(item, index)"
                                        >
                                            mdi-delete
                                        </v-icon>
                                    </template>
                                </v-data-table>

                                <small class="error--text px-3"
                                    v-if="form.errors.has('preparation_details')"
                                    v-html="form.errors.get('preparation_details')"
                                ></small>
                            </v-card>
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
                ></v-text-field>
            </v-card-title>

            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="6">
                        <v-select dense outlined
                            v-model="filter.warehouse"
                            :items="meta.warehouses"
                            label="Almacen*"
                            item-value="id"
                            item-text="name"
                            hide-details="auto"
                            return-object
                            clearable
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select dense outlined
                            v-model="filter.preparation_type"
                            :items="meta.preparation_types"
                            label="Categoria*"
                            item-value="id"
                            item-text="descrip"
                            hide-details="auto"
                            return-object
                            clearable
                        ></v-select>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-data-table
                :headers="headers"
                :items="filteredItems"
                :loading="loading"
                :search="filter.search"
            >
                <template v-slot:[`item.roles`]="{ item }">
                    {{ item.roles.map( r => r.name).toString() }}
                </template>
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
            icon: 'mdi-cash-register',
            resource: 'catering/preparations',
            title: 'Preparaciones',
            titleForm: 'Preparacion',
            dialog: false,
            loading: false,
            saving: false,
            searchedSupply: null,

            filter: {
                warehouse: null,
                preparation_type: null,
                search: null,
            },

            form: new Form({
                id: null,
                descrip: null,
                preparation_type_id: null,
                warehouse_id: null, 
                preparation_details: [],
            }),

            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Descripcion', value: 'descrip' },
                { text: 'Tipo', value: 'preparation_type.descrip' },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            supplyHeaders: [
                { text: 'Insumo', value: 'supply_name' },
                { text: 'Cantidad', value: 'amount', width: "150" },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            items: [],

            meta: { preparation_types: [], supplies: [], units: [], warehouses: [] },
        }
    },

    computed: {
        orderedSupplies() {
            return this.meta.supplies.sort((a, b) => a.name.localeCompare(b.name) );
        },

        filteredItems() 
        {
            return this.items.filter( item => {
                let matchType = this.filter.preparation_type==null? true: this.filter.preparation_type.id===item.preparation_type_id
                let matchWarehouse = this.filter.warehouse==null? true: this.filter.warehouse.id===item.warehouse_id
                return matchType && matchWarehouse
            })
        }
    },

    mounted() {
        this.getMeta();
        this.getItems();
    },

    methods: {

        getUnitDefault( unitType ){
            //1: unidad, 2: kilo, 3: litro
            let unitDefault = JSON.stringify(this.meta.units.find(x => x.id==unitType))
            return unitDefault==null? {}: JSON.parse(unitDefault)
        },

        addSupply(){
            const foundSupply = this.form.preparation_details.find(pd => pd.supply_id === this.searchedSupply.id)

            if( typeof foundSupply !== 'undefined') {
                this.$refs['autocompleteSupply'].reset();
                this.$toast('EL insumo ya ha sido agregado', 'warning', 1000)
                return
            }

            const newSupply = JSON.parse(JSON.stringify(this.searchedSupply))

            const baseUnit = this.getUnitDefault(newSupply.unit_type)

            this.form.preparation_details.push({
                supply_name: newSupply.name,
                supply_id: newSupply.id,
                unit_id: baseUnit.id,
                unit_abrev: baseUnit.abrev,
                amount: 0,
            })
            this.$refs['autocompleteSupply'].reset();
        },

        removeSupply(supply, index) {
            // const index = this.form.preparation_supplies.find( ps => ps.supply_id === supply.id)
            this.form.preparation_details.splice(index, 1)
        },

        openForm(item = null) {
            this.form.clear()
            this.form.reset()
            if (item !== null) {
                this.form.fill(JSON.parse(JSON.stringify(item)))
            }else {
                if( !this.filter.warehouse ){
                    this.$toast('Seleccione un almacen', 'warning')
                    return;
                }
                this.form.warehouse_id = this.filter.warehouse.id;
            }
            this.dialog = true
        },

        closeForm() {
            this.dialog = false
        },

        async getMeta() {
            try {
                const params = { service: `get-meta-crud-preparations` }
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