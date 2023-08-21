<template>
  <div>

    <div v-show='!isManual' class="flex flex-wrap">
      <TextField
        :v="v"
        @backspace="compeleted = false"
        id="location"
        v-model="location"
        type="text"
        :value="value"
        class="mb-0 shadow-none w-full"
        :required="required"
        placeholder="Address"
      />
      <div  class="pac-item form-control"  v-if="showCantFindAddress" @click='isManual = !isManual' style="z-index:1001; width:100%; margin-top: -8px">
        <span class="pac-icon pac-icon-marker"></span>
        <span class="pac-item-query">
          <button type="button"  >I can't find my address</button>
        </span>
      </div>
      <TextField
        @backspace="compeleted = false"
        id="apt_no"
        v-model="result['unit_no']"
        type="tel"
        class="mb-0 shadow-none w-full"
        placeholder="Unit No"
      />
    </div>
    <div v-show='isManual' class="flex flex-wrap">
      <TextField
        :v="v"
        @backspace="compeleted = false"
        id="location"
        v-model="address.street"
        type="text"
        :value="value"
        class="mb-0 shadow-none w-full"
        placeholder="Street Address"
      />
      <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.unit"
          type="text"
          :value="value"
          class="mb-0 shadow-none w-full"
          placeholder="Unit Number"
        />
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.state"
          type="text"
          :value="value"
          name="state"
          class="mb-0 shadow-none w-full"
          placeholder="State or Country"
        />
        
        <TextField
          :v="v"
          @backspace="compeleted = false"
          id="location"
          v-model="address.city"
          name="city"
          type="text"
          :value="value"
          class="mb-0 shadow-none w-full"
          placeholder="City"
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
        
    </div>
    
    <div v-show="showMap" id="map" class="w-full h-64" style="margin-bottom: 20px"></div>
