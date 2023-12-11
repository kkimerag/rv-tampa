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

                CheckOut
            </v-col>
        </v-row>
        
    </GuestLayout>
</template>

<script>

export default {
    props: {

    },
  data() {
    return {

    };
  },
  
  mounted() {
    
  },

  create(){

  },

  methods: {

  },
};
</script>

<style type="text/css">
    
</style>