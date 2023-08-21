<template>
 <div >
   <div class="input-container">
    <input class="input-field" ref="number"  id="number" type="text" placeholder="Card number"  v-model="number" @input="validateCnumber" v-on:keydown="formatCardNumber"  v-on:keypress="isLetter($event)" required  maxlength="19"   name="usrnm">
    <img class="icon" id="icon" v-if="brand == 'unknown'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/mono/generic.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'visa'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/visa.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'mastercard'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/mastercard.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'jcb'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/jcb.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'amex'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/amex.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'discover'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/discover.svg?sanitize=true" alt="Generic Card">
    <img class="icon" id="icon" v-if="brand == 'dinersclub'" src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/diners.svg?sanitize=true" alt="Generic Card">
    
   </div>
     <div class="input-container">
      <input class="input-field-exp" ref="expiry" id="expiry" type="text" placeholder="MM/YY"   v-model="expiry" @input="validateCexpiry" v-on:keydown="formatCardExpiry"  @keyup.delete="backEvent"  v-on:keypress="isLetter($event)" required  maxlength="5" name="usrnm">
      <input class="input-field-cvc" ref="cvv" id="cvv" type="text" placeholder="Security code" v-model="cvv"  @input="validateCcvv" v-on:keypress="isLetter($event)" @keyup.delete="backEventCvc" required  maxlength="4" name="usrnm">
     </div>
      <div class="input-container">
      <input class="input-field-zip" ref="zip" id="zip" type="text" placeholder="Zip/Postal code" v-model="zip"  @input="validateCzip" v-on:keypress="isLetter($event)" @keyup.delete="backEventZip" required  maxlength="5" name="usrnm">
     </div>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import MaskedInput from 'vue-masked-input'
import { mapState } from "vuex";
import VueCookies from 'vue-cookie';

