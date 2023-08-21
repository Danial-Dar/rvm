<template>
  <div class="pb-10">
    <div class="px-3 lg:px-64">
      <div class="border rounded-lg p-2 bg-white-normal mb-5 shadow-md">
        <div class="flex items-center bg-white-normal px-3 relative">
          <div class="flex-1">
            <custom-card />
          </div>
        </div>
      </div>
      <div class="md:px-5 px-3 mb-5 text-center">
        <h2 class="font-bold text-lg text-primary">Billing Address</h2>
      </div>      
      <div class="border rounded-lg bg-white-normal mb-5 shadow-md">
        <div
          class="flex items-center rounded-t-lg bg-white-normal px-3 border-b"
        >
          <div class="w-1/2 md:w-1/6">First Name</div>
          <div class="flex-1">
            <input
              type="text"
              onkeypress="return /[a-z]/i.test(event.key)"
              class="focus:outline-none p-3 w-full"
              placeholder="John"
              v-model="result.firstName"
              required
            />
          </div>
        </div>
        <div class="flex items-center rounded-b-lg bg-white-normal px-3">
          <div class="w-1/2 md:w-1/6">Last Name</div>
          <div class="flex-1">
            <input
              type="text"
              onkeypress="return /[a-z]/i.test(event.key)"
              class="focus:outline-none p-3 w-full"
              placeholder="Doe"
              v-model="result.lastName"
              required
            />
          </div>
        </div>
      </div>
      <div class="border rounded-lg bg-white-normal mb-5 shadow-md">
        <div
          class="flex items-center rounded-t-lg bg-white-normal px-3 border-b"
        >
          <div class="w-1/2 md:w-1/6">Street Address</div>
          <div class="flex-1">
            <input
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Street Address" 
              v-model="billing_address.street"
              required
            />
          </div>
        </div>
        <div
          class="flex items-center rounded-t-lg bg-white-normal px-3 border-b"
        >
          <div class="w-1/2 md:w-1/6">Unit Number</div>
          <div class="flex-1">
            <input
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Unit Number" 
              v-model="billing_address.unit"
v-on:keypress="isNumber($event)"
            />
          </div>
        </div>        
        <div class="flex items-center bg-white-normal border-b px-3">
          <div class="w-1/2 md:w-1/6">City</div>
          <div class="flex-1">
            <input
           v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              ref='city'
              placeholder="City"
              v-model="billing_address.city"
              required
            />
          </div>
        </div>
        <!-- <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">State</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="State"
              v-model="billing_address.state"
              required
            />
          </div>
        </div> -->
        <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">State</div>
          <div class="flex-1">
            <select v-model="billing_address.state" class="focus:outline-none p-3 w-full" required>
              <option  value="">Select State</option>
              <option v-for="state in statesJson" :key="state.Code" :value="state.Code">{{ state.Code}}</option>
            </select>
          </div>
        </div>
        <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">Country</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Country"
              v-model="billing_address.country"
              disabled
              required
            />
          </div>
        </div>
       
         <!-- <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">Country</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Country"
              v-model="billing_address.country"

            />
          </div>
        </div> -->
        <div class="flex items-center rounded-b-lg bg-white-normal px-3">
          <div class="w-1/2 md:w-1/6">Zip</div>
          <div class="flex-1">
            <input
              type="number"
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              maxlength="5"
              class="focus:outline-none p-3 w-full"
              placeholder="Zip"
              v-model="billing_address.zip"

            />
          </div>
        </div>
      </div>

      <div class="md:px-5 px-3 mb-5 text-center">
        <h2 class="font-bold text-lg text-primary">Shipping Address</h2>
      </div> 

      <div class="border rounded-lg bg-white-normal mb-5 shadow-md">
        <div
          class="flex items-center rounded-t-lg bg-white-normal px-3 border-b"
        >
          <div class="w-1/2 md:w-1/6">Street Address</div>
          <div class="flex-1">
            <input
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Street Address" 
              v-model="shipping_address.street"
              required
            />
          </div>
        </div>
        <div
          class="flex items-center rounded-t-lg bg-white-normal px-3 border-b"
        >
          <div class="w-1/2 md:w-1/6">Unit Number</div>
          <div class="flex-1">
            <input
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Unit Number" 
              v-model="shipping_address.unit"
              v-on:keypress="isNumber($event)"
            />
          </div>
        </div>        
        <div class="flex items-center bg-white-normal border-b px-3">
          <div class="w-1/2 md:w-1/6">City</div>
          <div class="flex-1">
            <input
           v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              ref='city'
              placeholder="City"
              v-model="shipping_address.city"
              required
            />
          </div>
        </div>
        <!-- <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">State</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="State"
              v-model="billing_address.state"
              required
            />
          </div>
        </div> -->
        <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">State</div>
          <div class="flex-1">
            <select v-model="shipping_address.state" class="focus:outline-none p-3 w-full" required>
              <option  value="">Select State</option>
              <option v-for="state in statesJson" :key="state.Code" :value="state.Code">{{ state.Code}}</option>
            </select>
          </div>
        </div>
        <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">Country</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Country"
              v-model="shipping_address.country"
              disabled
              required
            />
          </div>
        </div>
       
         <!-- <div class="flex items-center bg-white-normal px-3 border-b">
          <div class="w-1/2 md:w-1/6">Country</div>
          <div class="flex-1">
            <input
            v-on:keypress="isLetter($event)"
              type="text"
              class="focus:outline-none p-3 w-full"
              placeholder="Country"
              v-model="billing_address.country"

            />
          </div>
        </div> -->
        <div class="flex items-center rounded-b-lg bg-white-normal px-3">
          <div class="w-1/2 md:w-1/6">Zip</div>
          <div class="flex-1">
            <input
              type="number"
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              maxlength="5"
              class="focus:outline-none p-3 w-full"
              placeholder="Zip"
              v-model="shipping_address.zip"

            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
import CustomCard from "@/components/design/CustomCard.vue";
import VueCookies from 'vue-cookie';

export default {
  name: "Payment",
  components: {
    CustomCard

  },
  props: ['billing_address','shipping_address','countries','statesJson'],
  computed: {
    ...mapState({
      result: state => state.result
    })
  },
  mounted(){
    console.log('billing addres'+this.billing_address.unit)
    console.log('shipping addres'+this.shipping_address.unit)
  },
  data() {
    return {
      cardDetails: {
        brand: null,
        number: null,
        expiration: null,
        cvc: null,
        postalCode: null
      }
    };
  },
  methods: {
    isLetter(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if(/^[a-zA-Z\s]*$/.test(char)) return true; // Match with regex 
  else e.preventDefault(); // If not match, don't add to input text
},
isNumber(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if(/^[0-9]+$/.test(char)) return true; // Match with regex 
  else e.preventDefault(); // If not match, don't add to input text
},
    inputCardValue(e) {
      if (e.target.value.length >= 19) {
        this.$refs.expirationdate.focus();
      }
    },
    inputExpirationDate(e) {
      if (e.target.value.length >= 5) {
        this.$refs.securitycode.focus();
      }
    }
  }
};
</script>

<style scoped>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>