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
                            :title="pendingRes.renter_name"
                            :subtitle="pendingRes.delivery_address"
                            >
                                <template v-slot:prepend>
                                  <v-avatar color="grey-lighten-1">
                                    <v-icon color="white">mdi-folder</v-icon>
                                  </v-avatar>
                                </template>
                                <v-list-item-sub-header>{{ pendingRes.reservation_start_date }}</v-list-item-sub-header>
                                <template v-slot:append>
                                  <v-btn
                                    color="grey-lighten-1"
                                    icon="mdi-cash-multiple"
                                    variant="text"
                                    @click = 'collectAllPendingCarges(pendingRes.bill.customer_id , pendingRes.bill.charges )'
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
                    this.pendingPayReserv = response.data;
                    console.log(response.data);
                })
                .catch();
            },
            collectAllPendingCarges(customerId , charges){
                charges.forEach((charge, index) => {
                    if(charge.payment_id == null){
                        const amount = charge.amount;
                        this.getFinalCharges(customerId , amount , charge.id);
                    }
                });
            },
            getFinalCharges(customerId , amount, chargeId){
                //this function should ru forEach pending charge on the bill of the reservation
                axios
                .post('/api/reservations/collect-final-charges' , {
                    customer_id: customerId,
                    amount : amount,
                    charge_id: chargeId
                })
                .then(response=>{
                    console.log(response.data);
                    return response.data; 
                })
                .catch();
            }
        }
    };
</script>