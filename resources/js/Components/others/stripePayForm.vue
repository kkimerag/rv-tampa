<template>
	<v-row>
	  <v-col>
	    <v-form id="payment-form" @submit.prevent="handleSubmit">
	      <div id="payment-element">
	        <!-- Elements will create form elements here -->
	      </div>
	      <button id="submit" class="v-btn v-btn--flat v-theme--light bg-light-blue-darken-4 v-btn--density-default v-btn--size-default v-btn--variant-elevated mt-4">Confirm</button>
	      <div id="error-message">
	        <!-- Display error message to your customers here -->
	      </div>
	    </v-form>
	  </v-col>
	</v-row>
	 <v-snackbar
	 v-model="snackbar"
	 :timeout="2000"
	 :color="snackColor"
	 rounded="pill"
	>
	  {{ snackText }}

	</v-snackbar>
</template>

<script type="text/javascript">
	export default{
		props:{
			paymentSecret      : String,
			publishableKey     : String,
			connectedAccountId : String,
		},
		data() {
			return{
				stripe:null,
				elements: null,
				snackbar: false,
				snackColor: null,
				snackText: null,
			}
		},
		mounted() {
			// this.currentURL = window.location.href.pathname;
			let urlObject = new URL(window.location.href);
			console.log(urlObject);
			this.currentURL = urlObject.protocol+'//'+urlObject.host;
			console.log(this.currentURL);
			this.initializeStripe();
		},
		methods:{
			async handleSubmit() {
			    // We don't want to let default form submission happen here,
			    // which would refresh the page.
			    event.preventDefault();

			    if (!this.stripe || !this.elements) {
			      // Stripe.js hasn't yet loaded.
			      // Make sure to disable form submission until Stripe.js has loaded.
			      return;
			    }

			    const {error} = await this.stripe.confirmPayment({
			      //`Elements` instance that was used to create the Payment Element
			      elements: this.elements,
			      confirmParams: {
			        return_url: this.currentURL,
			      },
			    });


			    if (error) {
			      // This point will only be reached if there is an immediate error when
			      // confirming the payment. Show error to your customer (for example, payment
			      // details incomplete)
			      this.snackText = error.message
			      this.snackColor = "red-lighten-1";
			      this.snackbar = true;
			    } else {
			      // Your customer will be redirected to your `return_url`. For some payment
			      // methods like iDEAL, your customer will be redirected to an intermediate
			      // site first to authorize the payment, then redirected to the `return_url`.
			    }
			  },
			async initializeStripe() {
			  const script = document.createElement('script');
			  script.src = 'https://js.stripe.com/v3/';
			  script.async = true;
			        script.onload = () => {
			          this.stripe = Stripe(this.publishableKey  ,{
						    stripeAccount: this.connectedAccountId, // Connected account ID
						}); //attacing the conected account
			          this.executePayment(this.paymentSecret);
			        };
			  document.head.appendChild(script);
			},
			executePayment(clienteSecret){
			  const options = {
			      clientSecret: clienteSecret,
			      appearance: {/*...*/},
			    };
			    this.elements = this.stripe.elements(options);
			    const paymentElement = this.elements.create('payment');
			    paymentElement.mount('#payment-element');
			},
		}
	}
</script>

<style type="text/css">
	#submit{

	}
</style>