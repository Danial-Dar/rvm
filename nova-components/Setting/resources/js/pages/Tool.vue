<template>
    <LoadingView :loading="loading" :key="pageId">
        <Head title="General" />

        <Heading class="mb-6">General</Heading>
        <form class="bg-white shadow-md rounded px-8 pt-6 py-8 mb-4">
            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Daily Limit API KEY</label
                >
                <input
                    
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Daily Limit Api Key"
                    aria-describedby="emailHelp"
                    v-model="settings.dailyLimitApiKey"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>
            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Daily Limit Password</label
                >
                <input
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="password"
                    placeholder="Daily Limit Password"
                    autocomplete="off"
                    aria-describedby="emailHelp"
                    v-model="settings.dailyLimitPassword"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Daily Limit</label
                >
                <input
                    
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="number"
                    placeholder="Daily Limit"
                    aria-describedby="emailHelp"
                    v-model="settings.dailyLimit"
                    min="1"
                    max="10000000"
                    @input="dailyLimit"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    RVM Call Price</label
                >
                <input
                    id="identity"
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="RVM Call Price"
                    aria-describedby="emailHelp"
                    v-maska="'#.###'"
                    v-model="settings.rvmCallPrice"
                />
                <!-- 
 onkeyup="if(parseInt(this.value)>500000){ this.value =value.slice(0,6); return false; }"
                    oninput="this.value = this.value.replace(/[^1-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"

                -->
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Bot Call Price</label
                >
                <input
                    
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Bot Call Price"
                    aria-describedby="emailHelp"
                    v-model="settings.botCallPrice"
                    v-maska="'#.###'"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Press-1 Call Price</label
                >
                <input
                    
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Press-1 Call Price"
                    aria-describedby="emailHelp"
                    v-model="settings.press1CallPrice"
                    v-maska="'#.###'"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Number Price</label
                >
                <input
                    
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Number Price"
                    aria-describedby="emailHelp"
                    v-model="settings.numberPrice"
                    v-maska="'#.###'"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="identity-input mb-4">
                <label
                    for="identity"
                    class="block text-gray-700 text-sm font-bold mb-2"
                >
                    Per Minute Price</label
                >
                <input
                    id="scrolltothis"
                    class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Per Minute Price"
                    aria-describedby="emailHelp"
                    v-model="settings.perMinPrice"
                   v-maska="'#.###'"
                />
                <span class="text-xs text-red-700" id="emailHelp"></span>
            </div>

            <div class="flex items-center justify-between">
                <!-- <button
            class="bg-blue-600 hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit"
          >
            Sign In
          </button> -->
                <button
                    @click.prevent="submitData"
                    class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                >
                    Update Setting
                </button>
            </div>
        </form>
    </LoadingView>
</template>

<script>
import { Errors } from "laravel-nova";
import { maska } from "maska";

export default {
    directives: { maska },
    data() {
        return {
            settings: {
                dailyLimitApiKey: null,
                dailyLimitPassword: null,
                dailyLimit: null,
                rvmCallPrice: null,
                botCallPrice: null,
                press1CallPrice: null,
                numberPrice: null,
                perMinPrice: null,
            },
            pageId: false,
            loading: false,
            isUpdating: false,
            fields: [],
            panels: [],
            authorizations: [],
            validationErrors: new Errors(),
        };
    },
    async created() {
        this.pageId = this.$page.props.pageId || "general";

        this.getFields();
    },
    methods: {
        dailyLimit(e){
        var value = e.target.value
        value = value.replace(/[^0-9.]/g, ''); 
        if(value > 10000000){
            e.target.value = 10000000
        }
        if(value == '0'){
            e.target.value = 1
        }
        
        console.log(value)
        // value = this.value.replace(/(\..*)\./g, '$1');
        },
        async submitData() {
            await Nova.request()
                .post("/nova-vendor/setting/settings", this.settings)
                .then((res) => {
                    console.log("res", res.data.data.status);

                    if (res.data.data.status == true) {
                        console.log("hehehahdhasdhasdhasdgasfdaytsd");
                        Nova.success("Settings Updated Successfully.");
                    }
                })
                .catch((err) => {
                    console.log("err", res.data);
                });
        },
        async getFields() {
            this.loading = true;
            this.fields = [];

            const params = { editing: true, editMode: "update" };
            if (this.pageId) params.path = this.pageId;

            await Nova.request()
                .get("/nova-vendor/setting/get-nova-settings")
                .then((res) => {
                    let data = res.data.data;
                    // console.log( data.fileds.dailyLimit)
                    if (data.status == true) {
                        this.settings.dailyLimitApiKey =
                            data.fileds.dailyLimitApiKey;
                        this.settings.dailyLimitPassword =
                            data.fileds.dailyLimitPassword;
                        this.settings.dailyLimit = data.fileds.dailyLimit;
                        this.settings.rvmCallPrice = data.fileds.rvmCallPrice;
                        this.settings.botCallPrice = data.fileds.botCallPrice;
                        this.settings.press1CallPrice =
                            data.fileds.press1CallPrice;
                        this.settings.numberPrice = data.fileds.numberPrice;
                        this.settings.perMinPrice = data.fileds.perMinPrice;
                    }
                });

            // const {
            //   data: { fields, panels, authorizations },
            // } = await Nova.request()
            //   .get('/nova-vendor/setting/get-nova-settings')
            //   .then(res => {
            //     let data = res.data.data
            //     if(data.status){

            //     }
            //   })
            //   .catch(error => {
            //     if (error.response.status == 404) {
            //       // this.$router.push({ name: '404' });
            //       return;
            //     }
            //   });
            // this.fields = fields;
            // this.panels = panels;
            // this.authorizations = authorizations;
            this.loading = false;
            console.log("faatatatata");
            document.body.style.overflow = "visible";
        },
        async update() {
            try {
                this.isUpdating = true;
                const response = await this.updateRequest();
                if (response && response.data) {
                    if (response.data.reload === true) {
                        location.reload();
                        return;
                    } else if (
                        response.data.redirect &&
                        response.data.redirect.length > 0
                    ) {
                        location.replace(response.data.redirect);
                        return;
                    }
                }
                Nova.success(this.__("novaSettings.settingsSuccessToast"));

                // Reset the form by refetching the fields
                await this.getFields();
                this.isUpdating = false;
                this.validationErrors = new Errors();
            } catch (error) {
                console.error(error);
                this.isUpdating = false;
                if (error && error.response && error.response.status == 422) {
                    this.validationErrors = new Errors(
                        error.response.data.errors
                    );
                    Nova.error(
                        this.__("There was a problem submitting the form.")
                    );
                }
            }
        },
        updateRequest() {
            return Nova.request().post(
                "/nova-vendor/settings/settings",
                this.formData
            );
        },
    },
    computed: {
        formData() {
            const formData = new FormData();
            this.fields.forEach((field) => field.fill(formData));
            formData.append("_method", "POST");
            if (this.pageId) formData.append("path", this.pageId);
            return formData;
        },
        panelsWithFields() {
            return this.panels.map((panel) => {
                return {
                    name: panel.name,
                    component: panel.component,
                    helpText: panel.helpText,
                    fields: this.fields.filter(
                        (field) => field.panel == panel.name
                    ),
                };
            });
        },
    },
};
</script>
