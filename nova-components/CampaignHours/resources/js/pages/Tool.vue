<template>
  <div>
    <Head title="Campaign Hours" />

    <Heading class="mb-6">Campaign Hours</Heading>
    <p class="text-muted mb-6">We will deliver your campaign between the hours you specify.</p>
    <Card
      class="flex flex-col"
      style="min-height: 300px"
    >
      <form action="" method="post" enctype="multipart/form-data" style="padding: 30px 30px 30px 30px;">
          
          <div class="flex flex-row mb-6" v-for ="(day,key) in days" :key="key">
            <div class="flex-1">
              <input type="checkbox" @click="showField($event)" class="" name="days[]" v-model="data[day]['checked']"  /> {{day}}
            </div>
              <div class="flex-1" :class="[day]" v-show="Object.hasOwn(data[day],'checked') && data[day]['checked'] ">
                  <select name="from_time[]" 
                    :id="`${day}_from_time`" 
                    @change="setCampaignTime(day)"
                    v-model="data[day]['fromTime']"
                    >
                      <option value="">Select From Time</option>
                      <option 
                      v-for="(time,key) in timeArray" 
                      :value="key" 
                      :key="key"
                      :selected="fromTime && fromTime[day] ==  key"
                      >
                      {{time}}
                      </option>
                  </select>
              </div>
              <div class="flex-1" :class="[day]" v-show="Object.hasOwn(data[day],'checked') && data[day]['checked'] ">
                to
              </div>
              <div class="flex-1" :class="[day]" v-show="Object.hasOwn(data[day],'checked') && data[day]['checked'] ">
                  <select name="to_time[]" class=""
                    :id="`${day}_to_time`"
                    @change="setCampaignTime(day)" 
                    
                    v-model="data[day]['toTime']"
                    >
                      <option value="">Select To Time</option>
                      <option
                      
                      v-for="(time,key) in timeArray" 
                      :value="key"
                      :key="key"
                      :selected="toTime && toTime[day] ==  key"
                      >
                      {{time}}
                      </option>
                  </select>
              </div>
            
          </div>
          <div class="flex flex-row mb-6">
            <span><bold>Note: </bold> <i> All Times are in Central Standard Time </i></span>
          </div>
          
          
          <div class="flex flex-1">
            <a href="javascript:void(0)" @click="updateCampaignHours()" class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">Update Campaign Hours</a>
          </div>
      </form>
    </Card>
  </div>
</template>

<script>
export default {
  data(){
    return{
      dncTime: null,
      timeArray : null,
      fromTime: null,
      toTime: null,
      checkedDays: null,
      days:['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'],
      data:{
        'Monday':{checked:false,toTime:"",fromTime:""},
        'Tuesday':{checked:false,toTime:"",fromTime:""},
        'Wednesday':{checked:false,toTime:"",fromTime:""},
        'Thursday':{checked:false,toTime:"",fromTime:""},
        'Friday':{checked:false,toTime:"",fromTime:""},
        'Saturday':{checked:false,toTime:"",fromTime:""},
        'Sunday':{checked:false,toTime:"",fromTime:""}
      },

    }

  },
  mounted() {
    //
  },
  created(){
    var  ch=this;
    Nova.request().get('/nova-vendor/campaign-hours/get-campaign-hours').then(response => {
        ch.checkedDays=response.data.checkedDays;
        if(response.data.checkedDays){
          ch.days.forEach((value)=>{
            if(response.data.checkedDays.includes(value)){
                ch.data[value]['checked'] = true;
                ch.data[value]['fromTime'] =response.data.fromTime[value]??''
                ch.data[value]['toTime'] = response.data.toTime[value]??''
            }
              
              
          })
        }
        //  console.log(ch.data)
        // :checked="checkedDays && checkedDays.includes(day)"
        ch.dncTime=response.data.dncTime;
        ch.timeArray=response.data.timeArray;
        ch.fromTime=response.data.fromTime;
        ch.toTime=response.data.toTime;

    })
  },
  methods:{
    setCampaignTime(day){

          document.getElementById(`${day}_from_time`).setAttribute('required',true);
          document.getElementById(`${day}_to_time`).setAttribute('required',true);
 
          let fromTime = this.data[day]['fromTime'];
          // let toTime = document.getElementById(`${day}_to_time`).value;
          let toTime = this.data[day]['toTime'];
          let fromSelectedOptions = document.getElementById(`${day}_from_time`).selectedOptions;
          let toSelectedOptions = document.getElementById(`${day}_to_time`).selectedOptions;

          if(fromTime !== '' && toTime !== ''){
              if(toTime <= fromTime){
                    alert('Please select valid time.');
                    // console.log(fromSelectedOptions)
                    // fromSelectedOptions[0].selected = false
                    // toSelectedOptions[0].selected = false;
                    this.data[day]['fromTime'] = "";
                    this.data[day]['toTime'] = "";
                }else{
                    return true;
                }
          }
      
    },
    showField(event){
      let value = event.target.value;
      let checked = event.target.checked;
      let element = document.getElementsByClassName(value)
      if(checked){
        for(let i=0;i<element.length;i++){
          element[i].style.display="block";
        }
        //  console.log(document.getElementsByClassName(value))
      }else{
        for(let i=0;i<element.length;i++){
          element[i].style.display="none";
        }
      }
      // const checked = document.querySelector('#accept:checked') !== null;
      // console.log(event.target.checked)
    },
    updateCampaignHours(){
     
      let days = Object.keys(this.data);
      let datan = [];
      days.forEach((day)=>{
          if(this.data[day].checked && this.data[day].fromTime && this.data[day].toTime){

            datan.push({
              'day' : day,
              'fromTime' : this.data[day].fromTime,
              'toTime' : this.data[day].toTime
            })
          }else{
            this.data[day].checked=false;
            this.data[day].fromTime = "";
            this.data[day].toTime = "";
          }
      })
      
      Nova.request().post('/nova-vendor/campaign-hours/update-campaign-hours',datan).then(response => {
        
        let result = response.data.data
        if(response.data.success){
          alert('Campaign hours updated successfully.')
        }else{
          alert('Campaign hours not updated. Please select from & to time.')
        }
        
      }).catch(function (error) {
          console.log(error.response)
      });
    }
  }
}
</script>

<style>
/* Scoped Styles */
</style>
