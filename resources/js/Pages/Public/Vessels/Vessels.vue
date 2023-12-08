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
                        <v-col cols='12' md='8'>
                            <v-row>
                                <v-col v-for = 'vessel in vessels' cols='12' sm='6'>
                                    <v-card>
                                        <v-card-title>{{ vessel.make }}</v-card-title>
                                        <v-card-subtitle>
                                            {{ vessel.type.name }} 
                                            <v-icon icon='mdi-star-four-points-small'></v-icon>
                                            Sleeps 
                                            {{ vessel.sleeps}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols='4' class = "d-none d-sm-none d-md-flex">
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
            console.log(response.data);
        })
        .catch();
    },
  },
};
</script>