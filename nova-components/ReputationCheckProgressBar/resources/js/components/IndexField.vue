<template>
  <div @click.prevent="generateDetails()" >
    <span ref="chartContainer" class="chartContainer"></span>
    <span class="statusMainR">{{ reputationStatus(field.value) }}</span>


     <Modal
        :show="show_detail && shouldShow"
        dusk="confirm-upload-removal-modal"
        :role="'dialog'"
        :maxWidth="'md'"
        :class="'backdrop-blur-md'"
        class="bg-white" >
        <ModalHeader v-text="('Reputation Check Report')"></ModalHeader>
        <ModalContent >
                <div class="mainContainerR">
                    <span class="headingR">RoboKiller:</span>
                    <span class="containerR" ref="robokiller" @click="showMsg(true, 'robokiller')"></span>
                    <div class="percentageR">{{ val.robokiller }}</div>
                </div>

                <div class="mainContainerR">
                    <span class="headingR">NomoRobo:</span>
                    <span class="containerR" ref="nomorobo" @click="showMsg(true, 'nomorobo')"></span>
                    <div class="percentageR">{{ val.nomorobo }}</div>
                </div>
                <div class="mainContainerR">
                    <span class="headingR">Intenal Flaged:</span>
                    <span class="containerR" ref="internal" @click="showMsg(true, 'internal')"></span>
                    <div class="percentageR">{{ val.internal }}</div>
                </div>
                <div class="mainContainerR">
                    <span class="headingR">FTC:</span>
                    <span class="containerR" ref="ftc" @click="showMsg(true, 'ftc')"></span>
                    <div class="percentageR">{{ val.ftc }}</div>
                </div>

                 <br>
                <hr>

                <div class="mainContainerR">
                    <span class="headingR">Over All:</span>
                    <span class="containerR" ref="overAll"></span>
                    <div class="percentageR">{{ val.overAll }}</div>
                </div>

        </ModalContent>
        <ModalFooter>
            <BasicButton
                dusk="cancel-upload-button"
                type="button"
                @click.prevent="show_msg=false;show_detail=false"
                >
                {{ __('Close') }}
            </BasicButton>
        </ModalFooter>
    </Modal>

     <Modal
        :show="show_msg"
        :role="'dialog'"
        :maxWidth="'md'"
        :class="'backdrop-opacity-0'"
        class="bg-white "
        @dblclick="showMsg(false);generateDetails()"
        >
        <ModalHeader >
            <div>Detail</div>
            <button
            @click.prevent="show_msg=false;generateDetails()"
            type="button"
            class="hover:text-red-500 focus:outline-none focus:ring ring-red-200 dark:ring-red-600 rounded h-10 w-10"
            style="position: absolute;    right: 8px;    top: 7px;    border: solid 2px;"
            > X </button>
        </ModalHeader>
        <ModalContent>
            <span>
                {{currunt_msg}}
            </span>
        </ModalContent>

    </Modal>

  </div>
</template>

<script>
var ProgressBar = require("progressbar.js");

