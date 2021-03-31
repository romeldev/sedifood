<template>
    <v-card>
            <v-card-title>
                <v-icon left>{{icon}}</v-icon>
                {{ title }}
                <v-btn x-small fab elevation="1"
                    class="ml-3"
                    color="primary" 
                    
                    @click="generateReport()"
                ><v-icon>mdi-printer</v-icon></v-btn>

                <v-spacer></v-spacer>
                

            </v-card-title>

            <v-card-text>
                <v-row>
                    <v-col cols="12" sm="4">
                        <v-select dense outlined
                            v-model="filter.warehouse"
                            :items="warehouses"
                            label="Almacen*"
                            item-value="id"
                            item-text="name"
                            hide-details="auto"
                            return-object
                            clearable
                        ></v-select>
                    </v-col>

                    <v-col cols="12" sm="4">
                        <v-select dense outlined
                            v-model="filter.preparationType"
                            :items="preparationTypes"
                            label="Tipo Preparation*"
                            item-value="id"
                            item-text="descrip"
                            hide-details="auto"
                            return-object
                            clearable
                        ></v-select>
                    </v-col>

                    <v-col cols="12" sm="4">
                        <v-select dense outlined
                            v-model="filter.preparation"
                            :items="preparations"
                            label="Preparacion*"
                            item-value="id"
                            item-text="descrip"
                            hide-details="auto"
                            return-object
                            clearable
                        ></v-select>
                    </v-col>

                </v-row>
            </v-card-text>
        </v-card>
</template>

<script>
export default {
    data() {
        return {
            title: 'Preparaciones',
            icon: 'mdi-cash-register',
            form: new Form(),
            
            filter: { warehouse: null, preparationType: null, preparation: null },

            meta: { warehouses: [], preparation_types: [], preparations: [] },
        }
    },

    mounted() {
        this.getMeta()
    },

    watch: {
        'filter.preparationType': function() {
            this.preparation = null
        }
    },

    computed: {
        warehouses() {
            return this.meta.warehouses
        },
        preparationTypes() {
            return this.meta.preparation_types
        },
        preparations() {
            if( this.filter.preparationType ){
                return this.meta.preparations.filter(p => p.preparation_type_id === this.filter.preparationType.id )
                .sort((a, b) => a.descrip.localeCompare(b.descrip) );
            }
            return []
        },
    },

    methods: {
        async getMeta() {
            try {
                const params = { service: `get-meta-stats-preparation-content` }
                const {data} = await this.form.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(params.service, 'danger')
            }
        },

        generateReport() {
            if(!this.filter.warehouse) {
                this.$toast('Seleccione una almacen', 'warning')
                return
            }
            if(!this.filter.preparation) {
                this.$toast('Seleccione una preparacion', 'warning')
                return
            }

            let routeData = this.$router.resolve({path: '/report/preparation-content', query: {
                warehouse_id: this.filter.warehouse.id,
                preparation_type_id: this.filter.preparationType.id,
                preparation_id: this.filter.preparation.id,
            }});

            window.open(routeData.href, '_blank');
        },
    }
}
</script>

<style>

</style>