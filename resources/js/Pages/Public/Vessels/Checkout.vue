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
                    <v-col> Back</v-col>
                </v-row>
                <v-row>
                    <v-col cols='12' md='8'>
                        <v-sheet color='blue-lighten-5' class='px-2 py-2'> 
                            <v-icon>mdi-shield-star-outline</v-icon>
                            <span class="font-semibold">Worry-Free Rental Guarantee </span>
                            <span class="text-xs">Book safely and securely and rent worry-free. </span>
                        </v-sheet>
                        <v-expansion-panels v-model='expandedPanel' variant="popout" class="my-4">
                            <v-expansion-panel :value="1" >
                                <v-expansion-panel-title expand-icon="mdi-plus" collapse-icon="mdi-minus">
                                    <v-icon v-if="userData.length>0 && expandedPanel>1">mdi-check-circle-outline</v-icon>
                                    <v-icon v-else>mdi-numeric-1-circle-outline</v-icon>

                                Begin your booking
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <UserDataComponent 
                                    :expanded_panel='expandedPanel'
                                    @updateExpandedPanel="updateExpandedPanel($event)"
                                    :user_data = 'userData'
                                    @updateUserData="updateUserData($event)"
                                    >
                                    </UserDataComponent>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel :value="2" :disabled = "!deliveryFee">
                                <v-expansion-panel-title expand-icon="mdi-plus" collapse-icon="mdi-minus">
                                    <v-icon v-if="deliveryFee && expandedPanel>2">mdi-check-circle-outline</v-icon>
                                    <v-icon v-else>mdi-numeric-2-circle-outline</v-icon>
                                Tell the owner about your trip
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                <v-row>
                                    <v-col>
                                        <div>
                                        <DeliveryDataComponent
                                        :expanded_panel='expandedPanel'
                                        @updateExpandedPanel="updateExpandedPanel($event)"
                                        :vessel_data = 'vessel'
                                        @updateDeliveryFee="updateDeliveryFee($event)" 
                                        @updateDeliveryAddress="updateDeliveryAddress($event)"
                                        >
                                            
                                        </DeliveryDataComponent>
                                    </div>
                                    </v-col>
                                </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel :value="3" :disabled = "!deposit">
                                <v-expansion-panel-title expand-icon="mdi-plus" collapse-icon="mdi-minus">
                                    <v-icon v-if="deposit && expandedPanel>3">mdi-check-circle-outline</v-icon>
                                    <v-icon v-else>mdi-numeric-3-circle-outline</v-icon>
                                Choose security deposit option
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col>
                                            <div>
                                                <DepositDataComponent
                                                :vessel = 'vessel'
                                                :deposit = 'deposit'
                                                @updateDeposit="updateDeposit($event)"
                                                :expanded_panel='expandedPanel'
                                                @updateExpandedPanel="updateExpandedPanel($event)"
                                                >
                                                    
                                                </DepositDataComponent>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>

                            <v-expansion-panel :value="4" :disabled='expandedPanel<4'>
                                <v-expansion-panel-title expand-icon="mdi-plus" collapse-icon="mdi-minus">
                                    <v-icon v-if="deposit && expandedPanel>4">mdi-check-circle-outline</v-icon>
                                    <v-icon v-else>mdi-numeric-4-circle-outline</v-icon>
                                Add other Toys & Add-Ons
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col>
                                            <div>
                                                <AddonsDataComponent
                                                :vesselData = 'vessel'
                                                @updateSelectedAddons="updateSelectedAddons($event)"
                                                @updateExpandedPanel="updateExpandedPanel($event)"
                                                >
                                                    
                                                </AddonsDataComponent>
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>

                            <v-expansion-panel :value="5" disabled>
                                <v-expansion-panel-title expand-icon="mdi-plus" collapse-icon="mdi-minus">
                                Payment Confirmation
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                <ConfirmationPaymentComponent
                                :reservationId     ='reservationId'
                                @updateReservation ="updateReservation($event)"
                                :userData          ='userData'
                                :vesselId          ='vessel ? vessel.id : null'
                                :reservStart       ='startDateReserv'
                                :reservEnd         ='endDateReserv'
                                :deliveryAddress   ='deliveryAddress'
                                :selectedAddons    ='selectedAddons'
                                :totalPrice        = 'totalPrice'
                                :dueNow            = 'dueNow'
                                :dueLater          = 'dueLater'
                                :appURL            = 'appURL'
                                >
                                    
                                </ConfirmationPaymentComponent>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </v-col>
                    <v-col cols='4' class='d-none d-md-inline'>
                        <div>
                        <BookingDataComponent
                        :vessel_data         = 'vessel'
                        :booking_range       = 'bookingRange'
                        :delivery_fee        = 'deliveryFee'
                        :deposit             = 'deposit'
                        :holdPercent         = 'holdPercent'
                        :selectedAddons      = 'selectedAddons'
                        @updateTotalPrice    = 'updateTotalPrice'
                        @updateDueNowPrice   = 'updateDueNowPrice'
                        @updateDueLaterPrice = 'updateDueLaterPrice'
                        >
                            
                        </BookingDataComponent>
                        </div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="d-md-none">
                        <v-footer 
                        app
                        color="white"
                        elevation="20"
                        >
                            <v-row>
                                <v-col>
                                    
                                    <v-row>
                                        <v-col>
                                            <v-row>
                                                <v-col v-if="vessel">
                                                    {{vessel.rate.base_nightly_price}}/night
                                                </v-col>
                                                <v-col>
                                                    <v-btn flat @click="dialog=true">
                                                    Get details
                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                    </v-row>
                                    <v-dialog
                                          v-model="dialog"
                                          fullscreen
                                          :scrim="false"
                                          transition="dialog-bottom-transition"
                                        >
                                        <v-card>
                                            <v-toolbar
                                              dark
                                              color="primary"
                                            >
                                              
                                              <v-toolbar-title>Details</v-toolbar-title>
                                              <v-spacer></v-spacer>
                                              <v-toolbar-items>
                                               <v-btn
                                                 icon
                                                 dark
                                                 @click="dialog = false"
                                               >
                                                 <v-icon>mdi-close</v-icon>
                                               </v-btn>
                                              </v-toolbar-items>
                                            </v-toolbar>
                                            <v-card-text>
                                                    <div>
                                                    <BookingDataComponent
                                                    :vessel_data         = 'vessel'
                                                    :booking_range       = 'bookingRange'
                                                    :delivery_fee        = 'deliveryFee'
                                                    :deposit             = 'deposit'
                                                    :holdPercent         = 'holdPercent'
                                                    :selectedAddons      = 'selectedAddons'
                                                    @updateTotalPrice    = 'updateTotalPrice'
                                                    @updateDueNowPrice   = 'updateDueNowPrice'
                                                    @updateDueLaterPrice = 'updateDueLaterPrice'
                                                    >
                                                        
                                                    </BookingDataComponent>
                                                </div>
                                            </v-card-text>
                                        </v-card>
                                    </v-dialog>
                                </v-col>
                            </v-row>                            
                        </v-footer>
                    </v-col>
                </v-row> 
            </v-col>
        </v-row>
        
    </GuestLayout>
