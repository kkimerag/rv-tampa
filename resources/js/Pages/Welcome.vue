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
            <v-sheet color="blue-lighten-5" class="py-4 px-4 h-20 d-flex justify-start">
                <v-row>
                    <v-col cols="10" md="4" lg="6">
                        <div class="d-flex justify-start">
                            <v-sheet color="transparent">
                                <v-row no-gutters>
                                    <v-col>
                                        <div>
                                            <ApplicationLogo id="logo"></ApplicationLogo>
                                        </div>
                                    </v-col>
                                    <v-col>
                                        <div class="text-blue-900 text-h5">
                                            RVTAMPA
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-sheet>
                        </div>
                    </v-col>
                    <v-col class="d-md-none" cols="2">
                        <v-sheet class="d-flex justify-end" color="transparent">
                            <v-menu>
                              <template v-slot:activator="{ props }">
                                <v-btn
                                  color="primary"
                                  v-bind="props"
                                  flat
                                  variant="text"
                                >
                                  <v-icon icon="mdi-menu"></v-icon>
                                </v-btn>
                              </template>
                              <v-list>
                                <v-list-item>
                                  <v-btn
                                  variant="text"
                                  >
                                      Our RVs
                                  </v-btn>
                                </v-list-item>
                                <v-list-item>
                                  <v-btn
                                  variant="text"
                                  href="#features"
                                  >
                                      Features
                                  </v-btn>
                                </v-list-item>
                                <v-list-item>
                                  <v-btn
                                  variant="text"
                                  href="#about"
                                  >
                                      About Us
                                  </v-btn>
                                </v-list-item>
                                <v-divider>
                                    <v-list-item>
                                      <v-btn
                                      variant="text"
                                      >
                                          Features
                                      </v-btn>
                                    </v-list-item>
                                    <v-list-item>
                                      <v-btn
                                      variant="text"
                                      >
                                          About Us
                                      </v-btn>
                                    </v-list-item>
                                </v-divider>
                              </v-list>
                            </v-menu>
                        </v-sheet>
                        
                    </v-col>
                    <v-col cols="" md="6" lg="4">
                        <div class="d-flex justify-end">
                            <v-row>
                                <v-col>
                                    <div class="d-flex justify-end">
                                        <v-btn
                                        variant="text"
                                        >
                                            Our RVs
                                        </v-btn>
                                    </div>
                                </v-col>
                                <v-col>
                                    <div class="d-flex justify-end">
                                        <v-btn
                                        variant="text"
                                        href="#features"
                                        >
                                            Features
                                        </v-btn>
                                    </div>
                                </v-col>
                                <v-col>
                                    <div class="d-flex justify-end">
                                        <v-btn
                                        variant="text"
                                        href="#about"
                                        >
                                            About Us
                                        </v-btn>
                                    </div>
                                </v-col>
                            </v-row>
                        </div>
                    </v-col>
                    <v-col cols="12" md="2" lg="2" v-if="canLogin">
                        <div class="d-flex justify-end">
                            <v-sheet
                            
                            rounded="pill"
                            color="light-blue-darken-4"
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
                                        size="small"
                                        >Log in
                                    </v-btn>
                                        |
                                    <v-btn
                                        variant="text"
                                        v-if="canRegister"
                                        :href="route('register')"
                                        size="small"
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
            gradient = "to top, rgba(0,0,0,0.2), rgba(0,0,0,0.4) 70%, transparent"
            >

                    <v-sheet 
                    class="d-flex justify-center align-end h-10 pb-12" 
                    height="70vh" 
                    color="transparent">
                        <v-btn
                        color="light-blue-darken-4"
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
            <v-sheet color="blue-lighten-5" class="py-5 px-5">
                <v-row>
                    <v-col>
                        <v-sheet class="d-flex justify-center text-h4" color="transparent">Reviews</v-sheet>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6" lg="4">
                        <v-card variant ="text">
                            <v-card-title>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    Chad H.
                                </v-sheet>
                            </v-card-title>
                            <v-card-subtitle>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    November 2023
                                </v-sheet>
                            </v-card-subtitle>
                            <v-card-text>
                                  <v-row
                                    align="center"
                                    class="mx-0"
                                  >
                                    <v-col>
                                        <v-sheet class="d-flex justify-center" color="transparent">
                                            <v-rating
                                              :model-value="4"
                                              color="amber"
                                              density="compact"
                                              half-increments
                                              readonly
                                              size="small"
                                            ></v-rating>
                                        </v-sheet>
                                    </v-col>
                                  </v-row>
                                  <v-row>
                                      <v-col>
                                          Responsive, available when we needed them. The toy hauler is very big. They are very kind people. Will use them again. 
                                      </v-col>
                                  </v-row>
                                </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" lg="4">
                        <v-card variant ="text">
                            <v-card-title>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    David F.
                                </v-sheet>
                            </v-card-title>
                            <v-card-subtitle>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    March 2023
                                </v-sheet>
                            </v-card-subtitle>
                            <v-card-text>
                                  <v-row
                                    align="center"
                                    class="mx-0"
                                  >
                                    <v-col>
                                        <v-sheet class="d-flex justify-center" color="transparent">
                                            <v-rating
                                              :model-value="5"
                                              color="amber"
                                              density="compact"
                                              half-increments
                                              readonly
                                              size="small"
                                            ></v-rating>
                                        </v-sheet>
                                    </v-col>
                                  </v-row>
                                  <v-row>
                                      <v-col>
                                          This was a great experience, pick up and drop off was super easy . The hosts were nice, professional and accommodating. The RV was in great condition and had an awesome outdoor kitchen. We will definitely rent from them again. 
                                      </v-col>
                                  </v-row>
                                </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" lg="4">
                        <v-card variant ="text">
                            <v-card-title>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    Rafael P.
                                </v-sheet>
                            </v-card-title>
                            <v-card-subtitle>
                                <v-sheet class="d-flex justify-center" color="transparent">
                                    December 2022
                                </v-sheet>
                            </v-card-subtitle>
                            <v-card-text>
                                  <v-row
                                    align="center"
                                    class="mx-0"
                                  >
                                    <v-col>
                                        <v-sheet class="d-flex justify-center" color="transparent">
                                            <v-rating
                                              :model-value="5"
                                              color="amber"
                                              density="compact"
                                              half-increments
                                              readonly
                                              size="small"
                                            ></v-rating>
                                        </v-sheet>
                                    </v-col>
                                  </v-row>
                                  <v-row>
                                      <v-col>
                                          What a fantastic experience ! We loved the R.V. And Edwina and her husband were helpful, they explained everything .
                                          Such wonderful hosts ! 
                                      </v-col>
                                  </v-row>
                                </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-col>
    </v-row>

    <v-row no-gutters>
        <v-col class="">
            <v-sheet 
            color="light-blue-darken-4" 
            class="" 
            height="20vh">
            </v-sheet>
        </v-col>
    </v-row>

    <v-row no-gutters id="features">
        <v-col >
            <v-sheet class="d-flex justify-center ">
                    <v-card 
                    width="80vw" 
                    class="mt-n16  rounded-t-xl" 
                    elevation="16"
                    >
                         <v-img
                          src="./images/mountains.png"
                          cover
                          class="text-white mt-0"
                          height = 15vh
                          gradient = "to top, rgba(0,0,0,0.2), rgba(0,0,0,0.4) 70%, transparent"
                        >
                            <v-row no-gutters>
                                <v-col>
                                    <div class="d-flex justify-center text-h4 mt-4">
                                        features
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row no-gutters>
                                <v-col>
                                    <div class="d-flex justify-center text-h6 mt-4">
                                        We offer many optional services to make a stress-free enjoyment
                                    </div>
                                </v-col>
                            </v-row>
                            <v-row no-gutters>
                                <v-col>
                                    <div class="d-flex justify-center">
                                        <v-btn size="small" color="light-blue-darken-4" >
                                            All Features
                                        </v-btn>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-img>
                        <v-card-text>
                            <v-row>
                                <v-col v-for="feature in features" :key="feature.id" cols="12" md="6" lg="3">

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
                            </v-row>
                        </v-card-text>
                    </v-card>
            </v-sheet>
        </v-col>
    </v-row>

    <v-row no-gutters id="about">
        <v-col >
            <v-sheet class="d-flex justify-center mb-n16">
                    <v-card 
                    width="80vw" 
                    class="mt-16 rounded-b-xl" 
                    elevation="16"
                    >
                        <v-card-title>
                            <v-sheet class="d-flex justify-center text-h4">
                                About Us
                            </v-sheet>
                        </v-card-title>
                        <v-divider
                        thickness="5" 
                        inset
                        color="light-blue-darken-4"
                        class="border-opacity-100 "
                        ></v-divider>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <p>Welcome to RV Tampa, where our love for RVs is woven into the fabric of our own personal adventures across the vast landscapes of the USA. We're not just passionate about recreational vehicles; we're seasoned travelers who have explored the highways and byways, finding inspiration in every corner of this beautiful country.</p>

                                   <p> Our journey began 1 years ago, fueled by a desire to break free from the ordinary and embrace the extraordinary. From the sun-kissed beaches of Florida to the rugged mountains of Colorado, we've traversed the diverse tapestry of America, turning each mile into a chapter of our own story.</p>

                                    <p>Having navigated the open roads ourselves, we intimately understand the thrill of discovering hidden gems off the beaten path, the joy of spontaneous detours, and the warmth of a campfire under a starlit sky. These personal experiences form the foundation of our expertise. We've tested the roads, felt the winds, and found solace in the camaraderie of fellow travelers.</p>

                                    <p>As avid adventurers, we recognize that an RV is not just a mode of transportation; it's the vessel that carries dreams, laughter, and shared moments. Our curated selection of RVs reflects not only our knowledge of the industry but also the practical insights gained from our own expeditions. We know what it's like to wake up to the sound of waves crashing on the Pacific Coast, or to witness the sunrise over the Grand Canyon from the comfort of your own rolling sanctuary.</p>

                                    <p>The bond we share with our customers goes beyond a mere transaction. It's a connection forged on the open road, a shared understanding of the thrill that comes with the turn of every new mile. We're not just here to sell you an RV; we're here to be your travel companions, offering advice, sharing stories, and ensuring that your journey is as extraordinary as the destinations you choose to explore.</p>

                                    <p>At RV Tampa, we invite you to embark on this adventure with us – the adventure of a lifetime, where every RV we offer is a reflection of the countless memories we've made on the road. Join our community of like-minded explorers, and let's make your RV experience not just a purchase but a part of your own personal odyssey across the heart and soul of America. Welcome to a world where the road becomes your canvas, and every mile is a stroke of your unique story.</p>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-sheet>
                                        <v-img
                                        src="./images/about-us.jpg"
                                        >
                                            
                                        </v-img>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-sheet class="d-flex justify-center">
                                        <div>Let's connect!</div>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col class="">
                                    <v-sheet class="d-flex justify-center">
                                        <v-btn
                                        color = "blue-darken-4"
                                        variant="text"
                                        icon
                                        class ="mx-6"
                                        >
                                            <v-icon icon="mdi-youtube" size="100"></v-icon>
                                        </v-btn>
                                        <v-btn
                                        color = "blue-darken-4"
                                        variant="text"
                                        icon
                                        class ="mx-6"
                                        >
                                            <v-icon icon="mdi-facebook" size="100"></v-icon>
                                        </v-btn>
                                    </v-sheet>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            
                            
                            
                        </v-card-actions>
                    </v-card>
            </v-sheet>
        </v-col>
    </v-row>

    <v-row>
        <v-col>
            <v-sheet
            color="light-blue-darken-4"

            class="mt-n16 pt-16 px-5"
            >
                <v-row>
                    <v-col cols="12" md="6">
                        <v-row class="mt-16">
                            <v-col>
                                OTHER PLATFORMS:
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                <v-img
                                cover
                                height="10vh"
                                width="20vw"
                                src="https://lh3.googleusercontent.com/LPhaUWjjk_V-6vHWgfE0QKLak_4ionnc0IabkYXjETeI3vH1IAtmYWX10f1L1Gxo6EmRa4KA9Q69lmeFFWRFWJLTkoXmlvN3Z4yXdVYUPlwRjhLGQSRGuGLEd1349Ja-pg=w1280"
                                >
                                </v-img>
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                <v-img
                                cover
                                height="10vh"
                                width="20vw"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTghTJuUnqnBe8pzPGVwSDLzIjfpI4gG2uZEQyMxys6itZZ7I_999kSn63IHnSB7tl9Sg&usqp=CAU"
                                >
                                </v-img>
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                <v-img
                                cover
                                height="10vh"
                                width="20vw"
                                src="https://play-lh.googleusercontent.com/LaXhWJTcUuwY6mAK-bqS9pjliwt5AYJ0n3cniipWzUd733Oio3PGNjaPH9Bm75Y3Sos"
                                >
                                </v-img>
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                <v-img
                                cover
                                height="10vh"
                                width="20vw"
                                src="https://media.licdn.com/dms/image/C560BAQGyIwfrIgVTTw/company-logo_200_200/0/1630635227216/rvngo_logo?e=2147483647&v=beta&t=2rygO010wMl5ANZ5Chc_Zv8SEFlofbxN-RxKN3Qtjl4"
                                >
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-col>

                    <v-col cols="12" md="6">
                        <v-row class="mt-16">
                            <v-col>
                                CONTACT US:
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                Phone: (813) 365-1418
                            </v-col>
                        </v-row>
                        <v-row class="">
                            <v-col>
                                Email: admin@rv-tampa.com
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14090.856310626541!2d-82.31262855202732!3d28.002642873718834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c2c90f442b6e6b%3A0x895b760105eade38!2srv%20tampa!5e0!3m2!1sen!2sus!4v1701956827534!5m2!1sen!2sus" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-col>
    </v-row>
    <v-row>
        <v-col>
            <v-sheet class="d-flex justify-center">
                Powered By: CIRUX DIGITAL 2023 LLC
            </v-sheet>
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
                    description: "No truck, no problem. We can deliver the camper anywhere!",
                    icon: "mdi-truck-delivery"
                },
                {
                    id: 2, 
                    name: "toys", 
                    description: "Golf Cars, ATVs, and more available for rent",
                    icon: "mdi-golf-cart"
                },
                {
                    id: 3, 
                    name: "dumping", 
                    description: "We will empty septic tanks after your rent",
                    icon: "mdi-paper-roll"
                },
                {
                    id: 4, 
                    name: "RV setup", 
                    description: "beside delivering, we can get the camper set & hooked up",
                    icon: "mdi-checkbox-marked-circle-auto-outline"
                }
            ],
          }
        },
    };
</script>
<style type="text/css">
    #logo{
        width: 80px;
        height: 80px;
        margin-top: -10px;
    }
    .centered-actions{
        justify-content: center;
    }
</style>