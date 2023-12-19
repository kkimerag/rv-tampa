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
    },
    data() {
        return {

        };
    },
  
    mounted() {
        this.createReservation();
    },    

    create(){

    },

    methods: {
        createReservation(){
            // console.log(this.reservEnd);
            axios
            .post('/api/reservations/create' , {
                renter_name: this.userData[0],
                renter_last_name: this.userData[1], 
                email_address: this.userData[2], 
                phone_number: this.userData[3],
                reservation_start_date: this.reservStart,
                reservation_end_date:this.reservEnd, 
                delivery_address: this.deliveryAddress,
            })
            .then(response => {
                console.log(response.data);  
            })
            .catch();
        },
    },
};
</script>
