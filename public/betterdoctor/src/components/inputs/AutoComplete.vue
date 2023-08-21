<template>
  <div class="mb-2">
    <div class="flex mb-2 relative">
      <v-select
        ref="select"
        class="w-full"
        @search="initItems"
        :options="autocompleteItems"
        @option:selected="pushItem"
        :multiple="true"
        v-model="value"
      >
        <template #search="{ attributes, events }">
          <div class="flex items-center relative">
            <input
              class="w-full bg-white border focus:outline-none p-3 w-full"
              v-bind="attributes"
              v-on="events"
              v-model="searchText"
            />
            <button
              type="button"
              class="text-white-normal p-3"
              :disabled="searchText == null && searchText == ''"
              :class="{
                'bg-gray-500': searchText == null || searchText == '',
                'bg-primary': searchText !== null && searchText !== ''
              }"
            >
              Add
            </button>
          </div>
        </template>
        <template #spinner="{}">
          <div
            class="absolute right-0 inset-y-0 flex items-center pr-24"
            v-if="loading == true"
          >
            <font-awesome-icon icon="spinner" class="animate-spin" />
          </div>
        </template>
        <template #open-indicator="{ attributes }">
          <span v-bind="attributes"></span>
        </template>
        <template #no-options="{ search, searching, loading }">
          <div></div>
        </template>
        <template #selected-option="{ lable, quantity }">
          <div style="display: flex; align-items: baseline;"></div>
        </template>
        <template #option="option">
          <div class="bg-white-normal cursor-pointer w-full z-100 p-2 border-b">
            <div class="font-bold text-xl">{{ option.label }}</div>
            <div class="">{{ option.quantity }}</div>
          </div>
        </template>
      </v-select>
    </div>
    <div
      class="w-full border mb-2"
      v-for="(option, index) in value"
      :key="index"
    >
      <div class="flex justify-between items-center">
        <div>
          <div class="font-bold text-xl p-2 text-grey-dark">
            {{ option.label }}
          </div>
          <div class="px-2 text-grey-medium" v-html="option.quantity"></div>
        </div>
        <div
          class="pr-2 text-grey-medium cursor-pointer"
          @click="removeItem(index)"
        >
          <font-awesome-icon icon="times" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueTagsInput from "@johmun/vue-tags-input";
import axios from "axios";
import vSelect from "vue-select";

export default {
  components: {
    VueTagsInput,
    vSelect
  },
  props: {
    value: {
      type: Array,
      default: () => {
        return [];
      }
    }
  },
  data() {
    return {
      tag: "",
      tags: [],
      autocompleteItems: [],
      debounce: null,
      loading: false,
      searchText: null
    };
  },
  watch: {
    tag: "initItems"
  },
  methods: {
    add() {
      if (this.searchText !== null && this.searchText !== "") {
        let value = this.value;
        value.push({
          label: this.searchText,
          quantity: "&nbsp;"
        });
        this.$emit("input", value);
        this.searchText = "";
      }
    },
    pushItem(newTags) {
      this.autocompleteItems = [];
      this.$emit("input", newTags);
      this.searchText = "";
    },
    removeItem(index) {
      this.value.splice(index, 1);
    },
    async initItems(search, loading) {
      const url = `https://clinicaltables.nlm.nih.gov/api/rxterms/v3/search?terms=${search}&ef=STRENGTHS_AND_FORMS`;
      this.loading = true;
      clearTimeout(this.debounce);
      this.debounce = setTimeout(async () => {
        await axios
          .get(url)
          .then(response => {
            let medicines = response.data[1];
            let strengths_forms = response.data[2].STRENGTHS_AND_FORMS;
            let medicines_with_forms = [];
            strengths_forms.map((forms, index) => {
              forms.map(form => {
                medicines_with_forms.push({
                  label: medicines[index],
                  quantity: form
                });
              });
            });
            this.loading = false;
            this.autocompleteItems = medicines_with_forms;
          })
          .catch(() => {
            console.warn("Oh. Something went wrong");
            this.loading = false;
          });
      }, 600);
    }
  }
};
</script>