export default {
  props: ["resourceName", "resource", "field"],
  data() {
    return {
        show_detail:false,
        show_msg:false,
        currunt_msg:'',
        shouldShow:false,
        val:{
            robokiller:0,
            nomorobo:0,
            internal:0,
            ftc:0,
            overAll:0,
        },
        rep:{
            robokiller:0,
            $nomorobo:0,
            internal:0,
            ftc:0,
            overAll:0,
        },

      options: {
        strokeWidth: 4,
        color: "#FFEA82",
        percentage: 1.0,
        type: "line",
        sub: null
      }
    };
  },
  mounted(){
        let vm = this;
        // console.log('resource;',this.resource)
        if(this.field.data.reputation_checked)
            this.shouldShow=true;
        this.$nextTick(()=>{
            this.drawLine();
        });
    },
  methods: {
    showMsg(st=false, type=''){type
        this.show_msg=st;
        if(st)
            this.show_detail=false;
        else
            this.show_detail=true;
        if(type){
            this.currunt_msg=this.message(type);

        }
    },
    generateDetails(){
        this.show_msg=false;
        if(this.field.value == null)return;
        this.show_detail = true;

        if (this.field.data.robokiller_status != 'negative')
                this.val.robokiller =   100;
            if (!this.field.data.nomorobo_status)
                this.val.nomorobo   =   100; //0 means a robocall 1 meanz not
            if (this.field.data.internal_flag != 'Y')
                this.val.internal   =   100;
            if (this.field.data.ftc_status != 'Y' )
                this.val.ftc    =   100;
            this.val.overAll= (
            ( this.val.robokiller + this.val.nomorobo + this.val.internal + this.val.ftc ) / 4
            );
        this.$nextTick(()=>{
            this.drawBar(this.$refs.robokiller, this.val.robokiller );
            this.drawBar(this.$refs.nomorobo, this.val.nomorobo );
            this.drawBar(this.$refs.internal, this.val.internal );
            this.drawBar(this.$refs.ftc, this.val.ftc );
            this.drawBarOvrall(this.$refs.overAll, this.val.overAll );
        });

    },
    drawLine() {
      var bar = new ProgressBar.Line(this.$refs.chartContainer, {
        strokeWidth: 4,
        easing: 'easeInOut',
        duration: 5000,
        color: '#62fc03',
        trailColor: '#eee',
        trailWidth: 1,
        svgStyle: {width: '200px', height: '100%'},
        from: {color: '#fc0303'},
        to: {color: '#62fc03'},
        step: (state, bar) => {
            bar.path.setAttribute('stroke', state.color);
        }
      });
      bar.animate(this.field.value);
    },
    drawBar(ref,value) {
        (new ProgressBar.Line(ref, {
            easing: 'easeInOut',
            color: value?'#007bff':'#ffc107',
            svgStyle: { width: '100%', height: '23px' },
        })).animate(1);
    },
    drawBarOvrall(ref,value) {
        (new ProgressBar.Line(ref, {
            strokeWidth: 4,
            easing: 'easeInOut',
            duration: 1000,
            color: '#62fc03',
            trailColor: '#eee',
            trailWidth: 1,
            svgStyle: {width: '100%', height: '23px'},
            from: {color: '#fc0303'},
            to: {color: '#62fc03'},
            step: (state, bar) => {
                bar.path.setAttribute('stroke', state.color);
            }
        })).animate(value/100??0);
    },
    reputationStatus(reputation_score){
        let msg="";
        if(!reputation_score)
            return 'Pending';
        if(reputation_score <=1){
            msg = "Good";
        }
        if(reputation_score <= .75){
        msg = "Fair";
        }
        if(reputation_score <= .50){
        msg = "Bad";
        }
        if(reputation_score <= .25){
        msg = "Terrible";
        }
        return msg;
    },
    reputationColor(s){
        let msg="";
        if(s <= 100){
            msg = "primary";
        }
        if(s <= 75){
        msg = "yellow";
        }
        if(s <= 50){
        msg = "orange";
        }
        if(s <= 25){
        msg = "danger";
        }
        return msg;
    },
    message(type ){
        let msg='';
        let field = this.field.data;
        if(type =='robokiller'){
            if(field.robokiller_status=='positive'){
                msg +="RoboKiller classified this number as good number and suggests that calls from it should be allowed Number has more positive feedbacks.";
            }else if(field.robokiller_status=='negative'){
                msg +="RoboKiller suggests that calls from it should be blocked Number has more negative feedbacks";
            }else{
                msg +="RoboKiller has no classification for a number Or Number has no feedback or they are not consistent";
            }
        }
        if(type =='nomorobo'){
            if(field.nomorobo_status)
                msg +='Nomorobo conside this number to be a robocall number';
            else
                msg +='Nomorobo not consider this number to be a robocall number';
        }
        if(type =='internal'){
            if(field.internal_flag=="Y"){
                msg +='It is an internal number ';
            }else{
                msg +='It is not an internal number';
            }
        }
        if(type =='ftc'){
            if(field.ftc_status=="Y"){
                msg +='FTC consider this number to be a DNC number';
            }else{
                msg +='FTC not consider this number to be a DNC number';
            }
        }
        return msg;


    }
  }
};
</script>

<style scoped>
.chartContainer{
    display: inline-flex;
    height:18px
}
.mainContainerR {
    display: flex;
      justify-content: center;
    align-items: center;
  margin-top: 20px;
  margin-bottom: 20px;

    }
.containerR {

  width: 327px;
  /* height: 8px; */
}

.headingR{
    width: 23%;
    padding: 4px;

}
.percentageR{
    width: 7%;
    padding: 4px;
}

.statusMainR{
        padding: 5px;
    font-size: 16px;
    font-weight: 900;
}
</style>
