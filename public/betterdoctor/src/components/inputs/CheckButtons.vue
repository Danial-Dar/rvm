<template>
  <div class="radio">
    <template v-for="button in options">
      <template v-if="value">
        <!-- <div> -->
        <div class="border rounded bg-white-light p-3 mb-2" :key="button.value">
          <input
            type="radio"
            :id="button.text"
            :name="name"
            @click="emitAction(button)"
            :checked="value == button.value"
            :value="button.value"
            class="mr-3"
          />
          <label :for="button.text">{{ button.text }}</label>
        </div>
        <!-- <button type="button" :key="button.value" :class="{'bg-gray-500': value !== button.value, 'bg-primary': value === button.value}" class="block md:inline-block w-full md:w-auto mb-2 md:mb-0 px-3 py-2 rounded text-white-normal mr-3" @click="emitAction(button)">{{button.text}}</button>
            </div> -->
      </template>
      <template v-else>
        <div class="border rounded bg-white-light p-3 mb-2" :key="button.value">
          <input
            type="radio"
            :id="button.text"
            :name="name"
            @click="emitAction(button)"
            :value="button.value"
            class="mr-3"
          />
          <label :for="button.text">{{ button.text }}</label>
        </div>
        <!-- <button type="button" :key="button.value" :class="{'bg-gray-500': value === button.value, 'bg-primary': value !== button.value}" class="block md:inline-block w-full md:w-auto mb-2 md:mb-0 px-3 py-2 rounded text-white-normal mr-3" @click="emitAction(button)">{{button.text}}</button> -->
      </template>
    </template>
    <div v-if="showFields == true" class="mt-2">
      <template v-for="field in button.fields">
        <div :key="field.name">
          <component
            :question="field.question"
            @failed="showFailed"
            :key="field.label"
            v-bind:is="field.component"
            v-if="!field.options"
            :label="field.label"
            :name="field.name"
            :placeholder="field.placeholder"
            :noSubmit="field.noSubmit"
            :maxDate="field.maxDate"
            :type="field.type"
            :action="field.action"
            :required="field.required"
            v-model="result[field.name]"
            @next="$emit('next')"
            :v="$v.result[field.name]"
            @modal="showField = true"
          ></component>
          <component
            :question="field.question"
            @failed="showFailed"
            :key="field.label"
            v-bind:is="field.component"
            v-else-if="field.component === 'Checkbox'"
            :options="field.options"
            :label="field.label"
            :name="field.name"
            :required="field.required"
            @next="$emit('next')"
            :v="$v.result[field.name]"
            v-model="result[field.name]"
            :placeholder="field.placeholder"
            :noSubmit="field.noSubmit"
            :maxDate="field.maxDate"
            :type="field.type"
          ></component>
          <component
            :question="field.question"
            @failed="showFailed"
            :key="field.label"
            v-bind:is="field.component"
            v-else
            :options="field.options"
            :label="field.label"
            :name="field.name"
            :required="field.required"
            v-model="result[field.name]"
            @input="$emit('next')"
            :v="$v.result[field.name]"
            :placeholder="field.placeholder"
            :noSubmit="field.noSubmit"
            :maxDate="field.maxDate"
            :type="field.type"
          ></component>
        </div>
      </template>
      <div class="flex justify-end" v-if="noSubmit == true">
        <button
          type="submit"
          :class="{
            'bg-gray-500': v.result.$invalid,
            'bg-primary': !v.result.$invalid
          }"
          :disabled="v.result.$invalid"
          class="text-white-normal py-2 px-3 rounded-sm"
        >
          Next
        </button>
      </div>
      <modal v-if="showFailedPopup == true" @close="showFailedPopup = false">
        <template slot="header">
          <div class="flex justify-between items-center">
            <div class="font-bold text-xl">Error</div>
            <div class="text-right py-2">
              <span @click="showFailedPopup = false">
                <font-awesome-icon class="cursor-pointer" icon="times" />
              </span>
            </div>
          </div>
        </template>
        <template slot="body">
          <p class="mb-2">
            {{ failedText }}
          </p>
        </template>
      </modal>
    </div>
  </div>
</template>
<script>
import validation from "@/validations/index.js";
import Modal from "@/components/design/Modal.vue";
let ctx = {
  props: {
    label: {
      default: null,
      type: String
    },
    action: {
      default: null,
      type: String
    },
    options: {
      default: null,
      type: Array
    },
    value: {
      defaut: null,
      type: String
    },
    result: {
      default: () => {
        return {};
      },
      type: Object
    },
    name: {
      default: null,
      type: String
    },
    noSubmit: {
      default: true,
      type: Boolean
    },
    question: {
      default: null,
      type: String
    },
    v: {
      default: null,
      type: Object
    }
  },
  components: {
    Modal
  },
  data() {
    return {
      showFields: false,
      button: null,
      showFailedPopup: false,
      failedText: ""
    };
  },
   mounted(){
            this.$nextTick(()=>{
              // this.showFields = true
              let vm = this
              let name = vm.name
              let option = vm.options[0]
              let nameValue = vm.result[name]
            console.log('***checkBtn***')

            if(nameValue == "Yes"){
              console.log(option)
            this.emitActionOnMounted(option)  
            }
            //this.emitActionOnMounted()
            })
            },
  validations: {
    result: {}
  },
  methods: {
    emitAction(button) {
      if (button.commit) {
        this.$store.commit(button.commit);
      }
      if (button.action == "popup") {
        this.showFields = true;
        this.button = button;
        this.result[this.name] = button.value;
        this.$emit("update-validation", button.fields);
        this.value = button.value;
        this.$forceUpdate();
        return;
      } else if (button.action == "failed") {
        this.$emit("failed", button.failedText);
        return;
      } else {
        this.value = button.value;
        this.$emit(button.action, button.value, true);
        return;
      }
    },
    showFailed(val) {
      this.failedText = val;
      this.showFailedPopup = true;
    },
    emitActionOnMounted(button) {
      // alert()
      console.clear()
      console.log('***********button*********')
      if (button.action == "popup") {  
        this.showFields = true;
        this.button = button;
        this.result[this.name] = button.value;
        this.$emit("update-validation", button.fields);
        this.value = button.value;
        this.$forceUpdate();
        return;
      } else if (button.action == "failed") {
        this.$emit("failed", button.failedText);
        return;
      } else {
        this.value = button.value;
        this.$emit(button.action, button.value, true);
        return;
      }
    },
  },
  beforeMount() {
    setValidations(this);
  }
};
function setValidations(vm) {
  let result = {};
  vm.options.map(option => {
    if (option.fields) {
      option.fields.map(field => {
        if (validation[field.name]) {
          result[field.name] = validation[field.name];
        }
      });
    }
  });
  ctx.validations.result = result;
}
export default ctx;
</script>
