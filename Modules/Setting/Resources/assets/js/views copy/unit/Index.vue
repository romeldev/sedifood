<template>
    <v-row>
        <v-col cols="12">
            <UnitCrud ref="unitCrud" @submited="handleUnitCrud" />
        </v-col>
        <!-- <v-col cols="12">
            <PresentationCrud ref="presentationCrud"/>
        </v-col> -->
    </v-row>
</template>

<script>
import UnitCrud from './UnitCrud'
import PresentationCrud from './PresentationCrud'
export default {
    components: { UnitCrud, PresentationCrud },
    data () {
        return {

        }
    },

    mounted() {

    },

    methods: {
        handleUnitCrud(data) {
            console.log('handleUnitCrud', data)
            //actualizar meta para presentaciones
        }
    },

}
</script>