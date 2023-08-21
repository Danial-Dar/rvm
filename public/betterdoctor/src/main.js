import Vue from 'vue'
import './plugins/fontawesome'
import App from './App.vue'
import './main.css'
import VueRouter from 'vue-router'
import Meta from 'vue-meta';
import Vuelidate from 'vuelidate';
import axios from "axios";
import VueAxios from "vue-axios";

require('./plugins/components.js');

import "./plugins/fontawesome";

import "./main.css";

import VCalendar from 'v-calendar';

import vueCustomElement from "vue-custom-element";
import VueTailwindModal from "vue-tailwind-modal";
import vClickOutside from "v-click-outside";
import Flashy from 'vue-flashy';
import Toasted from 'vue-toasted';

Vue.use(vClickOutside);
Vue.component("VueTailwindModal", VueTailwindModal);

Vue.use(vueCustomElement)
Vue.use(VueRouter)
Vue.use(Flashy)
Vue.use(Meta);
Vue.use(Vuelidate);
Vue.use(VCalendar);
Vue.use(VueAxios, axios);
Vue.use(Toasted);

import {sync} from 'vuex-router-sync';
import router from "./router";
import store from "./store/index";

// import Helpers from './mixins/helpers'

const unsync = sync(store, router);

Vue.config.productionTip = false;
  
  import api from "./plugins/axios";
  Vue.prototype.$axios = api;


/***
 * Before running npm run dev please comment the following vue Instance.!
 */

 
 const ComponentContext = require.context('./components/inputs', true, /\.vue$/i, 'lazy');
 ComponentContext.keys().forEach((componentFilePath) => {

    const componentName = componentFilePath.split('/').pop().split('.')[0];
    Vue.component(componentName, () => ComponentContext(componentFilePath));

});

import transition from "@/mixins/transition.js";

Vue.mixin(transition);

new Vue({
    router,
    store,
    render: (h) => h(App),
    created() {}
}).$mount("#app");
