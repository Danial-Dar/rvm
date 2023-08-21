<template>
  <div>
    <div class="flex-shrink-0 ml-auto pr-2">
      <button
        @click="show = true"
        class="
          flex-shrink-0
          shadow
          rounded
          focus:outline-none
          ring-primary-200
          dark:ring-gray-600
          focus:ring
          bg-primary-500
          hover:bg-primary-400
          active:bg-primary-600
          text-white
          dark:text-gray-800
          inline-flex
          items-center
          font-bold
          px-4
          h-9
          text-sm
          flex-shrink-0
        "
      >
        Add Contact List
      </button>
    </div>
    <Modal
      :show="show"
      data-testid="confirm-upload-removal-modal"
      role="alertdialog"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 460px"
      >
        <ModalHeader v-text="__('Upload Contact List')" />
        <ModalContent>
          <div class="flex relative w-full mb-2" v-if="isSuper">
            <div class="md:w-1/5">
              <label for="">Company:</label>
            </div>
            <div class="flex-1">
              <select
                v-if="isSuper"
                name="company"
                id="company"
                class="
                  w-full
                  block
                  form-control form-select form-select-bordered
                "
                v-model="company_id"
                required
              >
                <option
                  v-for="company in companies"
                  :key="company.id"
                  :value="company.id"
                >
                  {{ company.name }}
                </option>
              </select>
            </div>
          </div>

          <div class="flex relative w-full mb-2">
            <div class="md:w-1/5">
              <label for="">Type:</label>
            </div>
            <div class="flex-1">
              <select
                name="type"
                id="type"
                class="
                  w-full
                  block
                  form-control form-select form-select-bordered
                "
                v-model="type"
                required
              >
                <option value="csv">CSV</option>
                <option value="individual">INDIVIDUAL</option>
              </select>
            </div>
          </div>

          <div class="flex relative w-full mb-2" v-if="type == 'individual'">
            <div class="md:w-1/5">
              <label for="">Number:</label>
            </div>
            <div class="flex-1">
              <input
                type="text"
                class="bg-white border focus:outline-none p-3 w-full"
                placeholder="+1 (123) 456-7890"
                v-maska="'+1 (###) ###-####'"
                v-model="number"
                required
              />
            </div>
          </div>
          <br />
          <div class="fieldmapper">
            <vue-csv-import
              v-if="type == 'csv'"
              v-model="csv"
              :fields="{ phone: { required: true, label: 'Phone' } }"
            >
              <!-- <vue-csv-toggle-headers></vue-csv-toggle-headers> -->
              <vue-csv-errors> </vue-csv-errors>
              <vue-csv-input
                name="file"
                v-model="file"
                :fileMimeTypes="['text/csv', 'text/x-csv']"
                :headers="true"
              ></vue-csv-input>
              <vue-csv-map :auto-match="true"></vue-csv-map>
            </vue-csv-import>
          </div>
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <DangerButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="show = false"
              class="mr-3"
            >
              {{ __('Cancel') }}
            </DangerButton>

            <LoadingButton
              :disabled="saveContactListButtonDisable"
              :loading="saveContactListButtonDisable"
              class="
                flex-shrink-0
                shadow
                rounded
                focus:outline-none
                ring-primary-200
                dark:ring-gray-600
                focus:ring
                bg-primary-500
                hover:bg-primary-400
                active:bg-primary-600
                text-white
                dark:text-gray-800
                inline-flex
                items-center
                font-bold
                px-4
                h-9
                text-sm
                flex-shrink-0
              "
              @click.prevent="saveContactList"
            >
              <!-- <vue-csv-submit url="/post/here"></vue-csv-submit> -->
              Create
            </LoadingButton>
          </div>
        </ModalFooter>
      </div>
    </Modal>
  </div>
</template>

<script>
import {
  VueCsvToggleHeaders,
  VueCsvSubmit,
  VueCsvMap,
  VueCsvInput,
  VueCsvErrors,
  VueCsvImport,
} from 'vue-csv-import'
import { maska } from 'maska'
import { mapGetters, mapMutations } from 'vuex'

