<template>
    <div>
        NutritionalContent
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