export default {
  name: "custom-card",
  
   
  data() {
    return {
      number: null,
      phone: null,
      expiry: null,
      cvv: null,
      zip: null,
      brand: 'unknown',
      // result: null,
    }
  },
  components: {
    FontAwesomeIcon,
    MaskedInput
  },
   computed: {
    ...mapState({
      result: state => state.result
    })
  },
  methods:{ 
    backEvent(){
      // console.clear()
      console.log('backbbbbbb')
        console.log('this.expiry')
      console.log(this.expiry)
      if(this.expiry === null || this.expiry === '' ){
      var  tNumber = this.number
      this.number = tNumber.substring(0, tNumber.length - 1)
      this.brand = 'unknown'
      document.getElementById('number').focus()
      }
      
    },
    backEventCvc(){
      // console.clear()
      console.log('backbbbbbb')
        console.log('this.cvc')
      console.log(this.cvv)
      if(this.cvv === null || this.cvv === '' ){
      var  tExpiry = this.expiry
      this.expiry = tExpiry.substring(0, tExpiry.length - 1)
      // this.brand = 'unknown'
      document.getElementById('expiry').focus()
      }
      
    },
    backEventZip(){
      // console.clear()
      console.log('backbbbbbb')
        console.log('this.zip')
      console.log(this.zip)
      if(this.zip === null || this.zip === '' ){
      var  tCvv = this.cvv
      this.cvv = tCvv.substring(0, tCvv.length - 1)
      // this.brand = 'unknown'
      document.getElementById('cvv').focus()
      }
      
    },
     formatCardNumber(){
      console.log('formatCardNumber')
      let number = this.number.replace(/\D/g, "")
      this.number = number ? number.match(/.{1,4}/g).join(' ') : '' 
      // console.log('this.number')
      // console.log(this.number)

      // VueCookies.set('number',)
      // return  this.number ? this.number.match(/.{1,4}/g).join(' ') : '';
    } ,
    formatCardExpiry(){
      console.log('formatCardNumber')
      // let expiry = this.expiry.replace(/\D/g, "")
      // this.expiry = expiry ? expiry.match(/.{1,2}/g).join('/') : ''; 
      // return  this.number ? this.number.match(/.{1,4}/g).join(' ') : '';
    } ,
     isLetter(e) {
  let char = String.fromCharCode(e.keyCode); // Get the character
  if(/^[0-9]+$/.test(char)) return true; // Match with regex 
  else e.preventDefault(); // If not match, don't add to input text
},
    backspaceExpiry(){
      console.log('backspaceExpiry')
    },
    validateCnumber() {
      let value = this.number
      this.result.card.number = value
      console.log('this.result.card.number')
      console.log(this.result.card.number)
      console.log(value)
        let visa = value
          .replace(/\D/g, "")
          .match(/^4[0-9]{12}(?:[0-9]{3})?$/);
          
        let master = value
        .replace(/\D/g, "")
        .match(/^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/);
        
          let jcb = value
        .replace(/\D/g, "")
        .match(/^(?:2131|1800|35\d{3})\d{11}$/);
        
          let amex = value
        .replace(/\D/g, "")
        .match(/^3[47][0-9]{13}$/);

        let discover = value
        .replace(/\D/g, "")
        .match(/^65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10})$/);
        
        let dinersclub = value
        .replace(/\D/g, "")
        .match(/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/);
        
          if(visa){
            console.log('visa')
            // console.log(visa.input.length)

            if(visa.input.length > 15){
            document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
            window.setTimeout(() => document.getElementById('expiry').focus(), 0);
            // alert(document.getElementById('expiry'))
            this.brand = 'visa'
      this.result.card.brand = 'visa'

            return false
            }
            // this.brand = 'visa'
          }
          
          if(master){
              document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
             window.setTimeout(() => document.getElementById('expiry').focus(), 0);
            this.brand = 'mastercard'
      this.result.card.brand = 'mastercard'

            return false
          }

          
          if(jcb){
             document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
            window.setTimeout(() => document.getElementById('expiry').focus(), 0);


            this.brand = 'jcb'
      this.result.card.brand = 'jcb'

            return false

          }

           
          if(amex){
             document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
            window.setTimeout(() => document.getElementById('expiry').focus(), 0);


            this.brand = 'amex'
      this.result.card.brand = 'amex'

            return false

          }

          if(discover){
              document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
            window.setTimeout(() => document.getElementById('expiry').focus(), 0);


            this.brand = 'discover'
      this.result.card.brand = 'discover'

            return false

          }

          if(dinersclub){
            document.getElementById('number').classList.remove('invalid-field')
            document.getElementById('icon').classList.remove('invalid-field')
            document.getElementById('number').classList.add('valid-field')
            document.getElementById('icon').classList.add('valid-field')
            window.setTimeout(() => document.getElementById('expiry').focus(), 0);


            this.brand = 'dinersclub'
      this.result.card.brand = 'dinersclub'

            return false

          }
          document.getElementById('number').classList.remove('valid-field')
          document.getElementById('icon').classList.remove('valid-field')
          document.getElementById('number').classList.add('invalid-field')
          document.getElementById('icon').classList.add('invalid-field')
          this.brand = 'unknown'
    },
    validateCexpiry(event){
      if(!this.expiry.includes('/')){
      let expiry = this.expiry.replace(/\D/g, "")
      this.expiry = expiry ? expiry.match(/.{1,2}/g).join('/') : ''; 
     
      }
       let value = this.expiry

      this.result.card.expiration = value
      console.log('this.result.card.expiration')
      console.log(this.result.card.expiration)

      console.log( value.replace(/[^0-9\.]+/g, "").length)
      var input = document.getElementById('expiry');
    console.log('input')
    console.log(input.value.replace(/[^0-9\.]+/g, "").length)
    
      input.addEventListener('keydown', function(event) {
      const key = event.key;
      // console.log('key')
      // console.log(key)
      if (key === "Backspace" && input.value.replace(/[^0-9\.]+/g, "").length == 0) {
        document.getElementById('number').focus()
        console.log('backspace')
        return
      }
      });

      let month = value.split('/')[0]
      let year = value.split('/')[1]

      let currentYear = new Date().getYear()
      let currentMonth = new Date().getMonth()

      let  today = new Date();
      let someday = new Date();
      someday.setFullYear('20'+year, month, 1);

      if (someday > today) { //valid
        console.log('someday > today')
        console.log(value)
        // document.getElementById('cvv').focus()
        if(value.length == 5)
             window.setTimeout(() => document.getElementById('cvv').focus(), 0);

      return false
      }else{
        console.log('someday < today')

        console.log(value)
      }

      if(month < currentMonth) {console.log('month not valid')}
    
    },
    validateCcvv(event){
      var self = this;
      let value = this.cvv.replace(/[^0-9\.]+/g, "")
      // if(value.includes('_')){
      this.result.card.cvc = value
      console.log('this.result.card.cvc')
      console.log(this.result.card.cvc)
      // }
         console.log( value.replace(/[^0-9\.]+/g, "").length)
      var input = document.getElementById('cvv');
      var newExpiry = this.expiry
      console.log('input')
      console.log(input.value.replace(/[^0-9\.]+/g, "").length)
      input.addEventListener('keydown', function(event) {
      const key = event.key;
      // console.log('key')
      // console.log(key)
      if (key === "Backspace" && input.value.replace(/[^0-9\.]+/g, "").length == 0) {
        // document.getElementById('expiry').focus()
        // this.expiry = this.expiry.slice(0,-1)
        console.log('this.expiry')
        // console.log(self.expiry.slice(0,-1))
        var  tExp = self.expiry
        // console.log('self.expiry.length')
        // console.log(self.expiry.length)
        if(self.expiry.length === 5){
        self.expiry = tExp.substring(0, tExp.length - 1)
        }
        // console.log(self.expiry)
        // console.log(document.getElementById('expiry').value.slice(0,-1))
        window.setTimeout(() => document.getElementById('expiry').focus(), 0);

        console.log('backspace')
        return
      }
      });
      console.log('value')
      console.log(value)
      console.log(value.length)
      if(this.brand == 'amex' && value.length == 4){
        // document.getElementById('zip').focus()
      window.setTimeout(() => document.getElementById('zip').focus(), 0);

      }

      if(this.brand !== 'amex' && value.length == 3){
        // document.getElementById('zip').focus()
        window.setTimeout(() => document.getElementById('zip').focus(), 0);


      }
    },
    validateCzip(){
      var self = this
      let value = this.zip.replace(/[^0-9\.]+/g, "")

      this.result.card.postalCode = value
      console.log('this.result.card.postalCode')
      console.log(this.result.card.postalCode)
      
      console.log( value.replace(/[^0-9\.]+/g, "").length)
      var input = document.getElementById('zip');
      console.log('input')
      console.log(input.value.replace(/[^0-9\.]+/g, "").length)
      input.addEventListener('keydown', function(event) {
      const key = event.key;
      // console.log('key')
      // console.log(key)
      var card = { number: this.number, expiry: this.expiry, cvv: this.cvv, zip: this.zip, brand: this.brand}
      console.log(this.number)
      VueCookies.set('card', JSON.stringify(card))
      if (key === "Backspace" && input.value.replace(/[^0-9\.]+/g, "").length == 0) {
        // document.getElementById('cvv').focus()
        var  tExp = self.cvv
        // console.log('self.expiry.length')
        // console.log(self.expiry.length)
        if(self.cvv.length >=3){
        self.cvv = tExp.substring(0, tExp.length - 1)
        }
        window.setTimeout(() => document.getElementById('cvv').focus(), 0);

        console.log('backspace')
        return
      }
      });
    }
  },
 
};
</script>
<style scoped>
.input-container {
  display: flex;
  height: 50px;
  width: 100%;
  margin-bottom: 15px;
}

/* Style the form icons */
.icon {
  padding: 10px;
  background: white;
  color: #0CA2AD;
  max-width: 50px;
  text-align: center;
  border: 1px solid #e2e8f0;
  border-left: none;

  /* border: 1px solid; */
}

/* Style the input fields */
.input-field {
  width: 100%;
  padding: 10px;
  outline: none;
  border: 1px solid #e2e8f0;
  border-right: none;

}
.valid-field{
  border: 1px solid rgba(63, 243, 63, 0.863);
  background-color: rgba(248, 255, 248, 0.863);

}
.invalid-field{
  border: 1px solid rgba(243, 63, 63, 0.863);
  background-color: rgba(255, 242, 242, 0.863);

}
.input-field-exp {
  width: 50%;
  padding: 10px;
  /* margin-left: 10%; */
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  /* border-right: none; */
  outline: none;

}

.input-field-cvc {
  width: 50%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-left: none;
  /* border-right: none; */
  outline: none;
  /* overflow: none; */

}
.input-field-zip {
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  outline: none;

}

.input-field:focus {
  outline: none;
}


</style>