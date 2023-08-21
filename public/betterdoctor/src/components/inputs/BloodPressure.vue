<template>
  <div class="mb-2 md:ml-0">
    <div v-if="!showStep1 && !showStep2">
      <!-- <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your last blood pressure reading?</div> -->
    
        
      

      <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your top number? (Systolic)</div>
      
      <vue-slider
          :dotSize="25"
          :data="marks"
          :marks="marks"
          :max="30"
          v-model="toprange"
          @change="setTopValue"
            :tooltip-formatter="formatter2"
        ></vue-slider>
    
     <!-- <div class="radio" style="margin-top:30px" >
        <div
          v-for="option in options1"
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
      </div> -->
      <div class="font-bold" style="margin-top:40px; margin-bottom:40px">What was your bottom number? (Diastolic)</div>
<vue-slider
          :dotSize="25"
          :data="marksB"
          :marks="marksB"
          :max="30"
          v-model="botrange"
          @change="setBotValue"
            :tooltip-formatter="formatter3"

        ></vue-slider>
    
     <div class="radio" style="margin-top:30px" >
        <div
          v-for="option in options1"
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
        pressure at your last visit?
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
            :checked="option.value == selectDefault1"
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
             :checked="option.value == selectDefault1"
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
import "vue-slider-component/theme/default.css";
import VueSlider from "vue-slider-component";

export default {
  data() {
    return {
        formatter2: v => 
            v === "0-80" ?
              'Low' :
              (v === "81-100") ?
              'Below Normal':
              (v === "101-120") ?
              'Normal':
              (v === "121-139") ?
              'Above Normal' : 
              (v === "140+") ? 
              'High' : 'Low'
          ,
       formatter3: v => 
            v === "0-50" ?
              'Low' :
              (v === "51-60") ?
              'Below Normal':
              (v === "61-70") ?
              'Normal':
              (v === "71-80") ?
              'Above Normal' : 
              (v === "81+") ? 
              'High' : 'Low'
          ,
      
         options1: [
        {
          text: "I don't remember",
          value: "dontremember",
        },
      ],
       marks: {
        "0-80":  {
            label:  "0-80",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'red',
            },
            labelStyle: {
              color: 'red'
            }
          },
        "81-100": {
            label:  "81-100",
            style: {
            width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'gold',
            },
            labelStyle: {
              color: 'gold'
            }
          },
        "101-120":  {
            label:  "101-120",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'green',
              color: 'green'
            },
            labelStyle: {
              color: 'green'
            }
          },
        "121-139":  {
            label:  "121-139",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'gold',
            },
            labelStyle: {
              color: 'gold'
            }
          },
        "140+": {
            label:  "140+",
            style: {
              width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'red',
            },
            labelStyle: {
              color: 'red'
            }
          }
      },
       marksB: {
        "0-50": {
            label:  "0-50",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'red',
            },
            labelStyle: {
              color: 'red'
            }
          },
        "51-60": {
            label:  "51-60",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'gold',
            },
            labelStyle: {
              color: 'gold'
            }
          },
        "61-70":{
            label:  "61-70",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'green',
            },
            labelStyle: {
              color: 'green'
            }
          },
        "71-80": {
            label:  "71-80",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'gold',
            },
            labelStyle: {
              color: 'gold'
            }
          },
        "81+":{
            label:  "81+",
            style: {
             width: '4px',
              height: '4px',
              display: 'block',
              backgroundColor: 'red',
            },
            labelStyle: {
              color: 'red'
            }
          }
      },
      toprange: '101-120',
      botrange: '61-70',
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
      selectDefault1: null,
      optionsStep2: [
        {
          text: "Got it, I will get a new blood pressure measurement and then return to complete my visit.",
          value: "gotit",
        },
        {
          text: "Go Back.",
          value: "gobackstep2",
        },
      ],
      optionsStep1: [
        {
          text: "My provider definitely checked my blood pressure and told me that it was normal.",
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
         {
          text: "Go Back.",
          value: "gobackstep1",
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
    setTopValue(){
console.log(this.toprange)
// document.getElementsByClassName('vue-slider-process').style.background = 'red';
        if(this.toprange != null && this.botrange != null) {
          var value = 'Systolic ' + this.toprange + ' / Diastolic ' + this.botrange;
          this.$emit('input', value) 
        }else{
          this.$emit('input',null)
        }
    },
    setBotValue(){
console.log(this.botrange)
        if(this.toprange != null && this.botrange != null) {
          var value = 'Systolic ' + this.toprange + ' / Diastolic ' + this.botrange;
          this.$emit('input', value) 
        }else{
          this.$emit('input',null)
        }
    },
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
      // console.log("this.bottomNumber");
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
      // console.log("this.step3");
      this.step1 = option.value;
      // console.log(this.step1);
      if(this.step1 === 'gobackstep1'){
        // this.$emit('input',null)

        this.showStep1 = false;
        this.showStep2 = false;
        var value = 'Systolic ' + this.toprange + ' / Diastolic ' + this.botrange;
        this.$emit('input', value) 
        return
      }
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
      // console.log("this.step2");
      this.step2 = option.value;
       if(this.step2 === 'gobackstep2'){
        this.$emit('input',null)

        this.showStep1 = true;
        this.showStep2 = false;
        // var value = 'Systolic ' + this.toprange + ' / Diastolic ' + this.botrange;
        // this.$emit('input', value) 
        return
      }
      // console.log(this.step2);
    if(this.step2 !== null ){
          this.$emit('input',this.step2)
      }else{
          this.$emit('input',null)

      }
    },
  },
  components: {
    // Card,
    VueSlider,

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
   console.log('this.result[this.name]')
   console.log()
   if(!this.result[this.name]){
      var value = 'Systolic 101-120 / Diastolic 61-70';
      this.$emit('input', value) 
   }
    // console.log(this.result[this.name])
    if(this.result[this.name].indexOf('0-80') != -1 ) this.toprange = '0-80';
    if(this.result[this.name].indexOf('81-100') != -1 ) this.toprange = '81-100';
    if(this.result[this.name].indexOf('101-120') != -1 ) this.toprange = '101-120';
    if(this.result[this.name].indexOf('121-139') != -1 ) this.toprange = '121-139';
    if(this.result[this.name].indexOf('140+') != -1 ) this.toprange = '140+';
    
    if(this.result[this.name].indexOf('0-50') != -1 ) this.botrange = '0-50';
    if(this.result[this.name].indexOf('51-60') != -1 ) this.botrange = '51-60';
    if(this.result[this.name].indexOf('61-70') != -1 ) this.botrange = '61-70';
    if(this.result[this.name].indexOf('71-80') != -1 ) this.botrange = '71-80';
    if(this.result[this.name].indexOf('81+') != -1 ) this.botrange = '81+';
   
   if(this.result[this.name].indexOf('concerns') != -1 ){
     this.selectDefault1 = 'concerns'
     this.showStep1 = true
   } 
   if(this.result[this.name].indexOf('ckeckedandnormal') != -1 ){
     this.selectDefault1 = 'ckeckedandnormal'
     this.showStep1 = true
   } 
   if(this.result[this.name].indexOf('gotit') != -1 ){
     this.selectDefault1 = 'gotit'
     this.showStep1 = false
     this.showStep2 = true
   }

    // toprange: '101-120',
    //   botrange: '61-70',
  
    // console.clear();
  // let top = VueCookies.get('bpTop')
  // let dow =  VueCookies.get('bpDow')
  // console.log(top)
  // console.log(dow)
  // document.getElementById(top).checked = true;
  // document.getElementById(dow).checked = true;
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