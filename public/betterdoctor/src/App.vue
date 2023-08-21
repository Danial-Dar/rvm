<template>
  <div id="app">
    <flashy
      class="fl-sym fl-sym-fixed fl-sym-inset-x-0 fl-sym-bottom-0 fl-sym-text-center"
      :delay="3000"
    ></flashy>
    <!-- <Header /> -->
    <div class="dr-container bg-white-light">
      <router-view />
    </div>
	<!-- <div class="hidden slide-left-enter-active slide-right-enter-active slide-left-leave-active slide-right-leave-active slide-left-leave-active slide-right-enter slide-left-enter">
    </div> -->
    <!-- <Footer /> -->
  </div>
</template>
<script>
import Header from "@/components/base/Header.vue";
import Footer from "@/components/base/Footer.vue";
export default {
  components: {
    Header,
    Footer
  },
  mounted() {
    this.$store.dispatch("auth/setLogin");
  }
};
</script>
<style lang="postcss">
.dr-container {
    min-height: 100vh;
    max-width: calc(100vw - 60vw);
    margin: 0 auto;
}
@media (max-width: 767px) {
	.dr-container {
    min-height: 100vh;
    max-width: 100vw;
    margin: 0 auto;
}
}
@font-face {
  font-display: swap;
  font-family: "Mulish-Regular";
  src: url("./assets/fonts/Mulish-Regular.ttf");
}

@font-face {
  font-display: swap;
  font-family: "Mulish-Bold";
  src: url("./assets/fonts/Mulish-Bold.ttf");
}

*,
body {
  font-family: "Mulish-Regular";
  margin: 0;
  padding: 0;
  border: 0;
  list-style: none;
}
.font-bold {
  font-family: "Mulish-Bold";
}
.highlighted {
	border: 2px solid #0c4b50 !important;
	cursor: pointer;
}
.highlighted2 {
	border: 2px solid #0ca2ad !important;
	 background-color: #d1fcff;
	cursor: pointer;
}
.circle {
  background-color: #0ca2ad;
  border: none;
  color: black;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  /* margin: 8px 4px; */
  cursor: pointer;
  border-radius: 25px;
}
.w-50 {
  width: 50%;
}

.w-60 {
  width: 60%;
}

.w-80 {
  width: 80%;
}

.back {
  position: absolute;
  left: -8%;
  top: 50%;
  transform: translateX(-50%);
  width: 50px;
  height: 50px;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 100%;
}
@media (max-width: 767px) {
  .back {
    width: 30px;
    height: 30px;
    width: 30px;
    height: 30px;
    top: -35px;
    left: 4%;
  }
  .back img {
    width: 9px;
  }
}
.in {
  transition-duration: 0.3s;
  transition-property: opacity, transform;
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  overflow: hidden;
}
.ti-tag.ti-valid {
  background-color: #0ca2ad;
}
.ti-selected-item {
  background-color: #0ca2ad !important;
}
.vs__selected {
  display: none;
}
.vs__dropdown-menu {
  position: absolute;
  width: 100%;
  max-height: 300px !important;
  overflow-y: auto !important;
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 10%), 0 2px 4px -1px rgb(0 0 0 / 6%);
}
.help-drop-down {
  width: 300px;
  top: 120%;
}
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  background-color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
@media (max-width: 767px) {
  .modal-container {
    width: 99vw;
	overflow-y: scroll;
	overflow-x: hidden;
  }
}
.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  padding: 14px;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
.wide {
  max-width: 700px !important;
  max-height: 98vh !important;
  overflow-y: auto;
}
.ultra-wide {
  max-width: 80vw;
}

