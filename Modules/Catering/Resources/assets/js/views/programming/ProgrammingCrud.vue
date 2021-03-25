<template>
    <div>
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
                        <v-col cols="12" sm="6">
                            <v-row>
                                <!-- date -->
                                <v-col cols="12">
                                    <v-text-field outlined dense type="date"
                                        v-model="form.date"
                                        label="Fecha*"
                                        hide-details="auto"
                                        :error="form.errors.has('date')"
                                        :error-messages="form.errors.get('date')"
                                    ></v-text-field>
                                </v-col>

                                <!-- professional_id -->
                                <v-col cols="12">
                                    <v-select dense outlined
                                        v-model="form.professional_id"
                                        :items="meta.professionals"
                                        label="Profesional*"
                                        item-value="id"
                                        item-text="fullname"
                                        hide-details="auto"
                                        :error="form.errors.has('professional_id')"
                                        :error-messages="form.errors.get('professional_id')"
                                    ></v-select>
                                </v-col>

                                <!-- regime_id -->
                                <v-col cols="12">
                                    <v-select dense outlined
                                        v-model="form.regime_id"
                                        :items="meta.regimes"
                                        label="Regimen*"
                                        item-value="id"
                                        item-text="descrip"
                                        hide-details="auto"
                                        :error="form.errors.has('regime_id')"
                                        :error-messages="form.errors.get('regime_id')"
                                    ></v-select>
                                </v-col>

                                <!-- food_type_id -->
                                <v-col cols="12">
                                    <v-select dense outlined
                                        v-model="form.food_type_id"
                                        :items="meta.food_types"
                                        label="Tipo Comida*"
                                        item-value="id"
                                        item-text="descrip"
                                        hide-details="auto"
                                        :error="form.errors.has('food_type_id')"
                                        :error-messages="form.errors.get('food_type_id')"
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-col>

                        <!-- detail -->
                        <v-col cols="12" sm="6">
                            <v-row>
                                <v-col cols="12">
                                    <v-card>
                                        <v-toolbar class="elevation-1">
                                            <v-autocomplete dense single-line
                                                ref="autocompletePreparation"
                                                v-model="searchedPreparation"
                                                :items="orderedPreparations"
                                                label="Agregar preparacion"
                                                item-text="descrip"
                                                return-object
                                                hide-details="auto"
                                                @change="addPreparation"
                                            ></v-autocomplete>
                                        </v-toolbar>

                                        <v-data-table dense
                                            :headers="preparationHeaders"
                                            :items="form.programming_details"
                                            disable-sort
                                            disable-pagination
                                            hide-default-footer
                                        >
                                            <!-- portions -->
                                            <template v-slot:[`item.portions`]="{ item, index }">
                                                <v-text-field dense type="number" min="0"
                                                    v-model="item.portions"
                                                    hide-details="auto"
                                                    :error="form.errors.has(`programming_details.${index}.portions`)"
                                                    :title="form.errors.has(`programming_details.${index}.portions`)? form.errors.get(`programming_details.${index}.portions`): null"
                                                ></v-text-field>
                                            </template>

                                            <template v-slot:[`item.action`]="{ item, index }">
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="removePreparation(item, index)"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </v-data-table>

                                        <small class="error--text px-3"
                                            v-if="form.errors.has('programming_details')"
                                            v-html="form.errors.get('programming_details')"
                                        ></small>
                                    </v-card>
                                </v-col>
                            </v-row>
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
                        <v-text-field dense
                            type="search"
                            v-model="filter.search"
                            append-icon="mdi-magnify"
                            label="Buscar"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-data-table
                :headers="headers"
                :items="items"
                :loading="loading"
                :search="filter.search"
            >
                <template v-slot:[`item.date`]="{ item }">
                    <!-- {{ item.date | moment('timezone', 'America/Lima', 'L')}} -->
                    {{ item.date | moment('L')}}
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
            resource: 'catering/programmings',
            title: 'Programaciones',
            titleForm: 'Programacion',
            dialog: false,
            loading: false,
            saving: false,
            searchedPreparation: null,
            selectedWarehouse: null,

            filter: {
                search: null,
            },

            form: new Form({
                id: null,
                date: this.$moment().format('YYYY-MM-DD'),
                professional_id: null,
                regime_id: null,
                food_type_id: null,
                warehouse_id: null,
                programming_details: [],
            }),

            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Fecha', value: 'date' },
                { text: 'Comida', value: 'food_type_descrip' },
                { text: 'Regimen', value: 'regime_descrip' },
                { text: 'Professional', value: 'professional_fullname' },
                { text: 'Accion', value: 'action', sortable: false },
            ],

            preparationHeaders: [
                { text: 'Descripcion', value: 'preparation_descrip' },
                { text: 'Porciones', value: 'portions', width: "80", align: 'right' },
                { text: 'Accion', value: 'action', align: 'center', sortable: false },
            ],

            items: [],

            meta: { professionals: [], regimes: [], food_types: [], preparations: [], warehouses: [] },
        }
    },

    computed: {
        orderedPreparations() {
            return this.meta.preparations.sort((a, b) => a.descrip.localeCompare(b.descrip) );
        },
    },

    mounted() {
        this.getMeta();
        this.getItems();
    },

    methods: {

        addPreparation(){
            const foundPreparation = this.form.programming_details.find(pd => pd.preparation_id === this.searchedPreparation.id)

            if( typeof foundPreparation !== 'undefined') {
                this.$refs['autocompletePreparation'].reset();
                this.$toast('La preparacion ya ha sido agregado', 'warning', 1000)
                return
            }

            const newPreparation = JSON.parse(JSON.stringify(this.searchedPreparation))

            this.form.programming_details.push({
                preparation_id: newPreparation.id,
                preparation_descrip: newPreparation.descrip,
                portions: 1,
            })
            this.$refs['autocompletePreparation'].reset();
        },

        removePreparation(supply, index) {
            this.form.programming_details.splice(index, 1)
        },

        openForm(item = null) {
            this.form.clear()
            this.form.reset()
            if (item !== null) {
                this.form.fill(JSON.parse(JSON.stringify(item)))

                this.form.date = this.$moment(this.form.date).format('YYYY-MM-DD');
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
                const params = { service: `get-meta-crud-programmings` }
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
                if (error.response && error.response.status === 422) {
                    if( this.form.errors.has('prog_exists') ) this.$toast(this.form.errors.get('prog_exists'), 'danger')
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