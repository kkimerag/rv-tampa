<template>
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
                    <v-row no-gutter>
                        <v-col>
                            <v-row no-gutter>
                                <v-col>Start:</v-col>
                            </v-row>
                            <v-row no-gutter class="mt-n6">
                                <v-col>{{formatDate(booking_range[0])}}</v-col>
                            </v-row>
                        </v-col>
                        <v-col>
                            <v-row no-gutter>
                                <v-col>Ends:</v-col>
                            </v-row>
                            <v-row no-gutter class="mt-n6">
                                <v-col>{{formatDate(booking_range[booking_range.length-1])}} </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card-subtitle>
                <v-card-text>
                    <v-row>
                        <v-col>${{vessel_data.rate.base_nightly_price}} x {{booking_range.length-1}}</v-col>
                        <v-col>${{calculateTotalPerNight()}}</v-col>
                    </v-row>
                    <v-row>
                        <v-col> Cleaning Fee </v-col>
                        <v-col>${{ownFees}}</v-col>
                    </v-row>
                    <v-row>
                        <v-col> Delivery Fee </v-col>
                        <v-col>${{delivery_fee}}</v-col>
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
    },
  data() {
    return {
        ownFees:null,
    };
  },
  
  mounted() {
    console.log(this.booking_range);
    this.ownFees = 60;
  },

  create(){

  },

  methods: {
    formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}/${month}/${day}`;
    },  
    calculateTotalPerNight(){
        this.totalPerNight = (this.booking_range.length-1) * parseInt(this.vessel_data.rate.base_nightly_price);
        return this.totalPerNight > 0 ? this.totalPerNight : 0;
    }, 
  },
};
</script>
