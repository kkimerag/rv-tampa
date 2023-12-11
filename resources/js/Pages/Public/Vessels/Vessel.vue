<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Our RVs" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Our RVs</h2>
        </template>

        <v-row>
            <v-col class='d-flex justify-center m-4'>
                <v-sheet  width='70vw'>
                    <v-row>
                        <v-col cols='12'>
                            <v-row>
                                <v-col>
                                  <v-row no-gutters>
                                      <v-col cols='8'>
                                        <v-img v-if = 'vessel && vessel.vessel_images.length >= 1'
                                        :src = "vessel.vessel_images[0].thumbnailUrl"
                                        cover
                                        height='60vh'
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
                                        height='60vh'
                                        >
                                        </v-img>
                                    </v-col>
                                    <v-col cols='4'>
                                        <v-row no-gutters>
                                            <v-col cols='12'>
                                                <v-img v-if = 'vessel && vessel.vessel_images.length >= 2'
                                                :src = "vessel.vessel_images[1].thumbnailUrl"
                                                cover
                                                height='30vh'
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
                                                height='30vh'
                                                >
                                                </v-img>
                                            </v-col>
                                        </v-row>
                                        <v-row no-gutters>
                                            <v-col cols='12'>
                                                <v-img v-if = 'vessel && vessel.vessel_images.length >= 3'
                                                :src = "vessel.vessel_images[2].thumbnailUrl"
                                                cover
                                                height='30vh'
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
                                                height='30vh'
                                                >
                                                </v-img>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <!-- <v-col cols='3'>
                                        <v-row>
                                            <v-col cols='12'>
                                                <v-img v-if = 'vessel && vessel.vessel_images.length >= 4'
                                                :src = "vessel.vessel_images[3].thumbnailUrl"
                                                cover
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
                                                >
                                                </v-img>
                                            </v-col>
                                        </v-row>
                                    </v-col> -->
                                 </v-row>
                                </v-col>
                            </v-row>
    
                            <v-row>
                                <v-col v-if='vessel'>
                                    <v-progress-linear 
                                    indeterminate 
                                    :active="loading"
                                    :indeterminate="loading"
                                    >
                                    </v-progress-linear>
                                    <v-row>
                                        <v-col cols='8'>
                                            <v-card
                                            flat
                                            >
                                                <v-card-subtitle>
                                                    {{ vessel.type.name }} 
                                                    <v-icon icon='mdi-star-four-points-small'></v-icon>
                                                    Sleeps 
                                                    {{ vessel.sleeps}}
                                                </v-card-subtitle>
                                                <v-card-subtitle>
                                                    {{ vessel.location.city}} , {{ vessel.location.state.name}}
                                                </v-card-subtitle>
                                                
                                                <v-card-title>{{ vessel.make }}</v-card-title>
                                                <v-divider thickness="5">
                                                </v-divider>
                                                <v-card-text>
                                                    <v-row>
                                                        <v-col>
                                                            <div class="text-xl">Features</div>
                                                            <v-row>
                                                                <v-col cols='6'>
                                                                    Sleeps: {{ vessel.sleeps}}
                                                                </v-col>
                                                                <v-col cols='6'>
                                                                    Beds: {{ vessel.beds}}
                                                                </v-col>
                                                            </v-row>
                                                            <v-row>
                                                                <v-col cols='6'>
                                                                    Length: {{ vessel.length}} ft
                                                                </v-col>
                                                                <v-col cols='6'>
                                                                    Weight: {{ vessel.weight}} lbs
                                                                </v-col>
                                                            </v-row>
                                                            <v-row>
                                                                <v-col cols='6'>
                                                                    Hitch Weight: {{ vessel.hitch_weight}} lbs
                                                                </v-col>
                                                                <v-col cols='6'>
                                                                    Year: {{ vessel.year}}
                                                                </v-col>
                                                            </v-row>
                                                        </v-col>
                                                    </v-row>
                                                    <v-divider thickness="5">
                                                    </v-divider>
                                                    <v-row>
                                                        <v-col>
                                                            <div class="text-xl">Availability and rates</div>
                                                            <v-date-picker
                                                            v-model='date'
                                                            multiple
                                                            @update:modelValue="setRage()"
                                                            >
                                                            </v-date-picker>
                                                        </v-col>
                                                    </v-row>
                                                </v-card-text>
                                            </v-card>
                                        </v-col>
                                        <v-col cols='4'>
                                            saf
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            
                        </v-col>
                    </v-row>
                </v-sheet>

            </v-col>
        </v-row>
        
    </GuestLayout>
</template>

<script>
export default {
    props: {
        vessel_id: String
    },
  data() {
    return {
        vessel:null,
        date: null,
        loading:true,
    };
  },
  
  mounted() {
    this.getVessel();
  },

  create(){

  },

  methods: {
    getVessel(){
        this.loading = true;
        axios
        .get('/api/vessels/get-id' , {
            params:{
                id : this.vessel_id,
            }
        })
        .then(response => {
            this.vessel = response.data;
            this.loading = false;
            console.log(response.data);
        })
        .catch();
    },
    setRage(){
        console.log(this.date);
    }
  },
};
</script>