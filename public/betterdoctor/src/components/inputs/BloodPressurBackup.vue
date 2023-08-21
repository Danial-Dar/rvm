<template>
  <div class="mb-2 md:ml-0">
    <div v-if="!showStep1 && !showStep2">
      <!-- <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your last blood pressure reading?</div> -->
      <div style="border: 1px solid gray !important; border-radius: 20px; padding: 30px; align-items: center; justify-content: center;">
        
        <div class="flex" style="align-items: center; justify-content: center; " >
            <div class="flex mb-0 mr-1 md:mr-2">
              <p class="labelBp">Top#</p>
              <div class="labelBpInside" style="width:75px; height:75px; border: 1px solid gray !important; margin-left:25px;  border-radius: 20px">118 </div>  
            </div>
        </div>
        <br>
        <div class="flex" style="align-items: center; justify-content: center;" >
            <div class="flex mb-0 mr-1 md:mr-2">
              <p class="labelBp">Bottom#</p>
              <div class="labelBpInside2" style="width:75px; height:75px; border: 1px solid gray !important;  border-radius: 20px">72 </div>  
            </div>
        </div>
     
      </div>
        
      

      <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your top number?</div>

      <div class="radio" >
        <div
          v-for="option in options"
          :key="option.value"
          class="border rounded bg-white-light p-3 mb-2"
          :class="{'red':option.value == '140+' ||option.value == '0-80','green':option.value == '101-120','yellow':option.value == '121-139' ||option.value == '81-100' }"
        >
          <input
            type="radio"
            :id="option.value"
            name="topNumber"
            class="mr-3"
            :value="option.value"
            @input="setTop(option, $event)"
          />
          <label class="text-grey-light text-lg" :for="option.value">{{
            option.text
          }}</label>
        </div>
      </div>

      <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your bottom number?</div>

      <div class="radio">
        <div
          v-for="option in optionsBottom"
          :key="option.value"
          class="border rounded bg-white-light p-3 mb-2"
          :class="{'red':option.value == '81 +' ||option.value == '0-50','green':option.value == '61-70','yellow':option.value == '71-80' || option.value == '51-60' }"

        >
          <input
            type="radio"
            :id="option.value"
            name="bottomNumber"
            class="mr-3"
            :value="option.value"
            @input="setBottom(option, $event)"
          />
          <label class="text-grey-light text-lg" :for="option.value">{{
            option.text
          }}</label>
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
        <span class="text-red-500 text-xs ml-1" v-if="isInvalidMonth"
          >You entered month greater that 12, don't worry we changed it</span
        >
        <span class="text-red-500 text-xs ml-1" v-if="isInvalidDay"
          >You entered days greater that 31, don't worry we changed it</span
        >
        <span class="text-red-500 text-xs ml-1" v-if="isInvalidDate"
          >Date doesn't exist, please check</span
        >
        <span class="text-red-500 text-xs ml-1" v-if="isInvalidYear"
          >Your age is below 18 years</span
        >
        <span v-else></span>
      </template>
    </div>
    <div v-if="showStep1">
      <div class="font-bold">
        Since you don't remember your exact blood pressure numbers, did your
        healthcare provider indicate any of the following about your blood
        pressure at your last vist?
      </div>
      <div class="radio">
        <div
          v-for="option in optionsStep1"
          :key="option.value"
          class="border rounded bg-white-light p-3 mb-2"
        >
          <input
            type="radio"
            :id="option.value"
            name="bottomNumber"
            class="mr-3"
            :value="option.value"
            @input="setStep1(option, $event)"
          />
          <label class="text-grey-light text-lg" :for="option.value">{{
            option.text
          }}</label>
        </div>
      </div>
    </div>
    <div v-if="showStep2 && !showStep1">
      <div class="font-bold">
       We will need you to take your blood pressure at a local pharmacy, grocery store, or with a healthcare provider.
      </div>
      <div class="radio">
        <div
          v-for="option in optionsStep2"
          :key="option.value"
          class="border rounded bg-white-light p-3 mb-2"
        >
          <input
            type="radio"
            :id="option.value"
            name="bottomNumber"
            class="mr-3"
            :value="option.value"
            @input="setStep2(option, $event)"
          />
          <label class="text-grey-light text-lg" :for="option.value">{{
            option.text
          }}</label>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueCookies from "vue-cookie";

