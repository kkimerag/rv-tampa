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
            <v-col class = 'm-4' >
                <v-sheet>
                    <v-row>
                        <v-col cols='12' md='9'>
                            <v-row>
                                <v-col v-for = 'vessel,index in vessels' cols='12' sm='6' md='4'>
                                    <v-card>
                                        <v-window v-if = "vessel.vessel_images.length > 0"
                                            show-arrows="hover"
                                          >
                                            <template v-slot:prev="{ props }">
                                                 <v-btn
                                                 variant = 'text'
                                                   @click="props.onClick"
                                                 >
                                                   <v-icon
                                                   size='5vh'
                                                   color='white'
                                                   >
                                                       mdi-chevron-left
                                                   </v-icon>
                                                 </v-btn>
                                               </template>
                                               <template v-slot:next="{ props }">
                                                 <v-btn
                                                 variant = 'text'    
                                                   @click="props.onClick"
                                                 >
                                                   <v-icon
                                                   size='5vh'
                                                   color='white'
                                                   >
                                                       mdi-chevron-right
                                                   </v-icon>
                                                 </v-btn>
                                               </template>
                                                <v-window-item
                                                v-for="(image, i) in vessel.vessel_images" 
                                                :key="i"
                                                >

                                                     <v-img
                                                     :src = "image.thumbnailUrl"
                                                     cover
                                                     height='25vh'
                                                     >                                                       <template v-slot:placeholder>
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
                                                </v-window-item>
                                          </v-window>
                                          <v-img v-else
                                          height='25vh'
                                          src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg'
                                          >
                                              
                                          </v-img>
                                        <v-card-title>{{ vessel.make }}</v-card-title>
                                        <v-card-subtitle>
                                            {{ vessel.type.name }} 
                                            <v-icon icon='mdi-star-four-points-small'></v-icon>
                                            Sleeps 
                                            {{ vessel.sleeps}}
                                        </v-card-subtitle>
                                        <v-card-subtitle>
                                            {{ vessel.location.city}} , {{ vessel.location.state.name}}
                                        </v-card-subtitle>
                                        <v-card-text>
                                            <v-sheet class='font-weight-black text-h5'>
                                                ${{ vessel.rate.base_nightly_price}}/night
                                            </v-sheet>
                                        </v-card-text>
                                    </v-card>

                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols='3' class = "d-none d-sm-none d-md-flex">
                            as
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-row>
    </GuestLayout>
</template>

<script>
export default {
  data() {
    return {
      vessels:[],
      // selectedItem: null,
      slides: [
        {
          title: 'TERRA PC-BUSINESS 5050S',
          image: 'https://picsum.photos/500/300?image=15',
          price: 559
        },
        {
          title: 'TERRA PC-BUSINESS 5000',
          image: 'https://picsum.photos/500/300?image=16',
          price: 609
        },
        {
          title: 'TERRA PC-Micro 6000SE SILENT GREENLINE ',
          image: 'https://picsum.photos/500/300?image=17',
          price: 689
        },
        {
          title: 'HP ENVY 5030 multifunction printer',
          image: 'https://picsum.photos/500/300?image=18',
          price: 66
        },
        {
          title: 'TERRA PC-BUSINESS 5050S',
          image: 'https://picsum.photos/500/300?image=19',
          price: 559
        },
        {
          title: 'TERRA PC-BUSINESS 5000',
          image: 'https://picsum.photos/500/300?image=20',
          price: 609
        }
      ]
    };
  },
  
  mounted() {
    this.fetchVessels();
  },

  create(){
    console.log("created");
  },

  methods: {
    fetchVessels(){
        axios
        .get('/api/vessels/')
        .then(response => {
            this.vessels = response.data;
            console.log(this.vessels[0].vessel_images[0].thumbnailUrl);
            // this.selectedItem = Array(response.data.length).fill(0);
        })
        .catch();
    },
    prev(vesselIndex){
        // this.selectedItem[vesselIndex]--;
        // console.log(this.selectedItem[vesselIndex]);
    },
    next(vesselIndex){
        // this.selectedItem[vesselIndex]++;
        // console.log(this.selectedItem[vesselIndex]);
    }
  },
};
</script>