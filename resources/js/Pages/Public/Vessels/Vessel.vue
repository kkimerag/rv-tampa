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
                <v-sheet  width='80vw'>
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
                            <!-- INFO SECTION -->
                            <v-row>
                                <v-col v-if='vessel'>
                                    <v-progress-linear 
                                    indeterminate 
                                    :active="loading"

                                    >
                                    </v-progress-linear>
                                    <v-row>
                                        <!-- INFORMATION SECTION -->
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
                                                    <v-divider thickness="5" class='mb-4'>
                                                    </v-divider>
                                                    <v-row>
                                                        <v-col>
                                                            <div class="text-xl">Availability and rates</div>
                                                            <v-date-picker
                                                            v-model='date'
                                                            color="light-blue-darken-4"
                                                            ref = 'calendar'
                                                            hide-header
                                                            :allowed-dates='allowedDates'
                                                            multiple
                                                            @update:modelValue="setRage()"
                                                            @update:month="highlightBookedDates"
                                                            >
                                                            </v-date-picker>
                                                        </v-col>
                                                    </v-row>
                                                </v-card-text>
                                            </v-card>
                                        </v-col>

                                        <!-- RESERVATION SECTION -->
                                        <v-col cols='4'>
                                            <ReservationComponent
                                            :vessel_price = 'vessel.rate.base_nightly_price'
                                            :deposit = 'vessel.rate.deposit'
                                            :booking_dates='date'
                                            :booking_days = 'bookingRange'
                                            >
                                            </ReservationComponent>
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
    import ReservationComponent from "./sub_components/ReservationComponent.vue";
export default {
    props: {
        vessel_id: String
    },
  data() {
    return {
        vessel:null,
        date: [],
        loading:true,
        allowedDates: [],
        bookingRange:[],
        calendarElements:[]
    };
  },
  
  mounted() {
    this.getVessel();
    this.getDaysToEndOfMonth();
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
            // console.log(response.data);
        })
        .catch();
    },
    setRage(){
        const daysSelected = this.date.length;
        if (daysSelected == 3 ){
            this.clearHighlight();
            this.$nextTick(() => {
                this.clearHighlight();
                this.$nextTick(() => {
                    this.clearHighlight();               
                });               
            });
            this.date.shift();
            this.date.shift();  
            // this.clearHighlight();          
        }else if(daysSelected == 2){
            this.date.sort(function(a, b) {
              return a - b;
            });
            this.getDatesInRange( this.date[0] , this.date[1] )
            this.updateURL();
        }  
        
        this.highlightBookedDates();
    },
    highlightBookedDates(){
        this.clearHighlight();
        this.$nextTick(() => {
            this.clearHighlight(); 
            this.$nextTick( () => {
                this.calendarElements = this.$refs.calendar.$el.querySelectorAll('.v-date-picker-month__day');
                this.calendarElements.forEach((element) => {
                    const dateAttribute = element.getAttribute('data-v-date'); 
                    if (dateAttribute && this.bookingRange.some(date => this.formatDate(date) === dateAttribute)) {
                      element.classList.add('booked');
                    }
                });
            });              
        });        
    },
    clearHighlight(){
        this.calendarElements = this.$refs.calendar.$el.querySelectorAll('.v-date-picker-month__day');

        this.calendarElements.forEach((element) => {
                element.classList.remove('booked');
              });

        // this.$nextTick(() => {
        //     this.calendarElements.forEach((element) => {
        //         // element.classList.remove('booked');
        //     });                
        // });
    },
    getDatesInRange(startDate, endDate) {
        const dates = [];
        let currentDate = new Date(startDate);

        while (currentDate <= endDate) {
          dates.push(new Date(currentDate));
          currentDate.setDate(currentDate.getDate() + 1);
        }
        this.bookingRange = dates;
    },
    formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    },    
    getDaysToEndOfMonth() {
        const today = new Date();
        const oneYearFromNow = new Date();
        oneYearFromNow.setFullYear(today.getFullYear() + 1);

        for (let currentDate = today; currentDate <= oneYearFromNow; currentDate.setDate(currentDate.getDate() + 1)) {
          this.allowedDates.push(this.formatDate(currentDate));
        }
    },
    updateURL() {
        const currentURL = new URL(window.location.href);
        const params = new URLSearchParams(currentURL.search);

        params.set('StartDate', this.formatDate(this.date[0]));
        params.set('EndDate', this.formatDate(this.date[1]));

        const newURL = `${currentURL.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newURL);
    }
  },
};
</script>

<style type="text/css">
    .booked{
        background-color: #4FC3F7;
    }
    .booked button{
/*        color: #B3E5FC;*/
        background-color: #4FC3F7;
    }
</style>