.modal-body::-webkit-scrollbar {
  width: 5px;
  border-radius: 2px;
}
.modal-body::-webkit-scrollbar-thumb {
  background: #c4c4c4;
}
.no-padd {
  max-height: initial;
  padding: 0;
}
.active {
  border-color: #dee2e6 #dee2e6 #fff;
}
.checkbox [type="checkbox"]:checked, .checkbox [type="checkbox"]:not(:checked) {
	 position: absolute;
	 left: -9999px;
	 border: 1px solid #0ca2ad;
}
 .checkbox [type="checkbox"]:checked + label, .checkbox [type="checkbox"]:not(:checked) + label {
	 position: relative;
	 padding-left: 28px;
	 cursor: pointer;
	 line-height: 20px;
	 display: inline-block;
	 color: #666;
}
 .checkbox [type="checkbox"]:checked + label:before, .checkbox [type="checkbox"]:not(:checked) + label:before {
	 content: "";
	 position: absolute;
	 left: 0;
	 top: 0;
	 width: 18px;
	 height: 18px;
	 border: 1px solid #0ca2ad;
	 background: #fff;
}
 .checkbox [type="checkbox"]:checked + label:after, .checkbox [type="checkbox"]:not(:checked) + label:after {
	 content: "";
	 width: 12px;
	 height: 12px;
	 background: #0ca2ad;
	 position: absolute;
	 top: 3px;
	 left: 3px;
	 -webkit-transition: all 0.2s ease;
	 transition: all 0.2s ease;
}
 .checkbox [type="checkbox"]:not(:checked) + label:after {
	 opacity: 0;
	 -webkit-transform: scale(0);
	 transform: scale(0);
}
 .checkbox [type="checkbox"]:checked + label:after {
	 opacity: 1;
	 -webkit-transform: scale(1);
	 transform: scale(1);
}
 .radio [type="radio"]:checked, .radio [type="radio"]:not(:checked) {
	 position: absolute;
	 left: -9999px;
	 border: 1px solid #0ca2ad;
}
 .radio [type="radio"]:checked + label, .radio [type="radio"]:not(:checked) + label {
	 position: relative;
	 padding-left: 28px;
	 cursor: pointer;
	 line-height: 20px;
	 display: inline-block;
	 color: #666;
}
 .radio [type="radio"]:checked + label:before, .radio [type="radio"]:not(:checked) + label:before {
	 content: "";
	 position: absolute;
	 left: 0;
	 top: 0;
	 width: 18px;
	 height: 18px;
	 border: 1px solid #0ca2ad;
	 border-radius: 100%;
	 background: #fff;
}
 .radio [type="radio"]:checked + label:after, .radio [type="radio"]:not(:checked) + label:after {
	 content: "";
	 width: 12px;
	 height: 12px;
	 background: #0ca2ad;
	 position: absolute;
	 top: 3px;
	 left: 3px;
	 border-radius: 100%;
	 -webkit-transition: all 0.2s ease;
	 transition: all 0.2s ease;
}
 .radio [type="radio"]:not(:checked) + label:after {
	 opacity: 0;
	 -webkit-transform: scale(0);
	 transform: scale(0);
}
 .radio [type="radio"]:checked + label:after {
	 opacity: 1;
	 -webkit-transform: scale(1);
	 transform: scale(1);
}
 .radio [type="radio"]:checked, .radio [type="radio"]:not(:checked) {
	 position: absolute;
	 left: -9999px;
	 border: 1px solid #0ca2ad;
}
 .radio [type="radio"]:checked + label, .radio [type="radio"]:not(:checked) + label {
	 position: relative;
	 padding-left: 28px;
	 cursor: pointer;
	 line-height: 20px;
	 display: inline-block;
	 color: #666;
}
 .radio [type="radio"]:checked + label:before, .radio [type="radio"]:not(:checked) + label:before {
	 content: "";
	 position: absolute;
	 left: 0;
	 top: 0;
	 width: 18px;
	 height: 18px;
	 border: 1px solid #0ca2ad;
	 border-radius: 100%;
	 background: #fff;
}
 .radio [type="radio"]:checked + label:after, .radio [type="radio"]:not(:checked) + label:after {
	 content: "";
	 width: 12px;
	 height: 12px;
	 background: #0ca2ad;
	 position: absolute;
	 top: 3px;
	 left: 3px;
	 border-radius: 100%;
	 -webkit-transition: all 0.2s ease;
	 transition: all 0.2s ease;
}
 .radio [type="radio"]:not(:checked) + label:after {
	 opacity: 0;
	 -webkit-transform: scale(0);
	 transform: scale(0);
}
 .radio [type="radio"]:checked + label:after {
	 opacity: 1;
	 -webkit-transform: scale(1);
	 transform: scale(1);
}
 .uploading .image-picker-placeholder-container .image-placeholder {
	 background: url("~@/assets/images/image-boundary.png");
	 background-size: 100% 100%;
}
 .upload-success .image-picker-placeholder-container .image-placeholder {
	 background: url("~@/assets/images/image-boundary.png");
	 background-size: 100% 100%;
}
 .image-picker-placeholder-container {
	 width: 501px;
	 height: 331px;
	 padding: 31px;
	 border-radius: 20px;
}
 .image-picker-placeholder-container h4 {
	 font-style: normal;
	 font-weight: bold;
	 font-size: 15.1604px;
	 line-height: 18px;
	 color: #000;
}
 @media all and (max-width: 960px) {
	 .image-picker-placeholder-container {
		 width: 100%;
		 height: 331px;
	}
	 .image-picker-placeholder-container .drop-image {
		 width: 100%;
		 height: 100%;
	}
}
 .image-picker-placeholder-container .drop-image-placeholder {
	 display: none;
}
 .image-picker-placeholder-container .drop-image {
	 display: block;
}
 .image-picker-placeholder-container .progress-bar {
	 background: #d7f4e4;
	 width: 266px;
}
 .image-picker-placeholder-container .progress-bar .bar {
	 background: #38c976;
	 opacity: 1;
	 height: 14px;
	 width: 100%;
}
 .image-placeholder {
	 width: 100%;
	 height: 100%;
	 transition: 0.3s all;
}
 .delete-btn {
	 font-style: normal;
	 font-weight: 500;
	 font-size: 18px;
	 line-height: 21px;
	 border-radius: 20px !important;
}
 .credit-card-field-wrapper .form-control.credit-card-field.is-focused {
  border-color: #fff !important;
  box-shadow: none !important;
}
.credit-card-field-wrapper .form-control.credit-card-field.is-invalid,
.credit-card-field-wrapper .form-control.credit-card-field:invalid {
  box-shadow: none;
  border-color: #fff !important;
}
.radio [type="radio"]:checked, .radio [type="radio"]:not(:checked) {
	 position: absolute;
	 left: -9999px;
	 border: 1px solid #0ca2ad;
}
 .radio [type="radio"]:checked + label, .radio [type="radio"]:not(:checked) + label {
	 position: relative;
	 padding-left: 28px;
	 cursor: pointer;
	 line-height: 20px;
	 display: inline-block;
	 color: #666;
}
 .radio [type="radio"]:checked + label:before, .radio [type="radio"]:not(:checked) + label:before {
	 content: "";
	 position: absolute;
	 left: 0;
	 top: 0;
	 width: 18px;
	 height: 18px;
	 border: 1px solid #0ca2ad;
	 border-radius: 100%;
	 background: #fff;
}
 .radio [type="radio"]:checked + label:after, .radio [type="radio"]:not(:checked) + label:after {
	 content: "";
	 width: 12px;
	 height: 12px;
	 background: #0ca2ad;
	 position: absolute;
	 top: 3px;
	 left: 3px;
	 border-radius: 100%;
	 -webkit-transition: all 0.2s ease;
	 transition: all 0.2s ease;
}
 .radio [type="radio"]:not(:checked) + label:after {
	 opacity: 0;
	 -webkit-transform: scale(0);
	 transform: scale(0);
}
 .radio [type="radio"]:checked + label:after {
	 opacity: 1;
	 -webkit-transform: scale(1);
	 transform: scale(1);
}
 .vue-slider-process {
  background-color: #0ca2ad;
}
@media only screen and (max-width: 280px) {
  .vue-slider-mark-label {
    font-size: 8px !important;
  }
  	#vouched-element {
		/* height: calc(100vh - 200px) !important; */
	}
	.widthh {
		width: 50px !important;
	}
	.widthhh {
		width: 30px !important;
	}
}
@media only screen and (min-width: 767px) and (max-width: 768px) {
	.ed-package{
	margin-left: -32px !important;
	margin-right:-25px !important;
	}
}
@media only screen and (min-width: 800px) and (max-width: 800px) {
	.ed-package{
	margin-left: -17px !important;
	margin-right:-9px !important;
	}
}
@media only screen and (min-width: 300px) and (max-width: 767px) {
  .vue-slider-mark-label {
    font-size: 11px !important;
  }
  	#vouched-element {
		/* height: calc(100vh - 200px) !important; */
	}
}
@media only screen and (min-width: 768px) and (max-width: 949px) {
  .vue-slider-mark-label {
    font-size: 7px !important;
  }
  	#vouched-element {
		height: 700px !important;
	}
}
@media only screen and (min-width: 950px) and (max-width: 1200px) {
	#vouched-element {
		/* height: calc(100vh - 300px) !important; */
	}
}
@media only screen and (min-width: 1200px) and (max-width: 1600px) {
	#vouched-element {
	/* height: calc(100vh - 250px) ;
	position: relative; */
	}
}
@media only screen and (min-width: 1601px) {
	#vouched-element {
	height: 500px ;
	}
}
.vouched {
  background: #fafafa !important;
}
.jss43 {
  width: auto;
  background-color: #0ca2ad;
  border-radius: 6px !important;
}
.jss41 button {
  width: auto;
  min-width: auto !important;
  background-color: #0ca2ad;
  border-radius: 6px !important;
}


.pac-item, .pac-item-query {
	background: rgb(180, 180, 180) !important;
	color: #fff !important;
	padding: 7px !important;
}
.slide-left-enter-active,
.slide-right-enter-active {
}

.slide-left-leave-active,
.slide-right-leave-active {
  transition-duration: 0.3s;
  transition-property: opacity, transform;
  transition-timing-function: cubic-bezier(0.55, 0, 0.1, 1);
  overflow: hidden;
}

.slide-left-enter,
.slide-right-leave-active {
  transform: translate(200em, 0);
}

.slide-left-leave-active,
.slide-right-enter {
  opacity: 0;
}
.hidden{
	display: none !important;
}
</style>
