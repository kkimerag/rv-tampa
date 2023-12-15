<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

<v-row>
    <v-col>
        <v-app>
        <slot />
        </v-app>
    </v-col>
</v-row>
</template>
