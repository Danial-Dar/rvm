<template>
  <div>
    <template v-if="status == 'paused'">
      <span class="px-2">
        <Icon
          type="play"
          v-tooltip.click="__('Resume Campaign')"
          @click.stop="update('played')"
        />
      </span>
    </template>
    <!-- <template v-if="status == 'played' || status == 'pending'"> -->
    <template v-if="status == 'played' || status == 'outside of hours'">
      <span class="px-2">
        <Icon
          type="pause"
          v-tooltip.click="__('Pause Campaign')"
          @click.stop="update('paused')"
        />
      </span>
    </template>
    <!-- <template v-if="status == 'finished'">
      <span class="px-2">
        <Icon
          type="refresh"
          v-tooltip.click="__('Reset Campaign')"
          @click.stop="update('reset')"
        />
      </span>
    </template> -->
    <template v-if="status == 'finished'">
      <span class="px-2">
        <Icon
          type="refresh"
          v-tooltip.click="__('Reset Campaign')"
          @click.stop="reset('reset')"
        />
      </span>

      <span class="px-2">
        <Icon
          type="switch-vertical"
          v-tooltip.click="__('Reset Specific Dispositions')"
          @click.stop="dispReset('reset')"
        />
      </span>
    </template>
    <Modal
        :show="show"
        data-testid="confirm-upload-removal-modal"
        role="alertdialog"
      >
        <div
          class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
          style="width: 460px"
        >
          <ModalHeader v-text="__('Reset Campaign')" />
          <ModalContent>
            <p>By Clicking yes, you’re agreeing to reset your campaign and resend to the contacts selected as part of this campaign.</p>
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
                        @click.stop="update('reset')"
                        >
                        Yes
                        </LoadingButton>
            </div>
          </ModalFooter>
        </div>
      </Modal>

    <Modal
        :show="showDisp"
        data-testid="confirm-upload-removal-modal"
        role="alertdialog"
      >
        <div
          class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
          style="width: 460px"
        >
          <ModalHeader v-text="__('Reset Specific Dispositions')" />
          <ModalContent>
            <form>
                <div class="flex relative w-full mb-2">
                    <label class="label">Select Disposition</label>
                    <!-- <select multiple name="type" id="type" v-model="disposition" class="w-full block form-control form-select form-select-bordered" required="">
                        <option value="">Select Disposition</option>
                        <option value="CONTINUE">Continue</option>
                        <option value="NO_ANSWER">No Answer</option>
                        <option value="VM">VM</option>
                        <option value="OPTOUT">OPTOUT</option>
                        <option value="USER_BUSY">USER_BUSY</option>
                        <option value="NOVMNOINPUT">No Vm No Input</option>
                    </select> -->

                    <select multiple="" v-model="disposition" id="contact_list_id-default-multi-select-field" dusk="contact_list_id" class="w-full block form-control form-select form-select-multiple form-select-bordered">
                        <option disabled="" value="">Choose an option</option>
                        <option value="CONTINUE">Continue</option>
                        <option value="NO_ANSWER">No Answer</option>
                        <option value="VM">VM</option>
                        <option value="OPTOUT">OPTOUT</option>
                        <option value="USER_BUSY">USER_BUSY</option>
                        <option value="NOVMNOINPUT">No Vm No Input</option>
                    </select>
                </div>


            </form>
          </ModalContent>
          <ModalFooter>
            <div class="ml-auto">
              <LinkButton
                dusk="cancel-upload-delete-button"
                type="button"
                @click="showDisp = false"
                class="mr-3"
              >
                {{ __('Cancel') }}
              </LinkButton>

              <LoadingButton
                        type="submit"
                        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                        :loading="loading"
                        @click.stop="update('reset-disp')"
                        >
                        Yes
                        </LoadingButton>
            </div>
          </ModalFooter>
        </div>
    </Modal>
    <!-- <div class="relative mx-auto z-20 max-w-sm" v-if="showResetModal==true">
        <form class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <h3 class="text-90 uppercase tracking-wide font-bold md:text-sm border-b border-gray-100 dark:border-gray-700 py-4 px-8">
                Delete Resource
            </h3>
            <div class="py-3 px-8">
                <p class="leading-normal">Are you sure you want to delete the selected resources?</p>
            </div>
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-3 flex">
                <div class="ml-auto">
                    <button size="lg" align="center" component="button" type="button" data-testid="cancel-button" dusk="cancel-delete-button" class="mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 mr-3 appearance-none bg-transparent font-bold text-gray-400 hover:text-gray-300 active:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 dark:active:text-gray-600 dark:hover:bg-gray-800 mr-3">Cancel</button>
                    <button size="lg" align="center" component="button" dusk="confirm-delete-button" type="submit" class="shadow relative bg-red-500 hover:bg-red-400 text-white cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-red-500 hover:bg-red-400 text-white"><span class="">Delete</span></button>
                </div>
            </div>
        </form>
    </div> -->
  </div>
</template>
<script>
export default {
  props: {
    resource: {
      type: Object,
      default: {},
    },
  },
  data() {
    return {
      openResetModal() {
        this.showResetModal = false
      },
      show: false,
      showDisp: false,
      disposition: [],
      disp: false,
    }
  },
  computed: {
    status() {
      return this.resource.fields.find(a => a.attribute == 'status').value
    },
    id() {
      return this.resource.fields.find(a => a.attribute == 'id').value
    },
  },
  methods: {
    reset(status) {
        console.log('HEHEHEHEHEHEHEH')
        this.show = true;
    },
    dispReset(status) {
        console.log('HEHEHEHEHEHEHEH')
        this.showDisp = true;
    },
    async update(status) {
        if(status == 'reset-disp')
        {
            status = 'reset';
            this.disp = true;
            if (this.disposition.length == 0) {
                Nova.error('Please Select Disposition');
                return
            }
        }
      await Nova.request()
        .patch('/nova-api/campaigns/' + this.id, {
          status: status,
          disposition: this.disposition,
          disp: this.disp,
        })
        .then(
          res => {
            this.resource.fields.find(a => a.attribute == 'status').value = status;
            this.showDisp = false;
            this.show = false;
            this.$forceUpdate();
          },
          err => {
            for (const key in err.response.data.errors) {
              Nova.error(err.response.data.errors[key])
            }
          }
        )
      this.resource.fields.find(a => a.attribute == 'status').value = status
    },

  },
}
</script>
<style>
.multiselect__tag {
  background-color: #bfbfbf;
}

.multiselect__option--disabled{
  background: purple;
  color: white;
  font-style: italic;
}

.multiselect__option--highlight {
  background: #bfbfbf;
}

.multiselect__content {
   background: red;
}
</style>
