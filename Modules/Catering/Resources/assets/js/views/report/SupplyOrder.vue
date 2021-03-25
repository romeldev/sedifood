<template>
    <div>
        report de lista de insumos
    </div>
</template>

<script>
export default {
    data() {
        return {
            meta: { warehouses: [] },
        }
    },

    mounted() {
        alert('aki')
    },

    methods: {
        async getMeta() {
            try {
                const params = { service: `get-meta-crud-programmings` }
                const {data} = await this.form.get(`/common`, {params})
                this.meta = data
            } catch (error) {
                this.$toast(params.service, 'danger')
            }
        },

    }
}
</script>

<style>

</style>