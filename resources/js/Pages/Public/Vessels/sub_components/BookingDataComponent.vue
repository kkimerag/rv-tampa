<template>
    <v-row>
        <v-col>
            <v-card>
                <v-card-title>
                    {{vessel_data.year}} {{vessel_data.make}} {{vessel_data.model}}
                </v-card-title>
                <v-card-subtitle>
                    {{vessel_data.location.city}}, {{vessel_data.location.state.name}} 
                </v-card-subtitle>
            </v-card>
    </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        vessel_data: Object
    },
  data() {
    return {
    };
  },
  
  mounted() {
    console.log(this.vessel_data);
  },

  create(){

  },

  methods: {
  },
};
</script>
