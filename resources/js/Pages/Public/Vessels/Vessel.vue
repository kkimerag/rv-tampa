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

    };
  },
  
  mounted() {
    this.getVessel();
  },

  create(){

  },

  methods: {
    getVessel(){
        axios
        .get('/api/vessels/get-id' , {
            params:{
                id : this.vessel_id,
            }
        })
        .then(response => {
            console.log(response.data);
        })
        .catch();
    }
  },
};
</script>