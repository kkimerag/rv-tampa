<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Our RVs" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Our RVs</h2>
        </template>

        

        <v-row justify='center'>
            <v-col cols='10'>
                <v-row>
                    <v-col> Back </v-col>
                </v-row>
                <v-row>
                    <v-col cols='8'>
                        <v-sheet color='blue-lighten-5' class='px-2 py-2'> 
                            <v-icon>mdi-shield-star-outline</v-icon>
                            <span class="font-semibold">Worry-Free Rental Guarantee </span>
                            <span class="text-xs">Book safely and securely and rent worry-free. </span>
                        </v-sheet>
                    </v-col>
                    <v-col cols='4'>
                        <v-sheet class='px-2 py-2'>
                        <v-icon>mdi-phone-in-talk-outline</v-icon>
                        <span class="text-xs mx-2">For Booking Assistance, call 24/7</span>
                        <span class="font-semibold text-xs">(813) 365-1418</span>
                    </v-sheet>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols='12' md='8'>
                        <v-expansion-panels v-model='expandedPanel' variant="popout" class="my-4">
                            <v-expansion-panel :value="1">
                                <v-expansion-panel-title>
                                Begin your booking
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <UserDataComponent 
                                    :expanded_panel='expandedPanel'
                                    :user_data = 'userData'
                                    >
                                    </UserDataComponent>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel :value="2">
                                <v-expansion-panel-title>
                                Tell the owner about your trip
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                <v-row>
                                    <v-col>
                                        <DeliveryDataComponent
                                        :expanded_panel='expandedPanel'
                                        :vessel_data = 'vessel'
                                        >
                                            
                                        </DeliveryDataComponent>
                                    </v-col>
                                </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel>
                                <v-expansion-panel-title>
                                Choose security deposit option
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                Some content
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel>
                                <v-expansion-panel-title>
                                Choose security deposit option
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                Confirm & Pay
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-col>
                    <v-col cols='4' class='d-none d-md-inline'>Reservationdata</v-col>
                </v-row>

            </v-col>
        </v-row>
        
    </GuestLayout>
</template>

<script>
import UserDataComponent     from './sub_components/UserDataComponent.vue';
import DeliveryDataComponent from './sub_components/DeliveryDataComponent.vue';
export default {
    props: {
        vessel_id: String
    },
  data() {
    return {
        vessel:null,
        expandedPanel: [],
        userData:[],
    };
  },
  
  mounted() {
    this.getVessel();
    this.expandedPanel = [1];
    this.userData = [
     name     => null,
     lastName => null,
     email    => null,
     phone    => null,
    ];
  },

  create(){

  },

  methods: {
    getVessel(){
        this.loading = true;
        axios
        .get('/api/vessels/get-id' , {
            params:{
                id : this.vessel_id,
            }
        })
        .then(response => {
            this.vessel = response.data;
            this.loading = false;
            console.log(response.data);
        })
        .catch();
    },
  },
};
</script>

<style type="text/css">
    
</style>