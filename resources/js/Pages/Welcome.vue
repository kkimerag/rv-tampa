<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';    
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <v-row>
        <v-col>
            <v-sheet color="orange-lighten-5" class="py-5 px-5">
            <v-row>
                <v-col>
                    <div class="d-flex justify-start h-10">
                        <ApplicationLogo></ApplicationLogo>
                    </div>
                </v-col>
                <v-col>
                    <div class="d-flex justify-end">
                        <v-btn
                        variant="text"
                        >
                            Our RVs
                        </v-btn>
                    </div>
                </v-col>
                <v-col v-if="canLogin">
                    <div class="d-flex justify-end">
                        <v-sheet
                        
                        rounded="pill"
                        color="orange-accent-4"
                        >
                            <v-btn
                                v-if="$page.props.auth.user"
                                variant="text"
                                :href="route('dashboard')"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                >Dashboard
                            </v-btn>
                            <template v-else>
                                <v-btn
                                    variant="text"
                                    :href="route('login')"
                                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >Log in
                                </v-btn>

                                <v-btn
                                    variant="text"
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >Register
                                </v-btn>
                            </template>
                        </v-sheet>
                    </div>
                </v-col>
            </v-row>
        </v-sheet>
        </v-col>
    </v-row>
    <v-row no-gutters>
        <v-col>
            <v-img
            height="70vh"
            src="./images/rv-tampa-front-img.jpg"
            cover
            >

                    <v-sheet 
                    class="d-flex justify-center align-end h-10 pb-12" 
                    height="70vh" 
                    color="transparent">
                        <v-btn
                        color="orange-accent-4"
                        size="large"
                        >
                            BOOK IT
                        </v-btn>
                    </v-sheet>                            

            </v-img>
        </v-col>
    </v-row>
    <v-row no-gutters>
        <v-col>
            <v-sheet color="orange-lighten-5" class="py-5 px-5">
                ad
            </v-sheet>
        </v-col>
    </v-row>
    <v-row no-gutters>
        <v-col class="mb-n16">
            <v-sheet 
            color="orange-accent-4" 
            class="py-5 px-5" 
            height="15vh">
            </v-sheet>
        </v-col>
    </v-row>
    <v-row no-gutters >
        <v-col >
            <v-sheet class="d-flex justify-center " rounded="xxl">
                    <v-card 
                    width="80vw" 
                    class="mt-n16 rounded-xl" 
                    rounded="xxl" 
                    elevation="16"
                    >
                         <v-img
                          src="https://cdn.vuetifyjs.com/docs/images/cards/purple-flowers.jpg"
                          cover
                          class="text-white "
                          height = 15vh
                        >
                            <v-row>
                                <v-col>
                                    <div class="d-flex justify-center text-h4 mt-4">
                                        features
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <div class="d-flex justify-center">
                                        <v-btn size="small" color="orange-accent-4" >
                                            All Features
                                        </v-btn>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-img>
                        <v-card-text>
                            <v-row>
                                <v-col>
                                    <v-col v-for="feature in features" :key="feature.id" cols="12" md="6" lg="4">

                                        <v-card 
                                        class="rounded-lg d-flex flex-column justify-center align-center pt-8" 
                                        height="30vh"
                                        variant="text"
                                        >
                                            <v-icon left size="100">{{ feature.icon }}</v-icon>
                                            <div></div>
                                            <v-card-title class="text-lg font-semibold justify-center align-center text-uppercase">
                                                {{ feature.name }}
                                            </v-card-title>
                                            <v-card-text >{{ feature.description }}</v-card-text>
                                        </v-card>
                                    </v-col>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
            </v-sheet>
        </v-col>
    </v-row>
    <v-row>
        <v-col>
            about us
        </v-col>
    </v-row>
</template>

<script type="text/javascript">
    export default {
        data () {
          return {
            features:[
                {
                    id: 1, 
                    name: "deliver", 
                    description: "no truck, no problem. We can deliver the camper anywhere!",
                    icon: "mdi-truck-delivery"
                }
            ],
          }
        },
    };
</script>
