<template>
	<v-row>
		<v-col>
			<v-text-field 
			v-model='user_data.name'
			:rules="[rules.required]"
			label='Name'
			>
		</v-text-field>
		</v-col>
		<v-col>
			<v-text-field 
			v-model='user_data.lastName'
			:rules="[rules.required]"
			label='Last Name'
			>
		</v-text-field>
		</v-col>
	</v-row>
	<v-row>
		<v-col>
			<v-text-field 
			v-model='user_data.email'
			:rules="[rules.required , rules.email]"
			label='Email'
			>
		</v-text-field>
		</v-col>
		<v-col>
			<v-text-field 
			v-model='user_data.phone'
			:rules="[rules.required , rules.phone ]"
			label='Phone'
			>
		</v-text-field>
		</v-col>
	</v-row>
	<v-row>
		<v-col>
			<v-checkbox v-model='agreed'>
			<template v-slot:label>
			    <span>I certify that I am at least 25 years old at the time of rental and I have a valid drivers license.</span>
			  </template>
			</v-checkbox>
			<v-row>
				<v-col>
					<v-sheet class='text-xs'>
						By clicking "Agree & Continue", you are agreeing to the <a href="">RVshare Terms of Service</a>, <a href="">Insurance and Protection Terms</a>, <a href="">Privacy Policy</a>, and to receive booking-related texts. Standard messaging rates may apply
					</v-sheet>
				</v-col>
				<v-col>
					<v-btn 
					:disabled='!allValidation'
					flat
					color='light-blue-darken-4'
					@click="next"
					>
						Agree & Continue
					</v-btn>
				</v-col>
			</v-row>
		</v-col>
	</v-row>
</template>
<script type="text/javascript">
	export default {
	    props: {
	        expanded_panel: Array,
	        user_data: Array,
	    },
	  data() {
	    return {
	        agreed :false,
	        rules: {
				required: value => !!value || 'Field is required',
				email: value => {
		            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		            return pattern.test(value) || 'Invalid e-mail.'
		        },    
		        phone: value => {
	              // Add your phone validation logic here
	              // For example, you can use a regular expression to validate the phone number
	              const phoneRegex = /^\d{10}$/;
	              return phoneRegex.test(value) || 'Invalid phone number';
	            },
			},
	    };
	  },
	  computed:{
	  	allValidation(){
	  		const allDataPresent = this.user_data.name && this.user_data.lastName && this.user_data.email && this.user_data.phone;
	  		const isEmailValid = this.rules.email(this.user_data.email) === true;
	  		const isPhoneValid = this.rules.phone(this.user_data.phone) === true;

	  		return this.agreed && allDataPresent && isEmailValid && isPhoneValid;
	  	}
	  },
	  mounted() {
	  	  	// this.user_data = [
	  	  	// 	name     => null,
	  	  	// 	lastName => null,
	  	  	// 	email    => null,
	  	  	// 	phone    => null,
	  		// ];
	  },

	  create(){

	  },

	  methods: {
	  	next(){
	  		this.expanded_panel[0] = 2;
	  	},
	  },
	};
</script>