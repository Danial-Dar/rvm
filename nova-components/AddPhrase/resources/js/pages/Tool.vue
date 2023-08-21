<template>
  <div>
    <Head title="Add Phrase" />

    <Heading class="mb-6">Add Phrase</Heading>

    <Card
      class="flex flex-col mb-2"
      style="min-height: 300px"
    >
      <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 py-8 mb-4">

        <div class="identity-input mb-4">
          <label
            for="title"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Phrase</label
          >
          <input
          id="title"
            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="title"
            v-model="title"
            placeholder="Title"
            aria-describedby="emailHelp"
            required
          />
          <span class="text-xs text-red-700" id="emailHelp"></span>
        </div>
        

        <div class="identity-input mb-4">
          <label
            for="topic"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Topic</label
          >
          <select
            v-model="topic_id"
            id="topic_id"
            name="topic_id"
            dusk=""
            class="w-full block form-control form-select form-select-bordered"
            required
          >
            <option
                disabled=""
                :value="null"
            >
                Choose a topic
            </option>
            <option
                v-for="topic in topics"
                :value="topic.id"
                :key="topic.title"
            >
                {{ topic.title }}
            </option>
          </select>
          
          
        </div>
        

        <div class="identity-input mb-4">
          <label
            for="min_count"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Minimum Count</label
          >
          <input
            id="min_count"
            name="min_count"
            v-model="min_count"
            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="number"
            placeholder="Minimum Count"
            aria-describedby="emailHelp"
            required
          />
          <span class="text-xs text-red-700" id="emailHelp"></span>
        </div>
        <div class="identity-input mb-4">
          <label
            for="speaker"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Speaker</label
          >
            
          <input type="radio" class="mr-2" id="" name="speaker" value="0" v-model="speaker">Agent
          <input type="radio" class="mr-2 ml-2" id="" name="speaker" value="1" v-model="speaker">Contact
          <input type="radio" class="ml-2 mr-2" id="" name="speaker" value="2" v-model="speaker">Both

        </div>

        <div class="identity-input mb-4">
          <label
            for="flag_type"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Flag Type</label
          >
            
          <input type="radio" class="mr-2" id="" name="flag_type" value="0" v-model="flag_type">Banned
          <input type="radio" class="mr-2 ml-2" id="" name="flag_type" value="1" v-model="flag_type">Required
          <input type="radio" class="ml-2 mr-2" id="" name="flag_type" value="2" v-model="flag_type">Context

        </div>

        <div class="identity-input mb-4">
          <label
            for=""
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Rate Option</label
          >
        </div>

        <div class="identity-input mb-4">
          <input type="checkbox" value="reviewable" class="mr-2" name="is_reviewable" v-model="is_reviewable">
          <label>Reviewable</label>
        </div>

        <div class="identity-input mb-4">
          <input type="checkbox" value="non_scorable" class="mr-2" name="is_non_scorable" v-model="is_non_scorable">
          <label>Non Scorable</label>
        </div>

        <div class="identity-input mb-4">
          <input type="checkbox" value="force_review" class="mr-2" name="is_force_review" v-model="is_force_review">
          <label>Force Review</label>
        </div>

        <div class="identity-input mb-4">
          <label
            for=""
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Location In Call</label
          >
          <input
            id="location_first"
            name="location_first"
            v-model="location_first"
            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="First X"
            aria-describedby="emailHelp"
            required
          />
          <input
            id="location_last"
            name="location_last"
            v-model="location_last"
            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="Last X"
            aria-describedby="emailHelp"
            required
          />
          <span class="text-xs text-red-700" id="emailHelp"></span>
        </div>

        <div class="identity-input mb-4">
          <label
            for=""
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Time</label
          >
            
          <input type="radio" class="mr-2" id="" name="time" value="seconds" v-model="time">Seconds
          <input type="radio" class="mr-2 ml-2" id="" name="time" value="percent" v-model="time">Percent

        </div>

        <!-- <div class="identity-input mb-4">
          <label
            for="phrase_link"
            class="block text-gray-700 text-sm font-bold mb-2"
          >
            Phrase Link</label
          >
          <input
            id="phrase_link"
            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            placeholder="Phrase Link"
            aria-describedby="emailHelp"
          />
          <span class="text-xs text-red-700" id="emailHelp"></span>
        </div> -->
        <div class="flex items-center justify-between">
          
          <button class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0" type="submit">
            Add Phrase
          </button>

        </div>
      </form>
    </Card>

    
  </div>
</template>

<script>
export default {
    data() {
    return {
      topics: [],
      topic_id: null,
      title: null,
      min_count: null,
      speaker: null,
      flag_type: null,
      is_reviewable: false,
      is_non_scorable: false,
      is_force_review: false,
      location_first: null,
      location_last: null,
      time: null
    };
  },
  mounted() {},
  methods: {
    async submit() {
      console.log('Submit')
      if (this.topic_id == null) {
        alert("Please Select Topic")
        return
      }
      if (this.speaker == null) {
        alert("Please Select Speaker")
        return
      }
      if (this.flag_type == null) {
        alert("Please Select Flag Type")
        return
      }
      if (this.time == null) {
        alert("Please Select Time")
        return
      }
      await Nova.request()
        .post(
            "/nova-api/custom/add-phrase/",
            {
              topic_id: this.topic_id,
              title: this.title,
              min_count: this.min_count,
              speaker: this.speaker,
              flag_type: this.flag_type,
              is_reviewable: this.is_reviewable,
              is_non_scorable: this.is_non_scorable,
              is_force_review: this.is_force_review,
              location_first: this.location_first,
              location_last: this.location_last,
              time: this.time
            }).then(res => {
                if(res.data.success){
                    console.log('success')
                    Nova.success(res.data.message)
                    Nova.visit("/resources/phrases");
                }else{
                    console.log('fail')
                    Nova.error(res.data.message)
                }
            },
            
        );
      
    },
  },
    async created() {
        console.log("asdasd");
        await Nova.request()
            .get("/nova-api/custom/topics")
            .then((res) => {
                this.topics = res.data;
                console.log('hahaha', this.topics)
            });
        
    }
  
}
</script>

<style>
/* Scoped Styles */
</style>
