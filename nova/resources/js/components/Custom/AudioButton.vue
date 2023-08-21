<template>
  <div>
    <template v-if="status == 'success'">
      <span class="px-2">
        <Icon
          type="chat"
          v-tooltip.click="__('Conversation')"
          @click.stop="loadChat"
        />
      </span>
    </template>
    <template>
      <Modal
        :show="showChat"
        data-testid="conversation-modal"
        role="alertdialog"
      >
        <div
          class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
          style="width: 900px"
        >
          <ModalHeader v-text="__('Conversation Report')" />
          <ModalContent>
            <div class="flex-container">
              <div class="item1">
                  <div v-for="chat in chatData" :key="chat.time" class="containerChat" >
                    <p>{{ chat.text }}</p>
                    <span class="time-left" >{{ chat.time }}</span>
                  </div>

                  <div  class="containerChat darker">
                    <p class="right">{{ chatData[0].text }}</p>
                    <br />
                    <span class="time-right">{{ chatData[0].time }}</span>
                  </div>
              </div>
              <div class="item2">
                <div>
                  <h1>Topics:</h1>
                  <div style="width: 150px">
                    <span
                    v-for="topic in topics"
                    :key="topic.id"
                      class="
                        inline-flex
                        items-center
                        whitespace-nowrap
                        h-6
                        px-2
                        m-2
                        rounded-full
                        uppercase
                        text-xs
                        font-bold
                        badge-success
                      "
                      >{{topic.title}}</span
                    >
                  </div>
                </div>
                <div>
                  <h1 class="mt-4">Words:</h1>
                  <div style="width: 150px">
                    <span
                      class="
                        inline-flex
                        items-center
                        whitespace-nowrap
                        h-6
                        px-2
                        m-2
                        rounded-full
                        uppercase
                        text-xs
                        font-bold
                        badge-info
                      "
                      >email</span
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="audio-player">
              <AudioPlayer
                :option="{
                  src: audioPath,
                  title: filename,
                  coverImage:
                    'https://icon-library.com/images/headphones-png-icon/headphones-png-icon-11.jpg',
                }"
              />
            </div>
          </ModalContent>
          <ModalFooter>
            <div class="ml-auto">
              <LinkButton
                dusk="cancel-upload-delete-button"
                type="button"
                @click.prevent="showChat = false"
                class="mr-3"
              >
                {{ __('Cancel') }}
              </LinkButton>
            </div>
          </ModalFooter>
        </div>
      </Modal>
    </template>
    <!-- <template v-if="status == 'played' || status == 'pending'"> -->
  </div>
</template>
<script>
import AudioPlayer from 'vue3-audio-player'
import 'vue3-audio-player/dist/style.css'

export default {
  props: {
    resource: {
      type: Object,
      default: {},
    },
  },
  components: {
    AudioPlayer,
  },
  data() {
    return {
      showChat: false,
      chatData: [],
      topics: null,
      audioPath: null
    }
  },
  computed: {
    status() {
      return this.resource.fields.find(a => a.attribute == 'status').value
    },
    filename() {
      return this.resource.fields.find(a => a.attribute == 'filename').value
    },
    id() {
      return this.resource.fields.find(a => a.attribute == 'id').value
    },
  },
  methods: {
    async loadChat() {
      console.log(
        '?????????????????????????????????????????????????????????????????????????????'
      )
      console.log(this.filename)
      await Nova.request()
        .get('/nova-api/custom/audio/' + this.id)
        .then(res => {
          console.log(res.data)
          this.chatData = res.data.chatData
          this.topics = res.data.topics
            // this.audioPath = URL.createObjectURL('https://rvm.nyc3.digitaloceanspaces.com/RVM/' + this.filename)
            this.audioPath = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/' + this.filename
          console.log(this.topics)
        })

      this.showChat = true
    },
  },
  mounted() {},
}
</script>

<style scoped>
.flex-container {
  display: flex;

  /* background-color: #bbdefb; */
  height: 100%;
  padding: 15px;
  gap: 5px;
}

.flex-container > div {
  /* background: #ffecb3; */
  border: 3px solid rgba(var(--colors-primary-300));
  border-radius: 5px;
  padding: 8px;
}

.item1 {
  /* flex:1 1 auto; */
  flex-grow: 1;
  flex-shrink: 1;
  align-self: stretch;
}

.item2 {
  /* flex:0 1 auto; */
  order: 1;
  flex-grow: 0;
  flex-shrink: 1;
  align-self: stretch;
}
.audio-player {
  width: 100%;
}

/* chat messages */
.containerChat {
  border: 2px solid rgba(var(--colors-primary-300));
  background-color: rgba(var(--colors-primary-100));
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
  width: 50%;
}

.darker {
  border-color: rgba(var(--colors-primary-100));
  background-color: rgba(var(--colors-primary-300));
  float: right;
}

.containerChat::after {
  content: '';
  clear: both;
  display: table;
}

.containerChat img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.containerChat p.right {
  float: right;
  margin-left: 20px;
  margin-right: 0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}
</style>
