<template>
        <v-row>
            <v-col>
                Enter a custom delivery location
            </v-col>
        </v-row>  
        <v-row>
            <v-col cols='12' md='9'>
                <v-autocomplete
                v-model="selectedAddress"
                ref="myInput"
                bg-color="white"
                :value="inputAddress"
                :items="predictions"
                item-title = "description"
                item-value = "place_id"
                label="Delivery Location"
                @change="setAddress"
                @update:modelValue="handleItemClick"
                @input="onAddressInput($event)"
                ></v-autocomplete>
                
            </v-col>
            <v-col cols='12' md='3'>${{deliveryFee}}</v-col>
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
        expanded_panel: Number,
        vessel_data: Object,
        // delivFee: Number,
        // deliveryAddress: String,
    },
    emits: ['updateDeliveryFee' , 'updateExpandedPanel' , 'updateDeliveryAddress'],
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
        predictions: [],
    };
  },

  computed: {
      selectedItemAddress() {
        // if(this.selectedAddress){
        //     return this.predictions.find(item => item.place_id === this.selectedAddress);
        // }
        return this.selectedAddress ? this.predictions.find(item => item.place_id === this.selectedAddress) : false;
      },
    },
  
  mounted() {
    this.feePerMile = 4;  //It should be dinamic
  },

  create(){

  },

  methods: {
    onAddressInput(event){
        let cursorPosition = this.getCursorPosition();
        if(event.data !=null ){
            const newLetter = event.data.slice(-1);
            if(this.inputAddress==null){
                this.inputAddress = newLetter;
            }else{
                this.inputAddress = this.inputAddress.slice(0, cursorPosition-1) + newLetter + this.inputAddress.slice(cursorPosition-1);
            }
        }else if (event.inputType === 'deleteContentBackward') {

            const stringLentgth = this.inputAddress.length-1;
            const leftSubStr = this.inputAddress.slice(0, cursorPosition);
            const rightSubStr= this.inputAddress.slice(cursorPosition + 1);

            

            if( stringLentgth !== cursorPosition ){
                this.inputAddress = leftSubStr + rightSubStr;
            }else{
                this.inputAddress = leftSubStr;
            }
        }

        this.autocomplete();
        
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
            this.predictions = response.data;
        })
        .catch();
    },
    setAddress(){
        if(this.selectedItemAddress !== false){
            this.emitDeliveryAddress(this.selectedItemAddress.description);
        }else{
            console.log("No esta definido");
        }        
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
            if(response.data.destination_addresses.length != 0){
                const distanceObj = response.data.rows[0].elements[0].distance;
                this.distanceInMiles = this.convertMetersToMiles(distanceObj.value);
                this.calcDeliveryFee();
                // console.log(this.selectedAddress);
            }else{
                console.log("empty address");
            }
            
        })
        .catch();
    },
    convertMetersToMiles(valueInMeters) {
      const conversionFactor = 0.000621371;
      const valueInMiles = (valueInMeters * conversionFactor).toFixed(1);
      return valueInMiles;
    },
    calcDeliveryFee(){
        this.deliveryFee = this.distanceInMiles * this.feePerMile;
        this.emitDeliveryFeeUpdate();
    },
    emitDeliveryFeeUpdate() {
        this.$emit('updateDeliveryFee', this.deliveryFee);
    },
    emitDeliveryAddress(newAddress) {
        this.$emit('updateDeliveryAddress', newAddress);
    },
    next(){
        // this.expanded_panel[0] = 2;
        this.$emit('updateExpandedPanel', 3);
    },
  },
};
</script>
