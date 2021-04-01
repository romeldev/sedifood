<template>
    <v-app dark>
        <Alert/>

        <!-- menu -->
        <v-navigation-drawer
            v-model="drawer"
            :mini-variant="miniVariant"
            :clipped="clipped"
            fixed
            app
        >

            <template v-slot:prepend>
                <v-list-item two-line>
                    <v-list-item-avatar>
                        <img :src="$store.getters.avatar">
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{ $store.getters.username }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>

            <v-divider></v-divider>
      
            <v-list dense nav>
                <template v-for="(item, key) in $store.getters.menu">
                    <v-list-item v-if="!(Array.isArray(item.children) && item.children.length>0)"
                        :key="key"
                        :to="item.path"
                        router
                        exact
                        link
                        
                    >
                        <v-list-item-icon>
                            <v-icon >{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.name" />
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group v-else
                        :value="false"
                        :key="key"
                        :prepend-icon="item.icon"
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title v-text="item.name" />
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="(subitem, i) in item.children"
                            :key="i"
                            :to="subitem.path"
                            router
                            exact
                            link
                        >
                            <v-list-item-icon>
                                <v-icon v-text="subitem.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="subitem.name" />
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                </template>
            </v-list>

            <template v-slot:append>
                <v-list dense nav>
                    <v-list-item link @click="logout" class="primary" dark >
                        <v-list-item-icon>
                            <v-icon>mdi-logout</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>Salir</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>

        <v-app-bar
            :clipped-left="clipped"
            fixed
            app
            elevation="1"
            color="primary"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
                <!-- <v-btn
                    icon
                    @click.stop="miniVariant = !miniVariant"
                >
                    <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
                </v-btn> -->

                <!-- <v-btn
                    icon
                    @click.stop="clipped = !clipped"
                >
                    <v-icon>mdi-application</v-icon>
                </v-btn> -->
                <!-- <v-btn
                    icon
                    @click.stop="fixed = !fixed"
                >
                    <v-icon>mdi-minus</v-icon>
                </v-btn> -->
            <v-toolbar-title>
                <v-btn text @click="goHome()">
                    {{ $store.getters.appName }}
                </v-btn>
            </v-toolbar-title>
            <v-spacer />
            <!-- <v-btn
                icon
                @click.stop="rightDrawer = !rightDrawer"
            >
                <v-icon>mdi-menu</v-icon>
            </v-btn> -->

            <v-list-item-avatar>
                <img :src="$store.getters.appLogo">
            </v-list-item-avatar>
        </v-app-bar>

        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-navigation-drawer
            v-model="rightDrawer"
            :right="right"
            temporary
            fixed
        >
            <v-list>
                <v-list-item @click.native="right = !right">
                <v-list-item-action>
                    <v-icon light>
                    mdi-repeat
                    </v-icon>
                </v-list-item-action>
                <v-list-item-title>Switch drawer (click me)</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-footer
            :absolute="!fixed"
            app
        >
            <span>&copy; {{ new Date().getFullYear() }}</span>
        </v-footer>
    </v-app>
</template>

<script>
import Alert from '@/components/Alert'
export default {
    components: { Alert },
    data () {
        return {
            clipped: false,
            drawer: false,
            fixed: false, //foot fixed
            
            miniVariant: false,
            right: true,
            rightDrawer: false,

            menu: [],
        }
    },

    mounted() {
        // console.log('menu', this.$store.getters.menu)
    },

    methods: {

        goHome() {
            if( this.$router.currentRoute.path!=='/' && this.$router.currentRoute.path!=='/home'){
                this.$router.push('/')
            }
        },

        async logout() {
            try {
                const res = await axios.post('/api/logout')
            } catch (error) {
                console.log('error logout', error.message)
            } finally {
                this.$store.dispatch('user/resetValues')
                this.$router.push('/login')
            }
        }
    }
}
</script>

<style>
[b1], .b1 { border: 1px dashed red; }

.list__tile {
    height: auto;
    min-height: 48px;
}

.list__tile__title {
    white-space: normal !important;
    text-overflow: wrap !important;
    word-wrap: break-word;
}
</style>