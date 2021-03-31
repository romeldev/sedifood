<template>
    <v-card>
        <v-card-title>
            <v-icon left>{{icon}}</v-icon>
            {{ title }}
            <v-spacer></v-spacer>
        </v-card-title>

        <v-card-text>
            <v-row>
                <!-- warehouse_id -->
                <v-col cols="12" sm="4">
                    <v-select dense outlined
                        v-model="filter.warehouse"
                        :items="meta.warehouses"
                        label="Almacen*"
                        item-value="id"
                        item-text="name"
                        return-object
                        hide-details="auto"
                        :error="filter.errors.has('warehouse_id')"
                        :error-messages="filter.errors.get('warehouse_id')"
                    ></v-select>
                </v-col>
                <!-- regime_id -->
                <v-col cols="12" sm="4">
                    <v-select dense outlined
                        v-model="filter.regime"
                        :items="meta.regimes"
                        label="Regimen*"
                        item-value="id"
                        item-text="descrip"
                        return-object
                        hide-details="auto"
                        :error="filter.errors.has('regime_id')"
                        :error-messages="filter.errors.get('regime_id')"
                    ></v-select>
                </v-col>
                <!-- food_type_id -->
                <v-col cols="12" sm="4">
                    <v-select dense outlined
                        v-model="filter.food_type"
                        :items="meta.food_types"
                        label="Tipo Comida"
                        item-value="id"
                        item-text="descrip"
                        return-object
                        hide-details="auto"
                        :error="filter.errors.has('food_type_id')"
                        :error-messages="filter.errors.get('food_type_id')"
                    ></v-select>
                </v-col>

                <!-- date_from -->
                <v-col cols="12" sm="4">
                    <v-text-field outlined dense type="date"
                        v-model="filter.date_from"
                        label="Desde*"
                        hide-details="auto"
                        :error="filter.errors.has('date_from')"
                        :error-messages="filter.errors.get('date_from')"
                    ></v-text-field>
                </v-col>

                <!-- date_to -->
                <v-col cols="12" sm="4">
                    <v-text-field outlined dense type="date"
                        v-model="filter.date_to"
                        label="Hasta*"
                        hide-details="auto"
                        :error="filter.errors.has('date_to')"
                        :error-messages="filter.errors.get('date_to')"
                    ></v-text-field>
                </v-col>

                <!-- report -->
                <v-col cols="12" sm="4">
                    <v-select dense outlined
                        v-model="filter.report"
                        :items="meta.reports"
                        label="Reporte*"
                        item-value="reportname"
                        item-text="label"
                        return-object
                        hide-details="auto"
                        :error="filter.errors.has('reportname')"
                        :error-messages="filter.errors.get('reportname')"
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
            title: 'Contenido Nutricional',
            resource: 'catering/report/nutritional-content',

            filter: new Form({
                warehouse: null,
                regime: null,
                food_type : null,
                date_from: this.$moment().format('YYYY-MM-DD'),
                date_to: this.$moment().format('YYYY-MM-DD'),
                report: null,
            }),

            meta: { warehouses: [], reports: [], regimes: [], food_types: [] }
        }
    },

    mounted() {
        this.getMeta()
    },

    methods: {
        async getMeta() {
            try {
                const params = { service: `get-meta-report-nutritional-content` }
                const {data} = await this.filter.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(error.message, 'danger')
            }
        },

        async generateReport()
        {
            try {
                const params = { 
                    warehouse_id: this.filter.warehouse? this.filter.warehouse.id: null,
                    regime_id: this.filter.regime? this.filter.regime.id: null,
                    food_type_id : this.filter.food_type? this.filter.food_type.id: null,
                    date_from: this.filter.date_from,
                    date_to: this.filter.date_to,
                    reportname: this.filter.report? this.filter.report.reportname: null,
                }

                const {data} = await this.filter.get(`/${this.resource}`, {params})
                console.log(data.reportname)
                let routeData = this.$router.resolve({path: `/api/catering/report/generate/${data.reportname}`, query: data.params });
                window.open(routeData.href, '_blank');
            } catch (error) {
                this.$toast(error.message, 'danger')
            }
        }

    }
}
</script>

<style>

</style>