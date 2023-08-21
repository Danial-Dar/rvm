<template>
  <div class="mb-2 md:ml-0 ">
    <div class="flex">
      <div class="flex  mb-0 mr-1 md:mr-2">
        <input
          :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
          class="
            widthhh
            w-full
            rounded-tl-lg rounded-bl-lg
            bg-white
            border
            focus:outline-none
            p-1
            md:p-3
          "
          style="width: 45px"
          v-model="month"
          placeholder=""
          :name="name"
          type="tel"
          id="month"
          :required="required"
          :size="800"
          ref="m"
          @input="validateMonth"

        />
        <div class="md:p-3 py-5 pr-1 pl-1 bg-gray-300 rounded-tr-lg rounded-br-lg">MM</div>
      </div>
      
      <div class="flex mr-1 md:mr-2">
        <input
          :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
          class="
            widthhh
            w-full
            rounded-tl-lg rounded-bl-lg
            bg-white
            border
            focus:outline-none
            p-1
            md:p-3
          "
          style="width: 45px"
          v-model="day"
          placeholder=""
          :name="name"
          type="tel"
          id="day"
          :required="required"
          :size="800"
          ref="d"
          max
          @input="validateDay"
        />
        <div class="md:p-3 py-5 pr-1 pl-1 bg-gray-300 rounded-tr-lg rounded-br-lg">DD</div>
      </div>

      <div class="flex flex-1">
        <input
          :class="{ 'border-red-300 placeholder-red-300': v && v.$error }"
          class="
            widthh
            w-full
            rounded-tl-lg rounded-bl-lg
            bg-white
            border
            focus:outline-none
            p-1
            md:p-3
          "
          style="width: 65px"
          v-model="year"       
          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
          maxlength="4"
          placeholder=""
          :name="name"
          type="tel"
          id="year"
          :required="required"
          :size="800"
          ref="y"
          @input="validateYear"

         
        />
        <div class="md:p-3 py-5 pr-1 pl-1  bg-gray-300 rounded-tr-lg rounded-br-lg">YYYY</div>
      </div>
  


    </div>
<template v-if="v">
      <span
        class="text-red-500 text-xs ml-1"
        v-if="v.$anyError && v.required == false"
        >Field is required</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-if="v.$anyError && v.email == false"
        >Email is not valid</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-else-if="v.$anyError && v.minLength == false"
        >Field value is not in minimum allowed range</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-else-if="v.$anyError && v.maxLength == false"
        >Field value is beyond maximum allowed range</span
      >
      <span v-else></span>
    </template>
    <template v-if="isInvalid">
      <span
        class="text-red-500 text-xs ml-1"
        v-if="isInvalidMonth"
        >You entered month greater that 12, don't worry we changed it</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-if="isInvalidDay"
        >You entered days greater that 31, don't worry we changed it</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-if="isInvalidDate"
        >Date doesn't exist, please check</span
      >
      <span
        class="text-red-500 text-xs ml-1"
        v-if="isInvalidYear"
        >Your age is below 18 years</span
      >
      <span v-else></span>
    </template>


  </div>
