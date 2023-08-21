<template>
  <div>
    <v-date-picker
      ref="datepicker"
      :popover="{ visibility: 'none' }"
      class="w-full h-full"
      :value="value"
      @input="emit"
      :masks="masks"
    >
      <template #default="{ inputValue, inputEvents, togglePopover }">
        <div class="flex items-center mb-2">
          <button
            class="p-2 bg-primary-100 border border-primary-200 hover:bg-primary-200 text-primary-600 rounded-l focus:bg-primary-500 focus:text-white focus:border-blue-500 focus:outline-none"
            @click="togglePopover()"
            type="button"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              class="w-4 h-4 fill-current"
            >
              <path
                d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"
              ></path>
            </svg>
          </button>
          <input
            class="px-3 py-1 border rounded-r w-full focus:outline-none"
            :placeholder="placeholder"
            :value="inputValue"
            id="inputValue"
            v-on="inputEvents"
            type="tel"
            @input="formatDate"
          />
        </div>
      </template>
    </v-date-picker>
    <modal v-if="showModal == true" @close="showModal = false">
      <template slot="header">
        <div class="text-right py-2">
          <span @click="showModal = false">
            <font-awesome-icon class="cursor-pointer" icon="times" />
          </span>
        </div>
      </template>
      <template slot="body">
        <div class="text-left text-sm">
          {{ text }}
        </div>
      </template>
    </modal>
  </div>
</template>
<script>
import Modal from "@/components/design/Modal.vue";
export default {
  props: {
    value: {
      type: Date,
      default: null
    },
    maxDate: {
      type: Number,
      default: new Date(
        new Date().setFullYear(new Date().getFullYear())
      ).getTime()
    },
    name: {
      default: "",
      type: String
    },
    placeholder: {
      default: "",
      type: String
    }
  },
  components: {
    Modal
  },
  data() {
    return {
      selectedDate: new Date(),
      showDatePicker: false,
      text: null,
      showModal: false,
      masks: {
        input: "MM/DD/YYYY"
      }
    };
  },
  methods: {
    emit(val) {
      if (val > this.maxDate) {
        if (this.name == "dateOfBirth") {
          this.text =
            "Unfortunately, We’re only able to assist people 18 years of age or older.";
        } else if (
          this.name == "dateOfPeriod" ||
          this.name == "whenHaveYouGiveBirthRecently" ||
          this.name == "dateOfPelvic" ||
          this.name == "whenYouHaveMammogram" ||
          this.name == "whenYouHaveStds" ||
          this.name == "papSmearDate" ||
          this.name == "dateOfBirthCovid"
        ) {
          this.text = "Date can not be in the future";
        }
        this.$emit("input", null);
        this.$forceUpdate();
        this.showModal = true;
        return;
      }
      this.$emit("input", val);
    },
    formatDate(evt) {
      let value = evt.target.value;
      if (value && value.length > 2) {
        let replacedInput = value
          .replace(/\D/g, "")
          .match(/(\d{0,2})(\d{0,2})(\d{0,4})/);
        value =
          (!replacedInput[2]
            ? replacedInput[1] + "/"
            : replacedInput[1] + "/" + replacedInput[2]) +
          (replacedInput[3] ? "/" + replacedInput[3] : "");
        document.getElementById("inputValue").value = value;
        this.$forceUpdate();
      }
    },
    hide(hidePopover) {
      setTimeout(() => {
        hidePopover();
      }, 100);
    }
  }
};
</script>
