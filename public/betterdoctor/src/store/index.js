import Vue from "vue";
import Vuex from "vuex";
import VuexPersit from "vuex-persist";
import localForage from "localforage";
import ed from "./ed/index";
import skin from "./skin/index";
import weightloss from "./weightloss/index";
import screamcream from "./screamcream/index";
import hair from "./hair/index";
import herpes from "./herpes/index";
import birthcontrol from "./birthcontrol/index";
import covid from "./covid/index";
import smoking from "./smoking/index";
import allergies from "./allergies/index";
import depressioninitial from "./depressioninitial/index";
import depressionfollowup from "./depressionfollowup/index";

Vue.use(Vuex);

const vuexStorage = new VuexPersit({
  key: process.env.VUE_APP_STORAGE_KEY,
  storage: localForage
});

const store = new Vuex.Store({
  plugins: [vuexStorage.plugin],
  modules: {
    ed,
    skin,
    weightloss,
    screamcream,
    hair,
    herpes,
    birthcontrol,
    covid,
    smoking,
    allergies,
    depressioninitial,
    depressionfollowup
  },
  state: {
    sex: null,
    result: {
      firstName: "",
      lastName: "",
      card: {},
      gender: "",
      addressObject: {
        streetAddress: "",
        city: "",
        postalCode: "",
        state: ""
      }
    },
    qas: {}
  },
  mutations: {
    updateGender(state, value) {
      state.result.gender = value;
      state.ed.result.gender = value;
      state.skin.result.gender = value;
      state.weightloss.result.gender = value;
      state.screamcream.result.gender = value;
      state.hair.result.gender = value;
      state.herpes.result.gender = value;
      state.birthcontrol.result.gender = value;
      state.covid.result.gender = value;
      state.smoking.result.gender = value;
      state.allergies.result.gender = value;
      state.depressioninitial.result.gender = value;
      state.depressionfollowup.result.gender = value;
    },
    SET_RESULT(state, value) {
      state.result = value;
    },
    SET_RESULT_AND_LOAD(state, value) {
      state.result = value;
      state.ed.result = {
        ...state.ed.result,
        ...value
      };
      state.skin.result = {
        ...state.ed.result,
        ...value
      };
      state.weightloss.result = {
        ...state.ed.result,
        ...value
      };
      state.screamcream.result = {
        ...state.ed.result,
        ...value
      };
      state.hair.result = {
        ...state.ed.result,
        ...value
      };
      state.herpes.result = {
        ...state.ed.result,
        ...value
      };
      state.birthcontrol.result = {
        ...state.ed.result,
        ...value
      };
      state.covid.result = {
        ...state.ed.result,
        ...value
      };
      state.smoking.result = {
        ...state.ed.result,
        ...value
      };
      state.allergies.result = {
        ...state.ed.result,
        ...value
      };
      state.depressioninitial.result = {
        ...state.ed.result,
        ...value
      };
      state.depressionfollowup.result = {
        ...state.ed.result,
        ...value
      };
    },
    SET_QAS(state, value) {
      console.log('value')
      console.log(value)
      console.log('state')
      console.log(state)
      state.qas = value;
    },
    SET_VALUE(state, payload) {
      state.result[payload["key"]] = payload.value;
    }
  }
});

export default store;
