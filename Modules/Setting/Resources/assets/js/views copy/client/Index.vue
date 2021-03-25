<template>
    <div>
        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6 col-md-8 form-group">
                        <h3 class="card-title">
                            <i :class="icon"></i>
                            {{ $tnc(resource,1) }}
                            <a href="" class="badge badge-primary" @click.prevent="openClientForm()">
                                <i class="fa fa-plus"></i> {{ $tnu('new') }}
                            </a>
                        </h3>
                    </div>
                    
                    <div class="col-sm-6 col-md-4">
                        <div class="row">
                            <div class="col-sm-12 form-group mb-0">
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    :placeholder="$tnc('search')"
                                    v-model="search"
                                    v-on:keyup.enter="getItems()"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-sm table-hover mb-0 ">
                    <thead>
                        <tr>
                            <th>{{ $t('#') }}</th>
                            <th>{{ $tnc('doc') }}</th>
                            <th>{{ $tnc('num') }}</th>
                            <th>{{ $tnc('name') }}</th>

                            <!-- <th>{{ $tnc('phone') }}</th> -->
                            <!-- <th>{{ $tnc('email') }}</th> -->
                            <th>{{ $tnc('zipcode') }}</th>
                            <!-- <th>{{ $tnc('address') }}</th> -->
                            <th width="80">
                                {{ $tnc('action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in dataItems.data" :key="key">
                            <td>{{ parseInt(key)+1 }}</td>
                            <td>{{ item.iddoc.name_short }}</td>
                            <td>{{ item.iddoc_num }}</td>
                            <td>{{ item.tradename? item.tradename: item.fullname }}</td>
                            <!-- <td>{{ item.phones }}</td> -->
                            <!-- <td>{{ item.email }}</td> -->
                            <td>{{ item.zipcode }}</td>
                            <!-- <td>{{ item.address }}</td> -->
                            <td class="text-center">
                                <a href="#"
                                    class="btn btn-xs btn-outline-info" 
                                    @click.prevent="openClientForm(item)"
                                >
                                    <i class="fa fa-edit fa-fw"></i>    
                                </a>    
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <pagination :data="dataItems" size="small" align="right" :limit="5"
                        @pagination-change-page="getItems" class="mb-0"></pagination>
            </div>
        </div>

        <ClientForm ref="clientForm" @submited="handleClientForm" />
    </div>
</template>

<script>
import ClientForm from './components/ClientForm'
export default {
    components: { ClientForm },
    data () {
        return {
            icon: 'fas fa-fw fa-users',
            resource: 'client',
            search: '',
            loading: false,
            form: new Form({}),

            dataItems: { data: [] },
        }
    },

    computed: {
        
    },


    mounted() {
        this.getItems()
        // this.openClientForm()
    },

    methods: {

        openClientForm( item=null) {
            this.$refs.clientForm.form.id = item? item.id: null
            this.$refs.clientForm.dialog = true
        },

        handleClientForm(data) {
            this.getItems()
            this.$refs.clientForm.dialog = false
        },

        async getMeta() {
            const params = { service: `get-meta-crud-${this.resource}` }
            const data = await this.form.get(`/common`, {params})
            if( data != null ) this.meta = data
        },


        async getItems( page=1 ) {
            this.loading = true
            const params = { page: page, search: this.search }
            const data = await this.form.get(`/${this.resource}s`, {params})
            this.loading = false
            if (data !== null){
                this.dataItems = data
            }
        },
    },

}
</script>