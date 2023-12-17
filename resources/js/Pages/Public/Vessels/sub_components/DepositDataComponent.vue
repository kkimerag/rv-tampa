<template>
        <v-row>
            <v-col>
                <v-sheet
                  border
                  rounded
                  @click="newDeposit( parseInt(vessel.rate.deposit) )"
                >
                <v-row>
                    <v-col cols='12' md='10'>     
                        <v-row>
                            <v-col>
                                <v-radio 
                                v-model="radio"
                                label="Refundable Security Deposit" 
                                :true-value="parseInt(vessel.rate.deposit)"
                                :value="parseInt(vessel.rate.deposit)"
                                >
                                </v-radio>
                            </v-col>
                        </v-row>                                               
                        <v-row>
                            <v-col>
                                Security Deposit refunds are at the discretion of the Owner and are not guaranteed.
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols='12' md='2'>
                        $1000
                    </v-col>
                </v-row>
                </v-sheet>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-row>
                    <v-col>
                        <v-btn 
                        :disabled='!deposit'
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
        deposit: Number,
        vessel:Object,
        expanded_panel: Number,
    },
    emits: ['updateDeposit' , 'updateExpandedPanel'],
  data() {
    return {
        radio:null,
    };
  },
  
  mounted() {

  },

  create(){

  },

  methods: {
    newDeposit(newDeposit){
        this.radio = newDeposit;
        this.$emit('updateDeposit', newDeposit);
    },
    next(){
        this.$emit('updateExpandedPanel', 4);
    },
  },
};
</script>