</template>
<script>
// import Card from "@/components/design/Card.vue";
import moment from 'moment'
export default {
  data() {
    return {
      month: '',
      day: '',
      year: '',
      isInvalid: false,
      isInvalidMonth: false,
      isInvalidYear: false,
      isInvalidDate: false,
    }
  },
  components: {
    // Card,
  },
  props: {
    type: {
      type: String,
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: true,
    },
    result: {
      type: Object,
      default: null,
    },
    v: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    console.clear()
     let vm = this
  let name = vm.name
  console.log(name)
    console.log(this.result[name].split('-')[0])
  this.year = this.result[name].split('-')[0]
  this.month = this.result[name].split('-')[1]
  this.day = this.result[name].split('-')[2]
  },
  methods: {
    validateMonth(){
      // console.log(this.month)
      var MaxLength = 2;
        $(document).ready(function () {
        $('#month').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#month').blur();
                $('#day').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
      if(this.month > 12 ){
        this.isInvalid = true
        this.isInvalidMonth = true
        //  this.month = Math.floor(this.month / 10)
         this.month = 12
         console.log(this.month)
        var MaxLength = 2;
        $(document).ready(function () {
        $('#month').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#month').blur();
                $('#day').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
      this.$refs.d.focus()
      
      }
      else if(this.month > 1 && this.month <= 9){
        // this.month = '0' + this.month
        // console.log(this.month)
         var MaxLength = 2;
        $(document).ready(function () {
        $('#month').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#month').blur();
                $('#day').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.d.focus()
         
        
      }
      else if(this.month == '01' ){

          // alert(this.month)
           var MaxLength = 2;
        $(document).ready(function () {
        $('#month').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#month').blur();
                $('#day').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.d.focus()

      }else if(this.month >= 10 && this.month <= 12  ){

          // alert(this.month)
         var MaxLength = 2;
        $(document).ready(function () {
        $('#month').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#month').blur();
                $('#day').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.d.focus()

      }


    var date = moment(this.year + "-" + ((this.month.length == 2 ) ? this.month : ('0' + this.month))  + "-" + ((this.day.length == 2 ) ? this.day : ('0' + this.day)), true );

  var storeDate = this.year + "-" + this.month + "-" + this.day

            if(!date.isValid()){
                    this.isInvalid = true
                    this.isInvalidDate = 
                    this.$emit("input", null);
                    
            }else{
                    this.isInvalid = false
              this.isInvalidYear = false

                    this.isInvalidDate = 
                    this.$emit("input", storeDate);
            // result['date'] = date 
      // this.v.isValid = true
            }
    },
    validateDay(){
        this.isInvalid = false
        this.isInvalidMonth = false
        var MaxLength = 2;
        $(document).ready(function () {
        $('#day').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#day').blur();
                $('#year').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
  
      if(this.day > 31 ){
        this.isInvalid = true
        this.isInvalidDay = true
    
         this.day = 31
        //  console.log(this.month)
        var MaxLength = 2;
        $(document).ready(function () {
        $('#day').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#day').blur();
                $('#year').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.y.focus()
      }else if(this.day > 3 && this.day <= 31){
        var MaxLength = 2;
        $(document).ready(function () {
        $('#day').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#day').blur();
                $('#year').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.y.focus()
      }else if(this.day == '01' || this.day == '02' || this.day == '03' ){
        var MaxLength = 2;
        $(document).ready(function () {
        $('#day').keyup(function () {
            if ($(this).val().length >= MaxLength) {
               $('#day').blur();
                $('#year').focus();
               
             //  $('#MyTB2').focus();
         }
        }); 
      });
         this.$refs.y.focus()
      }

      var date = moment(this.year + "-" + ((this.month.length == 2 ) ? this.month : ('0' + this.month))  + "-" + ((this.day.length == 2 ) ? this.day : ('0' + this.day)), true );
  var storeDate = this.year + "-" + this.month + "-" + this.day


      if(!date.isValid()){
              this.isInvalid = true
              this.isInvalidDate = 
              this.$emit("input", null);
              
      }else{
              this.isInvalid = false
              this.isInvalidYear = false
              this.isInvalidDate = 
              this.$emit("input", storeDate);
      // result['date'] = date 
// this.v.isValid = true
      }

    },
    validateYear(){
      console.log(this.name)
        this.isInvalid = false
        this.isInvalidMonth = false
        this.isInvalidDate = false
        this.isInvalidDay = false
        this.isInvalidYear = false
      
      if((this.name !== 'papSmearDate') &&(  (moment().format('YYYY') - this.year <= 18) )){
        this.isInvalid = true
        this.isInvalidYear = true
        this.$emit("input", null);

      }else{

    var date = moment(this.year + "-" + ((this.month.length == 2 ) ? this.month : ('0' + this.month))  + "-" + ((this.day.length == 2 ) ? this.day : ('0' + this.day)), true );
  console.log(this.year + "-" + ((this.month.length == 2 ) ? this.month : ('0' + this.month))  + "-" + ((this.day.length == 2 ) ? this.day : ('0' + this.day)))
  var storeDate = this.year + "-" + this.month + "-" + this.day


      if(!date.isValid()){
              this.isInvalid = true
              this.isInvalidDate = 
              this.$emit("input", null);
              
      }else{
              this.isInvalid = false
              this.isInvalidYear = false
              this.isInvalidDate = 
              this.$emit("input", storeDate);
              
              
              
      // result['date'] = date 
// this.v.isValid = true
      }
      }


      console.log(date.isValid())

    }
  },
};
</script>
<style>
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