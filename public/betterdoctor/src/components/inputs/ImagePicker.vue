<template>
  <div
    :class="{
      'drag-active': drag,
      uploading: uploading,
      'upload-success': uploadSuccess
    }"
    class="text-center"
  >
    <div @click="launchFilePicker()">
      <div
        class="image-picker-placeholder-container shadow-lg border pointer relative"
        @dragenter="enter"
        @dragleave="leave"
        @mouseover="enter"
        @mouseleave="leave"
        @drop="dropHandler"
        @dragover="dragOverHandler"
      >
        <img
          v-if="
            uploading == false && uploaded == false && uploadSuccess == false
          "
          :src="
            drag == false
              ? placeholderImage
              : require('@/assets/images/on-drop-image.png')
          "
          class="drop-image"
        />
        <div
          class="flex justify-center items-center lighten-3 mb-3 image-placeholder absolute top-0 left-0"
        >
          <div v-if="uploading">
            <div class="progress-bar">
              <div ref="bar" class="bar" style="height:20px;"></div>
            </div>
            <h4>We're uploading your images...</h4>
          </div>
          <slot
            name="activator"
            v-if="!uploading && !uploadSuccess && uploaded"
          >
          </slot>
          <div
            v-if="uploadSuccess"
            class="flex flex-col justify-center items-center"
          >
            <img
              v-if="uploadSuccess"
              :src="require('@/assets/images/circle-tick.png')"
              alt=""
              srcset=""
              class="w-24"
            />
            <h4>
              Your upload is <span class="primary--text">successfull!</span>
            </h4>
          </div>
        </div>
      </div>
    </div>
    <input
      ref="file"
      id="file"
      type="file"
      @change="onFileChange"
      style="display:none"
    />
    <modal v-if="showCropper == true" width="500" @close="showCropper = false">
      <template slot="body">
        <div>Crop Image</div>
        <div>
          <cropper
            class="cropper mb-3"
            :src="img"
            :stencil-props="{
              aspectRatio: 12 / 12
            }"
            @change="change"
          />
        </div>

        <v-divider></v-divider>

        <div>
          <button
            class="bg-primary px-2 py-2 text-white rounded"
            text
            @click="doneCropping"
          >
            Done!
          </button>
        </div>
      </template>
    </modal>
  </div>
</template>
<script>
import { Cropper } from "vue-advanced-cropper";
import Modal from "@/components/design/Modal.vue";
import "vue-advanced-cropper/dist/style.css";
export default {
  props: {
    uploaded: {
      default: false,
      type: Boolean
    },
    placeholderImage: {
      default: () => {
        return require("@/assets/images/add-your.png");
      },
      type: Object
    }
  },
  components: {
    Cropper,
    Modal
  },
  data() {
    return {
      width: 0,
      showCropper: false,
      interval: null,
      drag: false,
      uploading: false,
      uploadSuccess: false,
      progress: 0,
      asd: "asd",
      img:
        "https://images.unsplash.com/photo-1600984575359-310ae7b6bdf2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=700&q=80",
      image:
        "https://images.unsplash.com/photo-1600984575359-310ae7b6bdf2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=700&q=80"
    };
  },
  methods: {
    enter(e) {
      this.drag = true;
      e.preventDefault();
    },
    leave(e) {
      this.drag = false;
    },
    dropHandler(ev) {
      ev.preventDefault();
      let vm = this;
      if (ev.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        for (var i = 0; i < ev.dataTransfer.items.length; i++) {
          // If dropped items aren't files, reject them
          if (ev.dataTransfer.items[i].kind === "file") {
            var file = ev.dataTransfer.items[i].getAsFile();
            this.showCropper = false;
            let imageFile = file;
            vm.uploading = true;
            vm.drag = false;
            vm.$nextTick(async () => {
              await vm.progressBar(imageFile);
              vm.$forceUpdate();
            });
          }
        }
      } else {
        // Use DataTransfer interface to access the file(s)
        for (var i = 0; i < ev.dataTransfer.files.length; i++) {
          this.showCropper = false;
          let imageFile = ev.dataTransfer.files[i];
          let vm = this;
          vm.uploading = true;
          vm.drag = false;
          vm.$nextTick(async () => {
            await vm.progressBar(imageFile);
            vm.$forceUpdate();
          });
        }
      }
    },
    dragOverHandler(e) {
      e.preventDefault();
    },
    launchFilePicker() {
      this.$refs.file.click();
    },
    doneCropping() {
      this.$emit("input", this.image);
      this.showCropper = false;
    },
    change({ coordinates, canvas }) {
      this.image = canvas.toDataURL();
    },
    resetProgressBar() {
      this.width = 1;
      clearInterval(this.interval);
      this.$refs.bar.style.width = this.width + "%";
    },
    async progressBar(imageFile) {
      this.resetProgressBar();
      this.$emit("reset");
      this.interval = await setInterval(this.frame, 10, imageFile);
    },
    frame(imageFile) {
      let vm = this;
      if (this.width >= 100) {
        clearInterval(this.interval);
        vm.uploading = false;
        vm.uploadSuccess = true;
        setTimeout(() => {
          var reader = new FileReader();

          reader.onload = function() {
            vm.img = reader.result;
            vm.showCropper = true;
            vm.uploadSuccess = false;
            vm.$forceUpdate();
          };

          reader.readAsDataURL(imageFile);
        }, 3000);
        vm.resetProgressBar();
        vm.$refs.file.value = "";
      } else {
        this.width++;
        this.$refs.bar.style.width = this.width + "%";
      }
    },
    onFileChange(e) {
      this.showCropper = false;
      let imageFile = e.target.files[0];
      let vm = this;
      vm.uploading = true;
      this.$nextTick(async () => {
        await vm.progressBar(imageFile);
        vm.$forceUpdate();
      });
    }
  }
};
</script>