<!-- <button type="button" style="color: #0CA2AD; border:none" v-show='!isManual' @click='isManual = !isManual'> add manually </button> -->
<button type="button"  style="color: #0CA2AD; border:none" v-show='isManual' @click='isManual = !isManual'> use google maps </button>
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
          Unfortunately, we can't assist customers located in {{tempAddress}}
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
  data: () => ({
    tempAddress: null,
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
    marker: null,
    showMap: false,
    showErrorPopup: false,
    isManual: false,
    address: {
      street: '',
      unit: '',
      state: '',
      city: '',
      zip: '',
    }
  }),
  components: {
    Modal
  },
  methods: {
    
    updateManual(){
      let ad = this.address.street + ',' + this.address.city+ ',' + this.address.state+ ',' + this.address.zip + ','+ this.address.unit  
      this.$emit("input", ad);
    },
    cantFind(){
alert('checked')
    },
    addressNotFound(){
console.log('addressNotFound')
    },
    MapsInit() {
      console.log('MapsInit')
      console.log(this.location)
      // alert('sdsd')
      // console.log('sss')
      let address1Field = document.querySelector("#location input");
      this.service = new window.google.maps.places.Autocomplete(address1Field, {
        fields: ["address_components", "geometry", "name"],
        types: ["address"]
      });
      address1Field.focus();
      this.service.addListener("place_changed", this.fillInAddress);
      this.map = new window.google.maps.Map(document.getElementById("map"), {
        
        center:
          this.result.latLng !== undefined
            ? this.result.latLng
            : { lat: -34.397, lng: 150.644 },
        zoom: 8
      });
      this.places = new google.maps.places.PlacesService(this.map);
      this.map.addListener("click", e => {
        this.placeMarkerAndPanTo(e.latLng, this.map);
      });
      if (this.result.latLng !== undefined) {
          document.getElementById("map").show();

        this.placeMarkerAndPanTo(this.result.latLng, this.map);
      }else{
          console.log('err')
          document.getElementById("map").hide() ;
      }
    },
    placeMarkerAndPanTo(latLng, map) {
      console.log('placeMarkerAndPanTo')

      this.marker = new google.maps.Marker({
        position: latLng,
        map: map
      });
      map.panTo(latLng);
    },
    clearMarker() {
      console.log('ClearMArker')

      if (this.marker !== null) {
        this.marker.setMap(null);
      }
    },
    displaySuggestions(predictions, status) {
      console.log('displaySuggestions')

      if (status !== window.google.maps.places.PlacesServiceStatus.OK) {
        this.searchResults = [];
        return;
      }
      this.searchResults = predictions.map(
        prediction => prediction.description
      );
    },
    selectLocation(value) {
      console.log('selectLocation')

      // console.log('sss')

      this.location = value;
      this.compeleted = true;
      this.$emit("input", value);
    },
    fillInAddress() {
      console.log('fillInAddress')

const place = this.service.getPlace();
// console.log(place)
      let postalCode = "";
      let city = "";
      let state = "";
      let country = "";
      let street = "";
      this.clearMarker();
      
      for (const component of place.address_components) {

        const componentType = component.types[0];

        switch (componentType) {
          case "street_number": {
            street = `${component.long_name} ${street}`;
            break;
          }

          case "route": {
            street += component.short_name;
            break;
          }

          case "postal_code": {
            postalCode = `${component.long_name}${postalCode}`;
            break;
          }

          case "postal_code_suffix": {
            postalCode = `${postalCode}-${component.long_name}`;
            break;
          }
          case "locality":
            city = component.long_name;
            break;

          case "administrative_area_level_1": {
            // state = component.short_name;
            state = component.long_name;
            this.tempAddress = component.long_name;
            if (state == "Louisiana" || state == "New Jersey" || state == "Arkansas" || state == "Alaska") {
              this.showErrorPopup = true;
              this.showCantFindAddress = false
              this.errState = state
              document.querySelector("#location input").value = "";
              return;
            }
            break;
          }
          case "country":
            country = component.long_name;
            if (country !== "United States") {
              this.showErrorPopup = true;
              document.querySelector("#location input").value = "";
              return;
            }
            break;
        }
      }
      this.result["addressObject"] = {
        streetAddress: street,
        city: city,
        state: state,
        postalCode: postalCode,
        country: country
      };
      this.showCantFindAddress = false
      // console.log(place)
      if (place.geometry && place.geometry.location) {
        // alert('sdsdsdsd')
        this.map.panTo(place.geometry.location);
        this.placeMarkerAndPanTo(place.geometry.location, this.map);
        this.result.latLng = {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng()
        };
        this.map.setZoom(15);
        //this.search();
      } else {
        // alert('sdsdsd')
        document.getElementById("autocomplete").placeholder = "Enter a city";
      }
      this.$emit("input", document.querySelector("#location input").value);
      this.showMap = true;
      this.$forceUpdate();
    }
  },
  mounted() {
    let vm = this;
    setTimeout(() => {
      vm.MapsInit();
      if (vm.value !== null) {
        vm.showMap = true;
      }
    }, 1000);
    this.location = this.value;
    if(this.location.length > 5) {this.showMap = true;}
  },
  watch: {
    location(newValue) {
      // alert('sdassd')
      
if(newValue.length > 0){
   this.showCantFindAddress = true
} 
  if(this.counter == 0){

      document.getElementsByClassName('pac-container')[0].innerHTML += '<div  class="pac-item"><span class="pac-icon pac-icon-marker"></span><span class="pac-item-query"><button type="button" id="notFoundBtn" >I can\'t find my address<button></span></div>';
      console.log(document.getElementsByClassName('pac-container')[0])

  }
  this.counter += 1;
      if (newValue == "" || newValue == null) {
        this.$emit("input", null);
      }
    },
  }
};

</script>
<style >
.pac-item-query{
  color: white;
  background-color: transparent !important;

}
.pac-item{
  background-color: #0CA2AD !important;
}
.pac-item:hover{
  background-color: #5ed1da !important;

 color: white !important;
}


</style>