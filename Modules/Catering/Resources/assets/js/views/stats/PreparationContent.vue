<template>
    <v-card>
        <v-card-title>
            <v-icon left>{{icon}}</v-icon>
            {{ title }}
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
                        :error="filter.errors.has('warehouse_id')"
                        :error-messages="filter.errors.get('warehouse_id')"
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
                        :error="filter.errors.has('preparation_type_id')"
                        :error-messages="filter.errors.get('preparation_type_id')"
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
                        :error="filter.errors.has('preparation_id')"
                        :error-messages="filter.errors.get('preparation_id')"
                    ></v-select>
                </v-col>

            </v-row>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text color="success" @click="generateReport()">
                Generar
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    data() {
        return {
            icon: 'mdi-tag',
            title: 'Prepararacion - Contenido Nutricional',
            resource: 'catering/report/preparation-content',

            filter: new Form({ warehouse: null, preparationType: null, preparation: null }),

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
                const {data} = await this.filter.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(params.service, 'danger')
            }
        },

        async generateReport() {
            try {
                const params = { 
                    warehouse_id: this.filter.warehouse? this.filter.warehouse.id: null,
                    preparation_type_id: this.filter.preparationType? this.filter.preparationType.id: null,
                    preparation_id : this.filter.preparation? this.filter.preparation.id: null,
                    reportname: 'nc_preparation',
                }

                const {data} = await this.filter.get(`/${this.resource}`, {params})
                let routeData = this.$router.resolve({path: `/api/catering/report/generate/${data.reportname}`, query: data.params });
                window.open(routeData.href, '_blank');
            } catch (error) {
                this.$toast(params.service, 'danger')
            }
        },
    }
}
</script>

<style>

</style>