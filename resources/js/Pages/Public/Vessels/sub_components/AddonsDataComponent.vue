<template>
        <v-row v-if='addons'>
            <v-col>
                <v-row>
                    <v-col v-for='addon in addons' cols='12' md="4">
                        <v-checkbox
                          v-model="selectedAddons"
                          :value="addon"
                        >
                        <template v-slot:label>
                            <div>
                              {{addon.name}}
                              <v-tooltip location="bottom">
                                <template v-slot:activator="{ props }">
                                  <v-icon
                                    v-bind="props"
                                    @click.stop
                                  >
                                    mdi-information-slab-circle-outline
                                  </v-icon>
                                </template>
                                {{addon.description}}
                              </v-tooltip>
                            </div>
                          </template>
                        </v-checkbox>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-row>
                            <v-col>
                                <v-btn 
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
export default {
    props: {
        vesselData: Object,
    },
    emits: ['updateSelectedAddons' , 'updateExpandedPanel'],
  data() {
    return {
        addons:[],
        selectedAddons: [],
    };
  },
  
  mounted() {
    this.addons=null;
    if(this.vesselData){
        this.fetchAddons();
    }
  },

  watch: {
      selectedAddons(newValue, oldValue) {
        this.emitSelectedAddons(newValue);
      },
    },

  create(){

  },

  methods: {
    fetchAddons(){
        axios
        .get('/api/addons' , {
            params:{
                user_id : this.vesselData.user_id,
            }
        })
        .then(response =>{
            this.addons = response.data;
        })
        .catch();
    },
    emitSelectedAddons(newSelectedAddons){
        this.$emit('updateSelectedAddons', newSelectedAddons);
    },
    next(){
        this.$emit('updateExpandedPanel', 5);
    },
  },
};
</script>
