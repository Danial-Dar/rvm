<template>
  <div>

    <div v-show='!isManual' class="flex flex-wrap">
      <TextField
        :v="v"
        @backspace="compeleted = false"
        @input="onInput"
        id="location"
        v-model="location"
        type="text"
        :value="value"
        class="mb-0 shadow-none w-full"
        :required="required"
        placeholder="Address"
      />
     
      <div class="pac-item form-control" v-show="showCantFindAddress" >
        <ul>
        <li v-for="(result, i) in searchResults" :key="i">
         <div class="pac-item-row pac-item-query pac-icon-marker border-b-2 mb-1" @click="selectAddress(result)">{{ result }}</div>  
        </li>
         <div class="pac-item-row pac-item-query" @click='changeToMap'>I Can't Find My Address</div>  
        </ul>
      </div>

      <TextField
        @backspace="compeleted = false"
        id="apt_no"
        v-model="result['unit_no']"
        type="tel"
        :value="value"
        class="mb-0 shadow-none w-full"
        placeholder="Unit No"
      />
     
    </div>

     <div v-show="showMap"  id="map" class="w-full h-64" style="margin-bottom: 20px"></div>

       <div v-show='isManual' class="flex flex-wrap">
      <TextField
        :v="v"
        @backspace="compeleted = false"
        id="location"
        v-model="address.street"
        type="text"
        class="mb-0 shadow-none w-full"
        placeholder="Street Address"
        @input="updateManual"
      />
       <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.unit"
          type="text"
          class="mb-0 shadow-none w-full"
          placeholder="Unit Number"
          @input="updateManual"
        />
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.state"
          type="text"
          name="state"
          class="mb-0 shadow-none w-full"
          placeholder="State"
          @input="updateManual"
        />        
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.country"
          type="text"
          name="state"
          class="mb-0 shadow-none w-full"
          readonly="{'readonly':true}"
          placeholder="Country"
          @input="updateManual"
        />
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.city"
          name="city"
          type="text"
          class="mb-0 shadow-none w-full"
          placeholder="City"
          @input="updateManual"
        />
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.zip"
          type="text"
          :value="value"
          class="mb-0 shadow-none w-full"
          placeholder="Zipcode"
          @input="updateManual"
        />
        <!-- <button type="button" style="color: #0CA2AD; border:none" v-show='isManual' @click='changeToMap'>Use Google Maps</button>       -->
    </div>
    <modal v-if="showErrorPopup == true" @close="showErrorPopup = false">
      <template slot="header">
        <div class="flex justify-between items-center">
          <div class="font-bold text-xl">Error</div>
          <div class="text-right py-2">
            <span @click="showErrorPopup = false">
              <font-awesome-icon class="cursor-pointer" icon="times" />
            </span>
          </div>
        </div>
      </template>
      <template slot="body">
        <p class="mb-2">
          Unfortunately, we can't assist customers located in this area.
        </p>
      </template>
    </modal>      
  </div>
