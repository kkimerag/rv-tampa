<script setup>
import {  usePage } from '@inertiajs/vue3';
const user = usePage().props.auth.user;
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-themePink-600"> {{ $t('Payment Integration') }}</h2>

            <p class="mt-1 text-sm text-themePink-300">
                
                {{ $t('payment platform') }}
            </p>
        </header>
        <v-sheet>
            <v-card>
                <v-card-text class="d-flex justify-center">
                    <v-row  v-if="!accountId">
                        <v-col>
                            <v-btn
                            color="deep-purple-accent-2"
                            @click="connectToStrip"
                            >
                            {{ $t('Connect Stripe') }}
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row v-else>
                        <v-col v-if="!isFullyOnboarded">
                            <v-btn 
                            color="deep-purple-accent-2"
                            @click="getStripLink"
                            >
                            {{ $t('Continue Stripe') }}
                            </v-btn>
                        </v-col>
                        <v-col v-else>
                            {{ $t('Stripe Connected') }}!
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-sheet>
    </section>
</template>
<script>
export default {
  props: {

  },
  data() {
    return {
        accountId : null,
        isFullyOnboarded: false,
    };
  },
  mounted() {

  },
  created() {
    this.stripeAccountExist();
  },
  components:{

  },
  methods: {
    $t(key, params) {
      const translationExists = this.$page.props.translations ? true : false;
      return translationExists ? this.$page.props.translations[key] : key;
    },
    connectToStrip(){
        axios
        .get('api/payments/create-connect-stripe',{
            params:{
                user: this.$page.props.auth.user,
            }
        })
        .then(response =>{
            console.log(response.data.original.url);
            this.openNewWindow(response.data.original.url);
        })
        .catch();
    },
    getStripLink(){
        console.log("getting link");
        axios
        .get('api/payments/get-stripe-link',{
            params:{
                account_id: this.accountId,
            }
        })
        .then(response =>{
            this.openNewWindow(response.data.url);
        })
        .catch();
    },
    openNewWindow(url){
          const newWindow = window.open(url, '_blank', 'width=800,height=600');

          if (newWindow) {
            console.log("New window opened");
          } else {
            alert('Popup blocker may have blocked the new window. Please check your browser settings.');
          }
    },
    stripeAccountExist(){
        axios
        .get('api/payments/stripe-account-exist',{
            params:{
                user: this.$page.props.auth.user
            }
        })
        .then(response=>{
            if (response.data.stripe_account) {
              this.accountId = response.data.stripe_account.account_id;
              this.onBoardingFinished();
            }else{
                this.accountId = null;
            }
        })
        .catch();
    },
    onBoardingFinished(){
        axios
        .get('api/payments/check-onboarding',{
            params:{
                account_id: this.accountId,
            }
        })
        .then(response=>{
            this.isFullyOnboarded = response.data.details_submitted;
        })
        .catch();
        return true;
    },
  },
};
</script>