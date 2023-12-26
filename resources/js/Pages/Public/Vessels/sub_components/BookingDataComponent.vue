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
    <v-row>
        <v-col>
            <v-card v-if="vessel_data">
                <v-row>
                    <v-col>
                      <v-row no-gutters>
                          <v-col cols='8'>
                            <v-img v-if = 'vessel_data && vessel_data.vessel_images.length >= 1'
                            :src = "vessel_data.vessel_images[0].thumbnailUrl"
                            cover
                            height='30vh'
                            >
                                <template v-slot:placeholder>
                                  <v-row no-gutters
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                  >
                                    <v-progress-circular
                                      indeterminate
                                      color="grey-lighten-5"
                                    ></v-progress-circular>
                                  </v-row>
                                </template>
                            </v-img>
                            <v-img v-else
                            src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'
                            height='30vh'
                            >
                            </v-img>
                        </v-col>
                        <v-col cols='4'>
                            <v-row no-gutters>
                                <v-col cols='12'>
                                    <v-img v-if = 'vessel_data && vessel_data.vessel_images.length >= 2'
                                    :src = "vessel_data.vessel_images[1].thumbnailUrl"
                                    cover
                                    height='15vh'
                                    >
                                        <template v-slot:placeholder>
                                          <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                          >
                                            <v-progress-circular
                                              indeterminate
                                              color="grey-lighten-5"
                                            ></v-progress-circular>
                                          </v-row>
                                        </template>
                                    </v-img>
                                    <v-img v-else
                                    src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'
                                    height='15vh'
                                    >
                                    </v-img>
                                </v-col>
                            </v-row>
                            <v-row no-gutters>
                                <v-col cols='12'>
                                    <v-img v-if = 'vessel_data && vessel_data.vessel_images.length >= 3'
                                    :src = "vessel_data.vessel_images[2].thumbnailUrl"
                                    cover
                                    height='15vh'
                                    >
                                        <template v-slot:placeholder>
                                          <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                          >
                                            <v-progress-circular
                                              indeterminate
                                              color="grey-lighten-5"
                                            ></v-progress-circular>
                                          </v-row>
                                        </template>
                                    </v-img>
                                    <v-img v-else
                                    src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'
                                    height='15vh'
                                    >
                                    </v-img>
                                </v-col>
                            </v-row>
                        </v-col>
                     </v-row>
                    </v-col>
                </v-row>
                <v-card-title>
                    {{vessel_data.year}} {{vessel_data.make}} {{vessel_data.model}}
                </v-card-title>
                <v-card-subtitle>
                    {{vessel_data.location.city}}, {{vessel_data.location.state.name}} 
                </v-card-subtitle>
                <v-card-subtitle v-if='booking_range.length>0' class="mt-n1">
                    <v-row no-gutters>
                        <v-col>
                            <v-row no-gutters>
                                <v-col>Start:</v-col>
                            </v-row>
                            <v-row no-gutters class="">
                                <v-col>{{formatDate(booking_range[0])}}</v-col>
                            </v-row>
                        </v-col>
                        <v-col>
                            <v-row no-gutters>
                                <v-col>Ends:</v-col>
                            </v-row>
                            <v-row no-gutters class="">
                                <v-col>{{formatDate(booking_range[booking_range.length-1])}} </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card-subtitle>
                <v-card-text>
                    <v-row no-gutters>
                        <v-col>${{vessel_data.rate.base_nightly_price}} x {{booking_range.length-1}}</v-col>
                        <v-col>${{calculateTotalPerNight()}}</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> Cleaning Fee </v-col>
                        <v-col>${{ownFees}}</v-col>
                    </v-row>
                    <v-row no-gutters v-if="delivery_fee!=0">
                        <v-col> Delivery Fee </v-col>
                        <v-col>${{delivery_fee}}</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> Total </v-col>
                        <v-col>${{getTotal()}}</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> __________________ </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> Due dates:</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> Due Today: </v-col><v-col> ${{getDueNowAmount()}}</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> Due At {{formatDate(booking_range[0])}}:</v-col><v-col>${{getDueLaterAmount()}}</v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col> __________________ </v-col>
                    </v-row>
                    <v-row no-gutters v-if="delivery_fee!=0">
                        <v-col> Security Deposit </v-col>
                        <v-col>${{deposit}}</v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        vessel_data: Object,
        booking_range:Array,
        delivery_fee: Number,
        deposit: Number,
        holdPercent: String
    },
    emits: ['updateTotalPrice' , 'updateDueNowPrice' , 'updateDueLaterPrice'],
  data() {
    return {
        totalPrice: null,
        dueNow:null,
        dueLater:null,
        ownFees:null,
    };
  },
  
  mounted() {
    console.log(this.vessel_data);
    this.ownFees = 60;
  },

  create(){

  },

  methods: {
    getTotal(){
        this.totalPrice = this.calculateTotalPerNight()+this.ownFees+this.delivery_fee;
        this.emitTotalPrice(this.totalPrice);
        return this.totalPrice;
    },
    getDueNowAmount(){
        this.dueNow = this.getHoldingPecentage();
        this.emitDueNow(this.dueNow);
        return this.dueNow;
    },
    getDueLaterAmount(){
        this.dueLater = this.totalPrice - this.getDueNowAmount();
        this.emitDueLater(this.dueLater);
        return this.dueLater;
    },
    getHoldingPecentage(){
        // Ensure total and percentage are valid numbers
        if (isNaN(this.totalPrice) || isNaN(this.holdPercent)) {
            return "Please provide valid numbers for total and percentage.";
        }

        // Calculate the given percentage of the total
        const result = (this.holdPercent / 100) * this.totalPrice;

        return result;
    },
    formatDate(date) {
        const year = date.getUTCFullYear();
        const month = String(date.getUTCMonth() + 1).padStart(2, '0');
        const day = String(date.getUTCDate()).padStart(2, '0');
        return `${year}/${month}/${day}`;
    },  
    calculateTotalPerNight(){
        this.totalPerNight = (this.booking_range.length-1) * parseInt(this.vessel_data.rate.base_nightly_price);
        return this.totalPerNight > 0 ? this.totalPerNight : 0;
    }, 
    emitTotalPrice(newPrice){
        this.$emit('updateTotalPrice', newPrice);
    },
    emitDueNow(newDueNow){
        this.$emit('updateDueNowPrice', newDueNow);
    },
    emitDueLater(newDueLater){
        this.$emit('updateDueLaterPrice', newDueLater);
    }
  },
};
</script>
