<template>
    <div>
        <LoadingView :loading="loading" :key="pageId">
            <Card
                class="flex flex-col justify-center p-3"
                style="min-height: 300px"
            >
                <Head title="User Setting" />
                <Heading class="mb-6 ml-4">User Setting</Heading>
                <form
                    ref="setting_form"
                    class="shadow-md rounded px-4 pt-6 pb-8 mb-4"
                    enctype="multipart/form-data"
                >
                    <div class="identity-input mb-4">
                        <label class="inline-flex items-center mt-3">
                            <input
                                type="checkbox"
                                class="form-checkbox h-5 w-5 text-gray-600"
                                v-model="settings.isDailyLimit"
                            />
                            <span class="ml-2 text-gray-700">Daily Limit</span>
                        </label>
                    </div>
                    <div
                        class="identity-input mb-4"
                        v-if="settings.isDailyLimit"
                    >
                        <input
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="number"
                            placeholder="Daily Limit"
                            aria-describedby="dailyLimitHelp"
                            v-model="settings.dailyLimit"
                        />
                        <span
                            class="text-xs text-red-700"
                            id="dailyLimitHelp"
                        ></span>
                    </div>
                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Avatar</label
                        >
                        <div class="my-1 items-center">
                            <span
                                class="inline-block h-14 w-14 rounded-full overflow-hidden bg-gray-100 m-5"
                            >
                                <span v-show="!settings.avatarUrl">
                                    <svg
                                        class="h-full w-full text-gray-300"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </span>
                                <span v-show="settings.avatarUrl">
                                    <img
                                        :src="settings.avatarUrl"
                                        alt="avatar not found"
                                        style="width: 100%;height: auto"
                                    />
                                </span>
                            </span>
                            <div class="flex-1">
                                <input
                                    class=""
                                    type="file"
                                    ref="my_file"
                                    id="my-avatar"
                                    accept="image/jpeg, image/png"
                                    @change="onUploadFile"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Api Key</label
                        >
                        <input
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="text"
                            placeholder="Api Key"
                            aria-describedby="apiKey"
                            v-model="settings.apiKey"
                        />
                        <span class="text-xs text-red-700" id="apiKey"></span>
                    </div>
                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Api Key</label
                        >
                        <input
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="text"
                            placeholder="Api Password"
                            aria-describedby="apiPassword"
                            v-model="settings.apiPassword"
                        />
                        <span
                            class="text-xs text-red-700"
                            id="apiPassword"
                        ></span>
                    </div>
                    <div class="identity-input mb-4">
                        <label
                            for="email_input"
                            class="block text-gray-700 text-sm font-bold mb-2"
                            >Email</label
                        >
                        <input
                            id="email_input"
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="email"
                            placeholder="Email"
                            aria-describedby="emaiinputHelp"
                            v-model="settings.email"
                        />
                        <span
                            class="text-xs text-red-700"
                            id="emaiinputHelp"
                        ></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <button
                            @click.prevent="submitData"
                            class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                        >
                            Update Setting
                        </button>
                    </div>
                </form>
            </Card>

            <Card
                class="flex flex-col justify-center mt-2 p-3"
                style="min-height: 300px"
            >
                <Head title="User Setting" />
                <Heading class="mb-6 ml-4">Change Password</Heading>
                <form class="shadow-md rounded px-4 pt-6 pb-8 mb-4">
                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                        >
                            Old Password</label
                        >
                        <input
                            id="identity"
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="password"
                            placeholder="Old Password"
                            aria-describedby="newPass"
                            v-model="oldPassword"
                            ref="oldpassword"
                            required
                        />
                        <span class="text-xs text-red-700" id="newPass"></span>
                    </div>

                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                        >
                            New Password</label
                        >
                        <input
                            id="identity"
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="password"
                            ref="password"
                            placeholder="New Password"
                            aria-describedby="newPass"
                            v-model="newPassword"
                            required
                        />
                        <span class="text-xs text-red-700" id="newPass"></span>
                    </div>

                    <div class="identity-input mb-4">
                        <label
                            for="identity"
                            class="block text-gray-700 text-sm font-bold mb-2"
                        >
                            Confirm Password</label
                        >
                        <input
                            id="identity"
                            class="shadow appearance-none borderrounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            type="password"
                            ref="confirm_password"
                            placeholder="Confirm Password"
                            aria-describedby="confPass"
                            v-model="confPassword"
                            required
                        />
                        <span class="text-xs text-red-700" id="confPass"></span>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            @click.prevent="submitPassword"
                            class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
                        >
                            Update Password
                        </button>
                    </div>
                </form>
            </Card>
        </LoadingView>
    </div>