</template>

<script>
import UserDataComponent     from './sub_components/UserDataComponent.vue';
import DeliveryDataComponent from './sub_components/DeliveryDataComponent.vue';
import BookingDataComponent from './sub_components/BookingDataComponent.vue';
import AddonsDataComponent from './sub_components/AddonsDataComponent.vue';
import DepositDataComponent from './sub_components/DepositDataComponent.vue';
import ConfirmationPaymentComponent from './sub_components/ConfirmationPaymentComponent.vue';
export default {
    props: {
        vessel_id  :   String,
        holdPercent: String,
        appURL     : String,
    },
  data() {
    return {
        reservationId:null,
        vessel:null,
        expandedPanel: null,
        userData:[],
        StartDate: null,
        EndDate: null,
        bookingRange:[],
        deposit: null,
        deliveryFee: null,
        deliveryAddress:null,
        selectedAddons:[],
        totalPrice: null,
        dueNow: null,
        dueLater: null,
        dialog:false,
        startDateReserv: null,
        endDateReserv: null,
    };
  },
  components: {
      DeliveryDataComponent,
      BookingDataComponent,
      DepositDataComponent,
      AddonsDataComponent
    },
  mounted() {
    this.getVessel();
    this.getDates();
    this.expandedPanel = 1;
    this.userData = [];
    this.deliveryFee = 0;
    this.deliveryAddress='';
    this.selectedAddons = [];
    this.dueNow = 0;
    this.dueLater = 0;
    console.log(this.appURL);
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
        })
        .catch();
    },
    getDates(){
        const currentUrl = window.location.search;
        const urlParams = new URLSearchParams(currentUrl);
        const StartDate = urlParams.get('StartDate');
        const EndDate = urlParams.get('EndDate');

        this.StartDate = new Date(StartDate);
        this.EndDate = new Date(EndDate);

        this.startDateReserv = this.formatDate(this.StartDate);
        this.endDateReserv   = this.formatDate(this.EndDate);

        this.getDatesInRange();

    },
    formatDate(date) {
        const year = date.getUTCFullYear();
        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
        const day = String(date.getUTCDate()).padStart(2, '0');
        return `${year}/${month}/${day}`;
    },
    getDatesInRange() {
        const dates = [];
        let currentDate = this.StartDate;
        let endDate = this.EndDate;

        while (currentDate <= endDate) {
          dates.push(new Date(currentDate));
          currentDate.setDate(currentDate.getDate() + 1);
        }
        this.bookingRange = dates;
    },
    updateDeliveryFee(newDeliveryFee) {
      this.deliveryFee = newDeliveryFee;
    },
    updateDeliveryAddress(newDeliveryAddress) {
        this.deliveryAddress = newDeliveryAddress;
    },
    updateSelectedAddons(newSelectedAddons){
        this.selectedAddons = newSelectedAddons;
    },
    updateExpandedPanel(newExpandedPanel){
        this.expandedPanel=newExpandedPanel;
    },
    updateUserData(newUserData){
        this.userData = newUserData;
    },
    updateDeposit(newValue){
        this.deposit = newValue;
    },
    updateReservation(newReservationId){
        this.reservationId=newReservationId;
    },
    updateTotalPrice(newTotalPrice){
        this.totalPrice=newTotalPrice;
    },
    updateDueNowPrice(newDueNow){
        this.dueNow=newDueNow;
    },
    updateDueLaterPrice(newDueLater){
        this.dueLater=newDueLater;
    }
  },
};
</script>

<style type="text/css">
    
</style>