<template>
    <div>

        <div class="flex-shrink-0 ml-auto pr-2">
            <button @click="show=true"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">Add Payment</button>
        </div>
        <!-- <Modal :show="show" data-testid="confirm-upload-removal-modal" role="alertdialog">
            <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden" style="width: 460px">
                <ModalHeader v-text="__('Upload Dnc')" />
                <ModalContent>
                    <input type="file" @change="uploadFile" ref="file">
                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton
            dusk="cancel-upload-delete-button"
            type="button"
            @click.prevent="show=false"
            class="mr-3"
          >
            {{ __('Cancel') }}
          </LinkButton>
                        <button type="submit" href="dnc/upload"
                class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0">Upload
                Dnc</button>


                    </div>
                </ModalFooter>
            </form>
        </Modal> -->
        <Modal :show="show" data-testid="payment-modal" role="alertdialog">
            <form
                @submit.prevent="submit"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >
                <ModalHeader v-text="__('Payment')" />
                <ModalContent>
                    <div class="flex relative w-full mt-3 mb-2">
                        <input
                        class="w-full form-control form-input form-input-bordered"
                        id="amount"
                        type="text"
                        placeholder="Enter Amount"
                        v-model="amount"
                        required
                        name="amount"
                        />
                    </div>

                    <div class="flex relative w-full mt-3 mb-2">
                        <select
                            name="company_id"
                            id="company_id"
                            v-model="company_id"
                            @change="getBalance"
                            class="w-full block form-control form-select form-select-bordered"
                            required
                        >
                            <option value="">Select Company</option>
                            <option
                                v-for="(company, key) in companies"
                                :value="company.id"
                                :key="key"
                            >
                            {{ company.name }}
                            </option>
                        </select>
                    </div>

                    <div class="flex relative w-full mt-3 mb-2">
                        <textarea
                        class="w-full form-control form-input form-input-bordered"
                        id="textarea"
                        rows="5"
                        placeholder="Enter Payment Decription"
                        v-model="payment_description"
                        required
                        name="payment_description"
                        >
                        </textarea>
                    </div>

                    <div class="flex relative w-full mt-3 mb-2">
                        <label>Current Balance:</label>
                    </div>
                    <div class="flex relative w-full mt-3 mb-2">
                        <input
                        class="w-full form-control form-input form-input-bordered"
                        id="balance"
                        type="text"
                        v-model="balance"
                        required
                        readonly
                        name="balance"
                        />
                    </div>
                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton
                        dusk="cancel-upload-delete-button"
                        type="button"
                        @click.prevent="show = false"
                        class="mr-3"
                        >
                        {{ __('Cancel') }}
                        </LinkButton>
                        <LoadingButton
                        type="submit"
                        class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                        :loading="loading"
                        @click="loading=false"
                        >
                        Add Billing
                        </LoadingButton>
                    </div>
                </ModalFooter>
            </form>
        </Modal>
    </div>
</template>
<script>
export default {
    data(){
        return {
            show: false,
            amount: null,
            payment_description: null,
            user_id: null,
            company_id: null,
            balance: null,
            companies: [],
        }
    },
    async mounted() {
        await Nova.request().get('/nova-api/custom/companies')
            .then(res => {
                this.companies = res.data.companies
                console.log('this.companies')
                console.log(this.companies.length)
            }, err => {

            })
        
        
    },
    methods:{
        async submit() {
            this.loading = true;
    
            let data = {
                company_id : this.company_id,
                amount : this.amount,
                payment_description : this.payment_description
            };
            // let amount = this.result.amount;
            let params = data
            
            await Nova.request().post('/nova-api/custom/payment', params)
            .then(response => {
                this.loading = false;
                this.show = false;
                if(response.data.data.success){
                Nova.success('Balance added successfully.');
                }else{
                Nova.error('Error In Payment Process.');
                }
                
                
            })
    
        },

        async getBalance() {
            let company_id = event.target.value
            console.log('company_id:',company_id)
            let params = {
                company_id: company_id,
            }
            this.loading = true
            await Nova.request()
                .post('/nova-api/custom/get-company-balance', params)
                .then(response => {
                this.loading = false
                console.log('result', response.data)
                
                    let data = response.data
                    this.balance = data
                    Nova.success('Balance fetch successfully')
                
                })
            // this.file = this.$refs.file.files[0];
        },
        
    }
}
</script>
