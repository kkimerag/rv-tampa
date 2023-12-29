<template>
    <v-row v-if="paymentData">
        <v-col>
            <StripePayForm
            :paymentSecret      = "paymentData.client_secret"
            :publishableKey     = "publishableKey"
            :connectedAccountId = "connectedAccountId"
            >
                
            </StripePayForm>
        </v-col>
    </v-row>
    <v-row v-else>
        <v-col>
            <v-progress-linear
                indeterminate
                color="teal"
            ></v-progress-linear>
        </v-col>
    </v-row>
</template>

<script>
import StripePayForm from '@/Components/others/stripePayForm.vue';

export default {
    props: {
        userData:        Array,
        vesselId:        Number,
        reservStart:     String,
        reservEnd:       String,
        deliveryAddress: String,
        reservationId:   Number,
        totalPrice:      Number,
        dueNow:          Number,
        dueLater:        Number,
        selectedAddons:  Array,
    },
    emits: ['updateReservation'],
    data() {
        return {
            readyToBook:false,
            paymentData:null,
            publishableKey:null,
            connectedAccountId: null,
        };
    },
    components: {
        StripePayForm,
      },
    mounted() {
        console.log("Due Now-------");
        console.log(this.dueNow);
        console.log("Due Now-------");
        this.getPublishableKey();
        this.checkData();
        if( 
            // (!this.reservationId) && 
            (this.readyToBook)
            // true 
            ){
            this.createReservation();
        }else{
            console.log("Reservation present or missing data");
        }
    },    

    create(){

    },

    methods: {
        getPublishableKey(){
          axios
          .get('/api/payments/get-publishable-key')
          .then(response => {
            this.publishableKey = response.data;
          })
        },
        checkData(){
            if( 
                (this.userData.length!=0) && 
                (this.vesselId) && 
                (this.reservStart) && 
                (this.reservEnd) && 
                (this.deliveryAddress) 
            ){
                this.readyToBook=true;
            }else{
                this.readyToBook=false;
            }
        },
        createReservation(){
            axios
            .post('/api/reservations/create' , {
                renter_name            : this.userData[0],
                renter_last_name       : this.userData[1], 
                email_address          : this.userData[2], 
                phone_number           : this.userData[3],
                reservation_start_date : this.reservStart,
                reservation_end_date   :this.reservEnd, 
                delivery_address       : this.deliveryAddress,
                vessel_id              : this.vesselId,
                selected_addons        : this.selectedAddons
            })
            .then(response => {
                console.log(this.selectedAddons);
                this.emitReservation(response.data.id);
                this.createBillForReservation(response.data.id);
                // this.reservationId =  response.data.id;
            })
            .catch();
        },
        createBillForReservation(reservationID){
            axios
            .post('/api/bills/create-bill-for-reservation',{
                renter_full_name: this.userData[0] +" "+ this.userData[1],
                email_address          : this.userData[2],
                reservation_id: reservationID,
                price: this.totalPrice,
                charge_now_amount: this.dueNow,
                charge_later_amount: this.dueLater,
                charge_now_date: this.getToday(),
                charge_later_date: this.reservStart,
            })
            .then(response=>{
                // this.paymentIntent(response.data);
                console.log(response.data);
                this.paymentData        = response.data['paymentIntent'];
                this.connectedAccountId = response.data['accountId'] 
            })
            .catch();
        },
        getToday(){
            // Create a new Date object
            var today = new Date();

            // Get the current date
            var day = today.getDate();
            var month = today.getMonth() + 1; // Months are zero-based, so we add 1
            var year = today.getFullYear();

            // Format the date as a string (optional)
            var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);

            console.log(formattedDate);
            return formattedDate;
        },
        /*paymentIntent(billData){
          axios
          .post('/api/payments/create-stripe-payment-intent',{
            bill_id    : billData.id,
            bill_price : billData.price,
            account_id : this.accountId,
            gallery_id : this.selectedGallery
          })
          .then(response=>{
            this.paymentData = response.data
            console.log(this.paymentData);
          })
          .catch();
        },*/
        emitReservation(newReservationId){
            this.$emit('updateReservation', newReservationId);
        },
    },
};
</script>
