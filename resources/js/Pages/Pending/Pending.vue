<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Pending" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pending</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <v-row v-if='pendingPayReserv.lenght==0'>
                        <v-col>
                            <v-progress-linear
                                  indeterminate
                                  color="teal"
                            ></v-progress-linear>
                        </v-col>
                    </v-row>
                    <v-row v-else>
                        <v-col>
                            <v-list-item
                            v-for="pendingRes in pendingPayReserv"
                            :key="pendingRes.id"
                            :title="pendingRes.title"
                            :subtitle="pendingRes.subtitle"
                            >
                                <template v-slot:prepend>
                                  <v-avatar color="grey-lighten-1">
                                    <v-icon color="white">mdi-folder</v-icon>
                                  </v-avatar>
                                </template>

                                <template v-slot:append>
                                  <v-btn
                                    color="grey-lighten-1"
                                    icon="mdi-information"
                                    variant="text"
                                  ></v-btn>
                                </template>
                            </v-list-item>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script type="text/javascript">
    export default{
        data () {
            return {
                pendingPayReserv: [],
            }
        },
        mounted(){
            this.fetchPending();
        },
        methods:{
            fetchPending(){
                axios
                .get('/api/reservations/get-pendings' )
                .then(response=>{
                    console.log(response.data);
                })
                .catch();
            },
        }
    };
</script>