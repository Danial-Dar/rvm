<template>
  <div>
    <span class="px-2">
      <Icon
        type="paper-airplane"
        v-tooltip.click="__('Reply')"
        @click.stop="handleReplyButton()"
      />
    </span>

    <Modal
      :show="show"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 460px"
      >
        <ModalHeader v-text="__('Reply to ' + email)" />
        <ModalContent>
          <p>
            <textarea rows="10" cols="50" disabled
              >{{ contentMessage }} </textarea
            >
          </p>
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click="show = false"
              class="mr-3"
            >
              {{ __('Cancel') }}
            </LinkButton>
            <LoadingButton
              type="submit"
              class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
              :loading="loading"
              @click="send()"
            >
              Send
            </LoadingButton>
          </div>
        </ModalFooter>
      </div>
    </Modal>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  props: {
    resource: {
      type: Object,
      default: {},
    },
  },
  data() {
    return {
      show: false,
      loading: false,
      contentMessage: '',
      selectedTestId: 0,
    }
  },
  computed: {
    id() {
      return this.resource.fields.find(a => a.attribute == 'id').value
    },
    firstName() {
      return this.resource.fields.find(a => a.attribute == 'first_name').value
    },
    lastName() {
      return this.resource.fields.find(a => a.attribute == 'last_name').value
    },
    email() {
      return this.resource.fields.find(a => a.attribute == 'email').value
    },
    // message() {
    //   return this.resource.fields.find(a => a.attribute == 'message').value
    // },
  },
  mounted() {
    Nova.request()
      .get('/api/contact-us/' + this.id)
      .then(response => {
        this.contentMessage = response.data.data.message
      })
      .catch(error => {
        alert(error)
      })
  },
  methods: {
    handleReplyButton() {
      this.show = true
    },
    async send() {
      this.loading = true
      Nova.request()
        .get('/api/reply-mail', {
          params: {
            first_name: this.firstName,
            last_name: this.lastName,
            email: this.email,
            message: this.contentMessage,
          },
        })
        .then(response => {
          this.show = false
        })
        .catch(error => {
          //   alert('The requested URL was not found on this server.')
          alert(error)
        })
    },
  },
}
</script>
