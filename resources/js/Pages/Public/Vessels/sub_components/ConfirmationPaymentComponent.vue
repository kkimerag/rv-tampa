<template>
    <v-row>
        <v-col>
            <v-sheet class='px-2 py-2'>
            <v-icon>mdi-phone-in-talk-outline</v-icon>
            <span class="text-xs mx-2">For Booking Assistance, call 24/7</span>
            <span class="font-semibold text-xs">(813) 365-1418</span>
            </v-sheet>
        </v-col>
    </v-row>

</template>

<script>
export default {
    props: {
        userData: Array,
        vesselId:        Number,
        reservStart:     String,
        reservEnd:       String,
        deliveryAddress: String,
        reservationId: Number,
    },
    emits: ['updateReservation'],
    data() {
        return {
            readyToBook:false,
        };
    },
  
    mounted() {
        this.checkData();
        if( 
            // (!this.reservationId) && 
            (this.readyToBook) 
            ){
            this.createReservation();
        }else{
            console.log("Reservation present or missing data");
        }
    },    

    create(){

    },

    methods: {
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
            console.log(this.reservationId);
        },
        createReservation(){
            axios
            .post('/api/reservations/create' , {
                renter_name: this.userData[0],
                renter_last_name: this.userData[1], 
                email_address: this.userData[2], 
                phone_number: this.userData[3],
                reservation_start_date: this.reservStart,
                reservation_end_date:this.reservEnd, 
                delivery_address: this.deliveryAddress,
                vessel_id: this.vesselId,
            })
            .then(response => {
                // console.log(response.data.id);
                this.emitReservation(response.data.id);
                this.createBillForReservation(response.data.id);
                // this.reservationId =  response.data.id;
            })
            .catch();
        },
        createBillForReservation(reservationID){
            axios
            .post('/api/bills/create-bill-for-reservation',{
                reservationId: reservationID,
                // price: 
            })
            .then(response=>{
                console.log(response.data);
            })
            .catch();
        },
        emitReservation(newReservationId){
            console.log("emiting...");
            console.log(newReservationId);
            this.$emit('updateReservation', newReservationId);
        },
    },
};
</script>