export default {
  data() {
    return {
      top: null,
      bottom: null,
      topNumber: null,
      bottomNumber: null,
      step1: null,
      step2: null,
      showStep1: false,
      showStep2: false,
      isInvalid: false,
      isInvalidMonth: false,
      isInvalidYear: false,
      isInvalidDate: false,
      optionsStep2: [
        {
          text: "Got it, I will get a new blood pressure measurement and then return to complete my visit",
          value: "gotit",
        },
      ],
      optionsStep1: [
        {
          text: "My provider definitely checked my blood pressure and told me that it was normal",
          value: "ckeckedandnormal",
        },
        {
          text: "My provider expressed concern about my blood pressure.",
          value: "concerns",
        },
        {
          text: "I don't remember discussing my blood pressure with my provider.",
          value: "dontrememberdiscussing",
        },
      ],
      options: [
        {
          text: "High -  Systolic 140+",
          value: "140+",
        },
        {
          text: "Above Normal - Systolic 121-139",
          value: "121-139",
        },
        {
          text: "Normal - Systolic 101-120",
          value: "101-120",
        },
        {
          text: "Below Normal - Systolic 81-100",
          value: "81-100",
        },
         {
          text: "Low - Systolic - 0-80 ",
          value: "0-80",
        },
        {
          text: "I don't remember",
          value: "dontremember",
        },
      ],
      optionsBottom: [
        {
          text: "High -  Diastolic 81+",
          value: "81 +",
        },
        {
          text: "Above Normal - Diastolic 71-80",
          value: "71-80",
        },
        {
          text: "Normal - Diastolic 61-70",
          value: "61-70",
        },
        {
          text: "Below Normal - Diastolic 51-60",
          value: "51-60",
        },
        {
          text: "Low Systolic - Diastolic 0-50",
          value: "0-50",
        },
        {
          text: "I don't remember",
          value: "dontrememberb",
        },
      ],
    };
  },
  methods: {
    setTop(option, event) {
      console.log("this.topNumber");
      this.topNumber = option.value;
      VueCookies.set('bpTop',option.value)
      console.log(this.topNumber);

      if (
        this.topNumber === "dontremember" ||
        this.bottomNumber === "dontrememberb"
      ) {
        this.showStep1 = true;
      }

      if(this.bottomNumber != null && this.topNumber != null && this.bottomNumber != "dontrememberb" && this.topNumber != "dontremember") {
          
          var value = 'Systolic ' + this.topNumber + ' / Diastolic ' + this.bottomNumber;
          this.$emit('input', value) 
        }else{
          this.$emit('input',null)
        }
    },
    setBottom(option, event) {
      console.log("this.bottomNumber");
      this.bottomNumber = option.value;
      console.log(this.bottomNumber);
      VueCookies.set('bpDow',option.value)

      if (
        this.topNumber === "dontremember" ||
        this.bottomNumber === "dontrememberb"
      ) {
        this.showStep1 = true;
      }

       if(this.bottomNumber != null && this.topNumber != null && this.bottomNumber != "dontrememberb" && this.topNumber != "dontremember") {
          
          var value = 'Systolic ' + this.topNumber + ' / Diastolic ' + this.bottomNumber;
          this.$emit('input', value) 
        }else{
          this.$emit('input',null)

        }
    },
    setStep1(option, event) {
      console.log("this.step1");
      this.step1 = option.value;
      console.log(this.step1);

      if (this.step1 === "dontrememberdiscussing") {
        this.showStep1 = false;
        this.showStep2 = true;
      }
      if(this.step1 !== null && this.step1 !== 'dontrememberdiscussing'){
          this.$emit('input',this.step1)
      }else{
          this.$emit('input',null)
      }
    },
      setStep2(option, event) {
      console.log("this.step1");
      this.step2 = option.value;
      console.log(this.step2);
    if(this.step2 !== null ){
          this.$emit('input',this.step2)
      }else{
          this.$emit('input',null)

      }
    },
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

    console.clear();
  let top = VueCookies.get('bpTop')
  let dow =  VueCookies.get('bpDow')
  console.log(top)
  console.log(dow)
  document.getElementById(top).checked = true;
  document.getElementById(dow).checked = true;
  },
};
</script>
<style>
.labelBp {
  padding: 20px;
  font-weight: 600;

}
.labelBpInside {
  padding: 12px;
  font-weight: 600;
  font-size: 1.6rem;
}
.labelBpInside2 {
  padding: 20px;
  font-weight: 600;
  font-size: 1.6rem;
}
.labelBpInsideDeep{
    padding-top: -12px !important;
    font-weight: 100;
  font-size: 0.5rem;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
.red{
border-right: 3px solid red !important;
}
.green{
border-right: 3px solid green !important;
}
.yellow{
border-right: 3px solid yellow !important;
}
</style>