<template>
  <form @submit.prevent="submit" id="form" class="relative" novalidate>
    <div class="mb-2 font-bold text-sm md:text-xl">{{ question }}</div>
    <template v-for="field in fields.filter(a => a.name !== 'reason')">
      <!-- <component 
            :key="field.label"
            v-bind:is="field.component"
            v-if="type=='button'"
            :label="field.label"
            :name="field.name"
            :placeholder="field.placeholder"
            :type="field.type"
            :required="field.required"
            :action="field.action"
            @next="$emit('next')"
            ></component> -->
      <component
        :question="field.question"
        :key="field.label"
        v-bind:is="field.component"
        @update-validation="reValidate"
        v-if="field.component == 'HairRadio'"
        :options="field.options"
        :result="result"
        :label="field.label"
        :name="field.name"
        :required="field.required"
        v-model="result[field.name]"
        @input="submit"
        @failed="showFailed"
        :v="$v"
        :maxDate="field.maxDate"
      ></component>
      <component
        :question="field.question"
        :key="field.label"
        v-bind:is="field.component"
        v-else-if="type == 'address'"
        :fields="field.fields"
        :label="field.label"
        :result="result"
        :name="field.name"
        :placeholder="field.placeholder"
        :type="field.type"
        @update-validation="reValidate"
        :action="field.action"
        :required="field.required"
        v-model="result[field.name]"
        @failed="showFailed"
        @next="submit"
        :v="$v.result[field.name]"
        :maxDate="field.maxDate"
        @modal="showField = true"
      ></component>
      <component
        :question="field.question"
        :key="field.label"
        v-bind:is="field.component"
        v-else-if="!field.options"
        @update-validation="reValidate"
        :label="field.label"
        :result="result"
        :name="field.name"
        :placeholder="field.placeholder"
        :type="field.type"
        :action="field.action"
        :required="field.required"
        v-model="result[field.name]"
        @failed="showFailed"
        @next="submit"
        :v="$v.result[field.name]"
        :maxDate="field.maxDate"
        @modal="showField = true"
      ></component>
      <component
        :question="field.question"
        :key="field.label"
        v-bind:is="field.component"
        v-else-if="field.component === 'Checkbox'"
        :options="field.options"
        :label="field.label"
        :result="result"
        :name="field.name"
        :required="field.required"
        @next="submit"
        :v="$v.result[field.name]"
        v-model="result[field.name]"
        @failed="showFailed"
        :placeholder="field.placeholder"
        :maxDate="field.maxDate"
        :type="field.type"
      ></component>
      <component
        :question="field.question"
        :key="field.label"
        v-bind:is="field.component"
        @update-validation="reValidate"
        v-else
        :options="field.options"
        :result="result"
        :label="field.label"
        :name="field.name"
        :required="field.required"
        @failed="showFailed"
        v-model="result[field.name]"
        @input="submit"
        :v="$v"
        :maxDate="field.maxDate"
      ></component>
      <!-- <component 
            :key="field.label"
            v-bind:is="field.component"
            v-else
            :options="field.options"
            :label="field.label"
            :name="field.name"
            :required="field.required"
            :value="result[field.name] !== ''||result[field.name] !== null?result[field.name]:field.value"
            v-model="result[field.name]"
            @input="$emit('next')"
            :placeholder="field.placeholder"
            :type="field.type"
            ></component> -->
    </template>
    <!-- <div class="flex mt-4" :class="{'justify-between': back, 'justify-end': !back}">
            <button class="bg-primary px-3 py-2 rounded text-white-normal" v-if="back" @click="$emit('back')">Back</button>
            <button class="bg-primary px-3 py-2 rounded text-white-normal" @click="$emit('next')">Next</button>
        </div> -->
    <!-- <TextField class="mt-2" v-if="showField == true" /> -->
    <template v-if="showField == true">
      <template v-for="field in fields.filter(a => a.name == 'reason')">
        <component
          class="mt-2"
          :key="field.label"
          v-bind:is="field.component"
          :options="field.options"
          :label="field.label"
          :name="field.name"
          :required="field.required"
          @next="$emit('next')"
          :v="$v.result[field.name]"
          v-model="result[field.name]"
          :placeholder="field.placeholder"
          :type="field.type"
        ></component>
      </template>
    </template>
    <input class="hidden" type="submit" name="go" value="Submit" />
    <div class="flex justify-end" v-if="noSubmit == true">
      <button
        type="submit"
        :class="{
          'bg-gray-500': $v.result.$invalid,
          'bg-primary': !$v.result.$invalid
        }"
        :disabled="$v.result.$invalid"
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
  </form>
</template>
<script>
import { mapState } from "vuex";
import Modal from "@/components/design/Modal.vue";
import validation from "@/validations/index.js";
let ctx = {
  props: {
    question: {
      type: String,
      default: ""
    },
    fields: {
      default: () => {
        return [];
      }
    },
    back: {
      default: true,
      type: Boolean
    },
    result: {
      default: () => {
        return {};
      },
      type: Object
    },
    type: {
      default: null,
      type: String
    },
    type2: {
      default: null,
      type: String
    },
    noSubmit: {
      default: true,
      type: Boolean
    }
  },
  validations: {
    result: {}
  },
  data() {
    return {
      showField: false,
      showFailedPopup: false,
      failedText: ""
    };
  },
  components: {
    Modal
  },
  methods: {
    submit(value, bypass = false) {
      if (bypass == false) {
        this.$v.result.$touch();
        if (this.$v.result.$pending || this.$v.result.$error) return;
        this.$emit("next");
      } else {
        this.$emit("next");
      }
    },
    reValidate(fields) {
      setValidations(this, fields);
    },
    showFailed(val) {
      this.failedText = val;
      this.showFailedPopup = true;
    }
  },
  beforeMount() {
    setValidations(this);
  }
};

function setValidations(vm, fields = null) {
  let result = {};
  if (fields == null) {
    vm.fields.map(field => {
      if (validation[field.name]) {
        result[field.name] = validation[field.name];
      }
    });
  } else {
    fields.map(field => {
      if (validation[field.name]) {
        result[field.name] = validation[field.name];
      }
    });
  }
  ctx.validations.result = result;
  vm.$forceUpdate();
}
export default ctx;
</script>