</template>
<script>
import Modal from "@/components/design/Modal.vue";
export default {
  props: {
    required: {
      default: true,
      type: Boolean
    },
    v: {
      type: Object,
      required: true
    },
    value: {
      type: String,
      default: null
    },
    fields: {
      type: Array,
      default: () => {
        return [];
      }
    },
    result: {
      type: Object,
      default: null
    }
  },
  data() {
      return {
        tempAddress: "",
        showCantFindAddress: false,
        counter: 0,
        location: "",
        map: null,
        errState:"",
        places: null,
        compeleted: false,
        searchResults: [],
        service: null, // will reveal this later 🕵️
        markers: [],
        searchResults: [],
        marker: null,
        showMap: false,
        showErrorPopup: false,
        isManual: true,
        address: {
          street: null,
          unit: null,
          state: null,
          city: null,
          zip: null,
          country: "US",
        }
      }
  },
  components: {
    Modal
  },
  methods: {
      changeToMap(){
        this.address = {
          street: null,
          unit: null,
          state: null,
          city: null,
          zip: null,
        }
        this.location = null
        this.isManual = !this.isManual
        this.searchResults = []
        this.$emit("input", null);
      },
      
      updateManual(){
      if(this.address.street !== null && this.address.city && this.address.state && this.address.zip && this.address.country ){
      
      let ad = this.address.street + ',' + this.address.city + ',' + this.address.state + ',' + this.address.zip + ','+ this.address.unit + ',' + this.address.country  + ',manual'  
      this.$emit("input", ad);
      
      }else{
      this.$emit("input", null);
      }      
    },
      selectAddress(result){
          console.log('result')
          console.log(result)
          this.showMap = false;

            let lengthSplit = result.split(',').length
            let country = result.split(',')[lengthSplit - 1]
            let state = result.split(',')[lengthSplit - 2]
            
            // const place = this.service.getPlace();
            console.log(this.service)
            console.log(state)
            console.log(result.split(',').length)
            console.log(result.split(',')[lengthSplit - 1])
            
            if(country !== ' USA'){
              this.showErrorPopup = true;
                console.log('We cannot work other than USA')
                this.searchResults = []
                this.location = null
                this.showMap = false
                this.showCantFindAddress = false
                this.$emit('input',null)
                return
            }

            if(state === ' LA' || state === ' NJ' || state === ' AR' || state === ' AK'   ){
              this.showErrorPopup = true;
               this.searchResults = []
                this.location = null
                this.showMap = false
                this.showCantFindAddress = false
                this.$emit('input',null)
                console.log('We cannot work other this State')
                return
            
            }

            let geocoder = new window.google.maps.Geocoder();
            
            geocoder.geocode( { 'address' : result }, function( results, status ) {
            
            if( status == google.maps.GeocoderStatus.OK ) {
                let lat = results[0].geometry.location.lat()
                let lng = results[0].geometry.location.lng()
                // this.showMap = true
                console.log(document.getElementById("map"))
                if(typeof document.getElementById("map") !== undefined){
                const map = new window.google.maps.Map(document.getElementById("map"), {
                    center: { lat: lat, lng: lng },
                    zoom: 8,
            });
            
            let latLng ={ lat: lat, lng: lng }
                new google.maps.Marker({
                position: latLng,
                map,
                title: "Hello World!",
            });
            
            }
            
            
            } else 
                {
                  console.log( 'Geocode was not successful for the following reason: ' + status );
                }               
               } );
            this.showMap = true;
            this.searchResults = []
            this.location = result
            this.showCantFindAddress = false
            this.$emit("input", result);
      },
        
      displaySuggestions (predictions, status) {
        if (status !== window.google.maps.places.PlacesServiceStatus.OK) {
          this.searchResults = []
          return
        }
        console.log('predictions')
        console.log(predictions)
        this.searchResults = predictions.map(prediction => prediction.description) 
// let addressComponent = predictions.map(prediction => prediction.address_components) 
        console.log('this.searchResults')
        console.log(this.searchResults)
        // console.log(addressComponent)
      },
  onInput() {
      this.v = null
         this.service = new window.google.maps.places.AutocompleteService()
         this.showMap = false
      if(this.location.length === 0){
          this.showCantFindAddress = false
       this.$emit("input", null);

      }

      if(this.location.length > 1){
        this.showCantFindAddress = true
        this.service.getPlacePredictions({
          input: this.location,
          fields: ["address_components", "geometry", "name"],
          types: ["address"]
        }, this.displaySuggestions)
        console.log(this.location)
      }else{
        this.searchResults = []
      }
  }  
  },
  mounted() {
    console.log(this.result["address"])
    let length = this.result["address"].split(',').length
    if(this.result["address"].split(',')[length - 1] === 'manual' ){
        this.isManual = true
        this.showMap = false
        this.address.street = this.result["address"].split(',')[0]
        this.address.city = this.result["address"].split(',')[1]
        this.address.state = this.result["address"].split(',')[2]
        this.address.country = this.result["address"].split(',')[5]
        this.address.zip = this.result["address"].split(',')[3]
        this.address.unit = this.result["address"].split(',')[4]
    }else{
      this.location = this.result["address"]
      this.selectAddress(this.location)
    }
    // console.log(this.result["address"].split(',')[length - 1])
  },  
};

</script>
<style >
.pac-item{
  background-color: #0CA2AD !important;
  width: 100%;
}
.pac-item-query{
  color: white;
  background-color: transparent !important;
}
.pac-item-row{
  line-height: 1.6;
  width: 100%;
  cursor: pointer;
}
.pac-item-row:hover{
  background-color: #5ed1da !important;      
}
</style>