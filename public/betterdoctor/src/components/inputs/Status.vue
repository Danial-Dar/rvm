<template>
    <div class="radio">
        <div class="rounded border rounded-full p-2">
            <div class="flex items-center">
                <div class="rounded rounded-full bg-green-300 w-3 h-3 mr-2"></div>
                {{status}}
            </div>
        </div>
    </div>
</template>
<script>
import validation from "@/validations/index.js"
import Modal from "@/components/design/Modal.vue"
import VueCookies from 'vue-cookie';

let ctx = {
    props: {
        status: {
            default: null,
            type: String
        }
    },
    components: {
        Modal
    },
    data() {
        return {
            value:this.result,
            showFields: false,
            button: null,
            showFailedPopup: false,
            failedText: '',
        }
    },
    validations: {
        result: {}
    },
    mounted() {
    },
    methods: {
        emitAction(event) {
            let option = this.options.find(option => option.value == event.target.value) 
            this.value = option.value;
            // console.log(this.value)
            // VueCookies.set('select',this.value)
            this.$emit("input", this.value);            
        },
        // showFailed(val) {
        //     this.failedText = val
        //     this.showFailedPopup = true
        // }
    },
    // beforeMount() {
    //     setValidations(this);
    // }
}
// function setValidations(vm) {
//     let result = {}
//     vm.options.map(option => {
//         if(option.fields) {
//             option.fields.map(field => {
//                 if(validation[field.name]) {
//                     result[field.name] = validation[field.name]
//                 }
//             })
//         }
//     })
//     ctx.validations.result = result
// }
export default ctx;
</script>
<style lang="scss" scoped>
.radio {
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
        border: 1px solid #00a3de;
    }
    [type="radio"]:checked + label,
    [type="radio"]:not(:checked) + label
    {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #666;
    }
    [type="radio"]:checked + label:before,
    [type="radio"]:not(:checked) + label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #00a3de;
        border-radius: 100%;
        background: #fff;
    }
    [type="radio"]:checked + label:after,
    [type="radio"]:not(:checked) + label:after {
        content: '';
        width: 12px;
        height: 12px;
        background: #00a3de;
        position: absolute;
        top: 3px;
        left: 3px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    [type="radio"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    [type="radio"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}
</style>
