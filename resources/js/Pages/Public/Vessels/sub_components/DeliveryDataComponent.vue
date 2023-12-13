<template>
        <v-row>
            <v-col>
                Enter a custom delivery location 
            </v-col>
        </v-row>  
        <v-row>
            <v-col cols='9'>
                <v-autocomplete
                v-model="selectedAddress"
                ref="myInput"
                :value="inputAddress"
                :items="predictions"
                item-title = "description"
                item-value = "place_id"
                label="Delivery Location"
                @update:modelValue="handleItemClick"
                @input="onAddressInput($event)"
                ></v-autocomplete>
                
            </v-col>
            <v-col cols='3'>${{deliveryFee}}</v-col>
        </v-row>  
        <v-row>
            <v-col>
                <v-row>
                    <v-col>
                        <v-btn 
                        :disabled='!deliveryFee'
                        flat
                        color='light-blue-darken-4'
                        @click="next"
                        >
                            Continue
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>     
</template>

<script>
export default {
    props: {
        expanded_panel: Array,
        vessel_data: Array,
    },
  data() {
    return {
        selectedAddress: null,
        inputAddress: null,
        values: null,
        input: null,
        onFocus:false,
        distanceInMiles: null,
        feePerMile: null,
        deliveryFee:null,   //It should come from props so it ipdates the parent var
        predictions: []
    };
  },
  
  mounted() {
    this.feePerMile = 4;  //It should be dinamic
  },

  create(){

  },

  methods: {
    onAddressInput(event){
        if(event.data !=null ){
            this.inputAddress = this.inputAddress==null ? event.data : this.inputAddress + event.data;
        }else if (event.inputType === 'deleteContentBackward') {
            const cursorPosition = this.getCursorPosition();

            // if (cursorPosition > 0) {
                this.inputAddress = this.inputAddress.slice(0, cursorPosition) + this.inputAddress.slice(cursorPosition + 1);
            // }else{
            //     this.inputAddress='';
            // }
        }

        this.autocomplete();
         
        console.log(this.inputAddress);
    },
    getCursorPosition() {
        // Assuming you have an input element with a ref named "myInput"
        const inputElement = this.$refs.myInput; // Adjust this based on your specific implementation

        // Check if the input element exists and if the browser supports the selectionStart property
        if (inputElement && typeof inputElement.selectionStart === 'number') {
            return inputElement.selectionStart;
        }

        // Default to 0 if selectionStart is not supported or not available
        return 0;
    },
    autocomplete(){
        axios
        .get("/api/googlemap/autocomplete" , {
            params:{
                input: this.inputAddress,
            }
        })
        .then(response=>{
            console.log(response.data);
            this.predictions = response.data;
        })
        .catch();
    },
    handleItemClick(item) {
        this.$refs.myInput.blur();
        this.calculateDistance();
    },
    calculateDistance(){
        axios
        .get('/api/googlemap/get-distance-to-home' , {
            params: {
                origin_address: this.vessel_data.location,
                destination_place_id: this.selectedAddress
            }
        })
        .then(response => {
            const distanceObj = response.data.rows[0].elements[0].distance;
            this.distanceInMiles = this.convertMetersToMiles(distanceObj.value);
            this.calcDeliveryFee();
            console.log(this.distanceInMiles);
        })
        .catch();
    },
    convertMetersToMiles(valueInMeters) {
      // Conversion factor: 1 meter is approximately equal to 0.000621371 miles
      const conversionFactor = 0.000621371;

      // Perform the conversion
      const valueInMiles = (valueInMeters * conversionFactor).toFixed(1);

      return valueInMiles;
    },
    calcDeliveryFee(){
        this.deliveryFee = this.distanceInMiles * this.feePerMile;
    },
    next(){
        this.expanded_panel[0] = 2;
    },
  },
};
</script>