export default {
  components: {
    VueCsvImport,
    VueCsvErrors,
    VueCsvInput,
    VueCsvMap,
    VueCsvSubmit,
    VueCsvToggleHeaders,
  },
  directives: {
    maska,
  },
  props: {
    responseLink: {
      default: '/resources/caller-id-contact-lists',
      type: String,
      required: false,
    },
  },
  data() {
    return {
    chunkSize:1000,
      company_id: null,
      companies: [],
      file: null,
      errors: [],
      type: 'csv', //csv,individual
      show: false,
      csv: null,
      number: '',
      isSuper: false,
      saveContactListButtonDisable:false,
    }
  },
  watch: {

  },
  computed: {
    ...mapGetters(['currentUser']),
  },
  mounted() {
    this.$nextTick(()=>{

        this.company_id = this.currentUser.company_id
        let role = this.currentUser.role
        if (role === 'admin') {
        this.isSuper = true
        Nova.request()
            .post('/nova-api/caller-id-contact-lists/getcompanies', {})
            .then(res => {
            console.log('res', res.data)
            if (res.data.companies) {
                this.companies = res.data.companies
            }
            })
        }

    });
  },
  methods: {
    showFields() {
    //   console.log('csv', this.csv)
    },
    chunks:function*(arr, n) {
        for (let i = 0; i < arr.length; i += n) {
            yield arr.slice(i, i + n);
        }
    },
    saveContactList() {
      if (!this.company_id) {
        Nova.warning('Empty or invalid Records')
        return
      }

        if (this.number && this.type=="individual"){
            this.saveContactListButtonDisable = true;

            Nova.request()
            .post('/nova-api/caller-id-contact-lists/upload', {
                type: this.type,
                number: this.number,
                company_id: this.company_id,
                file: [],
            }).then(res => {
                console.log('res', res.data)
                if (res.data.status == 'success') {
                    this.saveContactListButtonDisable = false
                    this.show = false
                    Nova.info(res.data.message);

                    if (this.responseLink){
                        Nova.visit(this.responseLink, { remote: false })
                    }
                }else{
                    this.saveContactListButtonDisable = false;
                    Nova.error(res.data.message);
                }
            }).catch(error => {
                Nova.error('An error came')
                console.log('error', error)
                this.saveContactListButtonDisable = false
            });
        } else if (
            this.csv &&
            this.csv.length &&
            this.type == "csv"
            ){

            console.log("this.csv:",this.csv);
            this.saveContactListButtonDisable = true;

            let chunksBuffer=[...this.chunks(this.csv, this.chunkSize)];
            console.log("chunksBuffer:",chunksBuffer);

            let totals=this.csv.length;
            let chunksTotals=chunksBuffer.length;
            let uniqueKey='unique-'+Date.now().toString(32)+'-'+(Math.random(999)*10000);
            let errorBucket=[];
            chunksBuffer.forEach((csv,i) => {
                csv=csv.map((c)=>c.phone);
                Nova.request()
                .post('/nova-api/caller-id-contact-lists/upload', {
                    type: this.type,
                    number: '',
                    company_id: this.company_id,
                    file: csv,

                    meta:{
                        chunksize:this.chunkSize,
                        chunk_total:chunksTotals,
                        index:i,
                        totals:totals,
                        unique:uniqueKey
                    }
                }).then(res => {
                    console.log('res', res.data)
                    if (res.data.status == 'success') {


                        if(chunksTotals ==  (1 + res.data.meta.index)){
                            // this.saveContactListButtonDisable = false
                            this.show = false
                                Nova.info(res.data.message);

                            if (this.responseLink){
                                Nova.visit(this.responseLink, { remote: false });
                            }
                        }
                    }else{
                        // this.saveContactListButtonDisable = false
                        errorBucket.push(res.data.message);
                        if(chunksTotals == (1+res.data.meta.index)){
                            this.saveContactListButtonDisable = false
                            //here display all error responces from bucket
                            let errorsText = errorBucket.filter(e=>!!e.length).join('<br>');
                            Nova.error(errorsText);
                            console.log('error:', errorBucket, ': At index:',res.data.meta.index);
                        }
                    }
                }).catch(error => {
                    errorBucket.push(error.data.message);
                     if(chunksTotals == (1+i)){
                        this.saveContactListButtonDisable = false
                        //here display all error responces from bucket
                        let errorsText = errorBucket.filter(e=>!!e.length).join('<br>');
                        Nova.error(errorsText);
                        console.log('error:', errorBucket, ': At index:',i);
                    }
                })

                // if(i == 0)
                //     setTimeout(()=>{}, 1000);
            });

        } else {
            Nova.warning('Empty or invalid or missing Entries')
        }
    },
  },
}
</script>

<style >
.fieldmapper table{
  width: 100%;
  margin-top: 10px;
}
</style>
