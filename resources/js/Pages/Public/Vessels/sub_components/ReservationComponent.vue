<template>
        <v-row>
            <v-col>
                <v-card 
                class="px-6 py-6"
                >
                    <v-row>
                        <v-col>
                            <v-sheet class="text-h5">
                                ${{vessel_price}} PER NIGHT
                            </v-sheet>
                        </v-col>
                    </v-row>
                    <v-divider thickness="5" >
                        
                    </v-divider>
                    <v-row>
                        <v-col cols='6'>
                            <v-sheet>
                                <v-text-field 
                                v-model="booking_dates[0]"
                                label="Check in" 
                                variant="outlined" 
                                class="text-subtitle-2"
                                density="compact"
                                readonly
                                :model-value="booking_dates.length >=1 ? booking_dates[0] : 'Add Dates'"
                                >
                                </v-text-field>
                            </v-sheet>
                        </v-col>
                        <v-divider  vertical>
                            
                        </v-divider>
                        <v-col cols='6'>
                            <v-sheet>
                                <v-text-field 
                                v-model="booking_dates[1]"
                                label="Check out"
                                variant="outlined" 
                                class="text-subtitle-2"
                                density="compact"
                                readonly
                                :model-value="booking_dates.length >=2 ? booking_dates[1] : 'Add Dates'"
                                >
                                </v-text-field>
                            </v-sheet>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-btn 
                            color="light-blue-darken-4" 
                            block
                            :disabled = "booking_dates.length > 1 ? false : true"
                            @click="navigateToCheckout()"
                            >
                            Request to Book
                        </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                          <v-row>
                              <v-col>${{vessel_price}} x {{booking_days.length-1}} <span class="text-body-2">Nights</span></v-col>
                              <v-col>${{calculateTotalPerNight()}}</v-col>
                          </v-row>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                          <v-row>
                              <v-col> Owner's Fees </v-col>
                              <v-col>${{ownFees}}</v-col>
                          </v-row>
                        </v-col>
                    </v-row>
                    
                    <v-row>
                        <v-col>
                          <v-row>
                              <v-col> Total </v-col>
                              <v-col>${{calculateTotal()}}</v-col>
                          </v-row>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>        
</template>

<script>
export default {
    props: {
        vessel_price: String,
        booking_dates: Array,
        booking_days: Array,
        deposit: String
    },
  data() {
    return {
        bookingDates:[],
        startDate: null,
        endDate: null,
        totalPerNight: null,
        ownFees: null,
    };
  },
  
  mounted() {
    // this.setDates();
    this.ownFees = 60;
  },

  create(){

  },

  methods: {
    calculateTotalPerNight(){
        this.totalPerNight = (this.booking_days.length-1) * parseInt(this.vessel_price);
        return this.totalPerNight > 0 ? this.totalPerNight : 0;
    },
    calculateTotal(){
        const total = this.calculateTotalPerNight() + this.ownFees + parseInt(this.deposit);
        return total;
    },
    navigateToCheckout() {
      // Get the current URL
      const currentUrl = window.location.href;

      // Parse the current URL
      const url = new URL(currentUrl);

      // Extract path and query parameters
      const path = url.pathname;
      const params = url.search;

      // Concatenate 'checkout' to the path and keep the existing parameters
      const checkoutUrl = `${path}/checkout${params}`;

      // Navigate to the new URL
      window.location.href = checkoutUrl;
    }
  },
};
</script>