</template>

<script>
import { Errors } from "laravel-nova";

export default {
    data() {
        return {
            settings: {
                isDailyLimit: false,
                dailyLimit: null,
                email: null,
                apiKey: null,
                apiPassword: null,
                avatar: null,
                avatarUrl: "",
                avatarFileName: "",
            },

            newPassword: "",
            oldPassword: "",
            confPassword: "",

            pageId: false,
            loading: false,
            isUpdating: false,
        };
    },
    async created() {
        this.pageId = this.$page.props.pageId || "user-setting";
        this.getFields();
    },
    methods: {
        onUploadFile(event) {
            var files = event.target.files || event.dataTransfer.files;
            if (!files.length) return;
            this.settings.avatarUrl = URL.createObjectURL(files[0]);
            console.log("event", this.settings.avatarUrl);
        },
        async submitPassword() {
            if (!this.oldPassword) {
                console.log(this.$refs.oldpassword);
                this.$refs.oldpassword.setCustomValidity(
                    "Old password must be given"
                );
                this.$refs.oldpassword.reportValidity();
                // Nova.error('Old password must be given')
            } else if (!this.newPassword) {
                this.$refs.password.setCustomValidity(
                    "New password must be given"
                );
                this.$refs.password.reportValidity();
                // Nova.error('New password must be given')
            } else if (!this.confPassword) {
                this.$refs.confpassord.setCustomValidity(
                    "Password confirmation must be given"
                );
                this.$refs.confpassord.reportValidity();
                // Nova.error('Password confirmation must be given')
            } else if (this.newPassword === this.confPassword) {
                await Nova.request()
                    .post("/nova-vendor/user-setting/password", {
                        password: this.newPassword,
                        password_confirmation: this.confPassword,
                        oldpassword: this.oldPassword,
                    })
                    .then((res) => {
                        console.log("res", res);
                        if (res.data.status == true) {
                            Nova.success("Password Updated Successfully.");
                            this.oldPassword =
                                this.newPassword =
                                this.confPassword =
                                    "";
                        }
                    })
                    .catch((err) => {
                        console.log("err:", err.response.data.errors);
                        if ( Object.keys(err.response.data.errors).includes("password") ) {
                            let msg =  err.response.data.errors.password.join("<br>");
                            console.log( " this.$ref.newPassword.", this.$refs.password );
                            this.$refs.password.setCustomValidity(msg);
                            this.$refs.password.reportValidity();
                            Nova.error(msg);
                        }
                        if (Object.keys(err.response.data.errors).includes("oldpassword") ) {
                            let msg =  err.response.data.errors.oldpassword.join("<br>");
                            this.$refs.oldpassword.setCustomValidity(msg);
                            this.$refs.oldpassword.reportValidity();
                            Nova.error(msg);
                        }
                    });
            } else {
                Nova.error("Password Not Match To confirm Password");
            }
        },
        async submitData() {
            if (!this.settings.email) {
                this.$refs.setting_form.reportValidity();
                return;
            }

            var formData = new FormData();
            if(this.$refs.my_file.files[0])
            formData.append("image", this.$refs.my_file.files[0]);
            [
                'isDailyLimit',
                "dailyLimit",
                "email",
                "apiKey",
                "apiPassword",
            ].forEach((v) => {
                if(this.settings[v])
                    formData.append(v, this.settings[v]);
            });

            await Nova.request()
                .post("/nova-vendor/user-setting/settings", formData, {
                    Headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.log("res", res.data.status);

                    if (res.data.status == true) {
                        Nova.success("Settings Updated Successfully.");
                    }
                })
                .catch((err) => {
                    console.log("err", err.data);
                });
        },
        async getFields() {
            this.loading = true;
            this.fields = [];

            const params = { editing: true, editMode: "update" };
            if (this.pageId) params.path = this.pageId;

            await Nova.request()
                .get("/nova-vendor/user-setting/get-nova-settings")
                .then((res) => {
                    let data = res.data;
                    // console.log( data)
                    if (data.status) {
                        this.settings.dailyLimit = data.fields.daily_max_limit;
                        this.settings.isDailyLimit =
                            data.fields.daily_max_limit > 0;
                        this.settings.apiKey = data.fields.api_key;
                        this.settings.apiPassword = data.fields.api_password;

                        this.settings.email = data.userData.email;
                        this.settings.avatarFileName = data.userData.avatar;
                        this.settings.avatarUrl = data.userData.avatar_url;
                    }
                    // console.log( this.settings)
                });
            this.loading = false;
        },
    },
};
</script>

<style>
/* Scoped Styles */
input:invalid {
    /* border: 2px solid red; */
}
</style>
