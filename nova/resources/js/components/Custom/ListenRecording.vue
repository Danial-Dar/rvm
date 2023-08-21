<template>
    <Modal data-testid="preview-resource-modal" :show="show" @close-via-escape="$emit('close')" role="alertdialog"
        maxWidth="2xl">
        <LoadingCard :loading="false" class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <slot>
                <ModalHeader class="flex items-center">
                    Listen Recording
                </ModalHeader>
                <ModalContent class="px-8">
                    <div>
                        <label>
                            <button class="btn btn-primary btn-sm" @click.prevent="playSound(data.url)"><span class="fa fa-play-circle-o"></span></button>
                                Play Air Plane Ding
                        </label> 
                        <div class="heading">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
                </ModalContent>
            </slot>

            <ModalFooter>
                <div class="ml-auto">
                    <LoadingButton @click.prevent="$emit('close')" ref="confirmButton" dusk="confirm-preview-button">
                        {{ __('Close') }}
                    </LoadingButton>
                </div>
            </ModalFooter>
        </LoadingCard>
    </Modal>
</template>

<script>
    // var audio = document.getElementById('adminAudio');

    // var source = document.getElementById('adminAudioSource');
    // source.src = result;

    // audio.load(); //call this to just preload the audio without playing
    // audio.play(); //call this to play the song right away
    export default {
        props: {
            data: {
                type: Object
            },
        },

        // data(){
        //     return{
        //     audio: null,
        //     source: null,
        //     result: null
        // }},

        methods: {
            handleClose() {
                this.$emit('close')
            },
        
            playSound (sound) {
                console.log(sound)
                if(sound) {
                    var audio = new Audio(sound);
                    audio.load();
                    audio.play();
                }
        
            }
        },
        // computed: {
        //     var audio = document.getElementById('adminAudio');

        //     var source = document.getElementById('adminAudioSource');
        //     source.src = result;

        //     audio.load();
        //     audio.play();
        // }
        // computed: {
        //     pending() {
        //         if(this.data.compaign.contact_count && this.data.compaign.sent_count && this.data.compaign.dnc_count)
        //             return parseFloat(this.data.compaign.contact_count) - parseFloat(this.data.compaign.sent_count) -
        //             parseFloat(this.data.compaign.dnc_count);
        //         return 0;
        //     }
        // }
    }

</script>
<style>
$purple: #5c4084;

body {
  background-color: $purple;
  padding: 50px;
}
.container {
  padding: 40px 80px 15px 80px;
  background-color: #fff;
  border-radius: 8px;
  max-width: 400px;
}
.heading {
  text-align: center;
  h1 {
    background: -webkit-linear-gradient(#fff, #999);
    -webkit-text-fill-color: transparent;
    -webkit-background-clip: text;
    text-align: center;
    margin: 0 0 5px 0;
    font-weight: 900;
    font-size: 4rem;
    color: #fff;
  }
  h4 {
    color: lighten(#5c3d86,30%);
    text-align: center;
    margin: 0 0 35px 0;
    font-weight: 400;
    font-size: 24px;
  }
}
.btn{
  outline: none !important;
}
.btn.btn-primary {
  background-color: $purple;
  border-color: $purple;
  outline: none;
  &:hover {
    background-color: darken($purple, 10%);
    border-color: darken($purple, 10%);
  }
  &:active, &:focus {
    background-color: lighten($purple, 5%);
    border-color: lighten($purple, 5%);
  }
  & .fa {
    padding-right: 4px;
  }
}
.btn-sm {
  font-size: 22px;
  padding: 2px 1px 2px 4px;
  line-height: 12px;
  margin-right: 10px;
}
.form-group {
  margin-bottom: 25px;
}
</style>
