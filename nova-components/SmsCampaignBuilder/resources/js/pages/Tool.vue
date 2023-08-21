<style scoped>
.wiz-container {
    background-color: white;
    padding: 10px;
}
.stepwizard-footer {
    display: flex;
}
.pbar {
    width: 100%;
    height: 12px;
    /* background-color: white; */
    display: flex;
    position: absolute;
    top: 17px;
}
.pbar-progress {
    display: inline-block;
    height: 2px;
}
.step {
    margin: 10px;
    padding: 10px;
    /* border:1px solid grey ; */
    border-radius: 5px;
}
.bg-success,
.btn-primary {
    background-color: rgb(188, 188, 239);
    color: white;
}
.progress-bar {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    overflow: hidden;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #007bff;
    transition: width 0.6s ease;
}
.no-pointer {
    pointer-events: none;
}
</style>
<template>
    <div class="wiz-container">
        <div>
            <div class="stepwizard">
                <div class="stepwizard-row">
                    <div class="pbar">
                        <div
                            class="pbar-progress bg-green-500"
                            :style="{
                                width: (100 / 5) * currentStep + 10 + '%',
                            }"
                        ></div>
                    </div>
                    <div class="stepwizard-step">
                        <a
                            href="#step-1"
                            style="pointer-events: none"
                            id="step1"
                            type="button"
                            :class="[
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 2,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 3,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 4,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 1,
                                },
                                {
                                    'bg-primary-500 text-white':
                                        currentStep === 0,
                                },
                                { 'btn-default': !currentStep === 0 },
                            ]"
                            :step-id="currentStep"
                            class="btn-circle"
                            disabled="disabled"
                            >1</a
                        >
                        <p>Setup Campaign</p>
                    </div>
                    <div class="stepwizard-step">
                        <a
                            href="#step-2"
                            style="pointer-events: none"
                            id="step2"
                            type="button"
                            :class="[
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 3,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 4,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 2,
                                },
                                {
                                    'bg-primary-500 text-white':
                                        currentStep === 1,
                                },
                                { 'btn-default': !currentStep === 1 },
                            ]"
                            :step-id="currentStep"
                            class="btn-circle"
                            disabled="disabled"
                            >2</a
                        >
                        <p>List Contacts</p>
                    </div>
                    <div class="stepwizard-step">
                        <a
                            href="#step-3"
                            style="pointer-events: none"
                            id="step3"
                            type="button"
                            :class="[
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 3,
                                },
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 4,
                                },

                                {
                                    'bg-primary-500 text-white':
                                        currentStep === 2,
                                },
                                { 'btn-default': !currentStep === 2 },
                            ]"
                            :step-id="currentStep"
                            class="btn-circle"
                            disabled="disabled"
                            >3</a
                        >
                        <p>Message Builder</p>
                    </div>
                    <div class="stepwizard-step">
                        <a
                            href="#step-4"
                            style="pointer-events: none"
                            id="step4"
                            type="button"
                            :class="[
                                {
                                    'bg-green-500 text-white':
                                        currentStep === 4,
                                },
                                {
                                    'bg-primary-500 text-white':
                                        currentStep === 3,
                                },
                                { 'btn-default': !currentStep === 3 },
                            ]"
                            :step-id="currentStep"
                            class="btn-circle"
                            disabled="disabled"
                            >4</a
                        >
                        <p>Send Speed</p>
                    </div>
                    <div class="stepwizard-step">
                        <a
                            href="#step-5"
                            style="pointer-events: none"
                            id="step5"
                            type="button"
                            :class="[
                                {
                                    'bg-primary-500 text-white':
                                        currentStep === 4,
                                },
                                { 'btn-default': !(currentStep === 4) },
                            ]"
                            class="btn-circle"
                            :step-id="currentStep"
                            disabled="disabled"
                            >5</a
                        >
                        <p>Schedule Delivery</p>
                    </div>
                </div>
            </div>
        </div>

        <form
            id="campaignAddForm"
            method="post"
            enctype="multipart/form-data"
            @submit.prevent="loader()"
        >
            <h5 class="pt-3 px-6 font-bold">Create SMS Campaign</h5>

            <div class="content">
                <div v-show="currentStep === 0" class="step">

                    <div class="">
                        <div
                            class="pb-3"
                            :class="{
                                'border-error': !campaign_type && !isValid,
                            }"
                            id="campaignTypeDiv"
                        >
                            <label> Campaign Type</label>
                            <Multiselect
                                v-model="campaign_type"
                                placeholder="Select Campaign Type"
                                :options="campaign_type_option"
                                :searchable="true"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="py-2">
                            <label>Campaign Name</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="campaign_name"
                                    :class="{
                                        'border-error':
                                            !campaign_name && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="campaign_name"
                                    id="campaign_name"
                                    placeholder="Campaign Name"
                                    required
                                />
                            </div>
                        </div>






                        <div class="py-2">
                            <label>Caller Id Forward To Number</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 overflow-hidden"
                                id="forward_number_content"
                            >
                             <phone-number  :class="{
                                        'border-error':
                                            !forward_number && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800" :value="forward_number"  v-model="forward_number" id="forward_number" required />
                             <!--    <input
                                    type="text"
                                    name="forward_number"
                                    v-model="forward_number"
                                    id="forward_number"
                                    :class="{
                                        'border-error':
                                            !forward_number && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    placeholder="Add Caller Id Forward To Number (XXX) XXX-XXX"
                                    v-maska="'(###) ###-###'"
                                    required
                                /> -->
                            </div>
                        </div>

                        <!-- forward number end -->
                        <div
                            class="py-2"
                            id="campaignResponseDiv"
                            :class="{
                                'border-error': !receive_response && !isValid,
                            }"
                        >
                            <label>Receive Response</label>
                            <Multiselect
                                :id="'receive_response'"
                                v-model="example5.value"
                                v-bind="example5"

                                required
                            />
                        </div>

                        <div class="py-2">
                            <label>Domain URL</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden"
                            >
                                <input
                                    type="text"
                                    name="domain_url"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    :class="{
                                        'border-error':
                                            !domainUrlRegx && !isValid,
                                    }"
                                    v-model="domain_url"
                                    id="domain_url"
                                    placeholder="Domain URL"
                                    required
                                />
                            </div>
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !sms_use_case && !isValid,
                            }"
                            id="smsUseCaseDiv"
                        >
                            <label> Sms Use Case</label>
                            <Multiselect
                                v-model="sms_use_case"
                                placeholder="Select SMS Usecase"
                                :options="sms_use_case_option"
                                :searchable="true"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="py-2">
                            <label>Description</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="description"
                                    :class="{
                                        'border-error':
                                            !description && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="description"
                                    id="description"
                                    placeholder="Description"
                                    required
                                />
                            </div>
                        </div>

                        <div class="py-2">
                            <label>Message Flow</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="message_flow"
                                    :class="{
                                        'border-error':
                                            !message_flow && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="message_flow"
                                    id="message_flow"
                                    placeholder="Message Flow"
                                    required
                                />
                            </div>
                        </div>

                        <div class="py-2">
                            <label>Opt In Message</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="opt_in_message"
                                    :class="{
                                        'border-error':
                                            !opt_in_message && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="opt_in_message"
                                    id="opt_in_message"
                                    placeholder="Opt In Message"
                                    required
                                />
                            </div>
                        </div>

                        <div class="py-2">
                            <label>Opt Out Message</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="opt_out_message"
                                    :class="{
                                        'border-error':
                                            !opt_out_message && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="opt_out_message"
                                    id="opt_out_message"
                                    placeholder="Opt Out Message"
                                    required
                                />
                            </div>
                        </div>

                        <div class="py-2">
                            <label>Help Message</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="help_message"
                                    :class="{
                                        'border-error':
                                            !help_message && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="help_message"
                                    id="help_message"
                                    placeholder="Help Message"
                                    required
                                />
                            </div>
                        </div>

                        <div class="py-2">
                            <label>Number Pooling Per Campaign</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="number_pooling_per_campaign"
                                    :class="{
                                        'border-error':
                                            !number_pooling_per_campaign && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="number_pooling_per_campaign"
                                    id="number_pooling_per_campaign"
                                    placeholder="Number Pooling Per Campaign"
                                    required
                                />
                            </div>
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !direct_lending && !isValid,
                            }"
                            id="directLandingDiv"
                        >
                            <label> Direct Lending</label>
                            <Multiselect
                                v-model="direct_lending"
                                placeholder="Direct Landing"
                                :options="true_false_options"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !embedded_link && !isValid,
                            }"
                            id="embeddedLinkDiv"
                        >
                            <label> Embedded Link</label>
                            <Multiselect
                                v-model="embedded_link"
                                placeholder="Embedded Link"
                                :options="true_false_options"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !embedded_phone && !isValid,
                            }"
                            id="cembeddedPhoneDiv"
                        >
                            <label> Embedded Phone</label>
                            <Multiselect
                                v-model="embedded_phone"
                                placeholder="Embedded Phone"
                                :options="true_false_options"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !age_gated_content && !isValid,
                            }"
                            id="ageGatedContentDiv"
                        >
                            <label> Age Gated Content</label>
                            <Multiselect
                                v-model="age_gated_content"
                                placeholder="Age Gated Content"
                                :options="true_false_options"
                                ref="multiselect"
                                required
                            />
                        </div>

                        <div class="pb-3"
                            :class="{
                                'border-error': !lead_generation && !isValid,
                            }"
                            id="leadGenerationDiv"
                        >
                            <label> Lead Generation</label>
                            <Multiselect
                                v-model="lead_generation"
                                placeholder="Lead Generation"
                                :options="true_false_options"
                                ref="multiselect"
                                required
                            />
                        </div>


                    </div>
                </div>
                <div v-show="currentStep === 1" class="step">
                    <div class="">
                        <div>
                            <div
                                class="py-2"
                                id="contactListContent"
                                :class="{
                                    'border-error': !campaign_type && !isValid,
                                }"
                            >
                                <label>2. Select List of Contacts</label>
                                <Multiselect
                                    :id="'recipient'"
                                    v-model="recipient"
                                    placeholder="Choose a Recipient List"
                                    :options="recipient_options"
                                    :searchable="true"
                                    :class="{
                                        'border-error': !recipient && !isValid,
                                    }"
                                    mode="tags"
                                />
                            </div>

                            <div class="action-btn">
                                <!-- <UploadSmsContactList
                                    :title="'Upload New Contact List'"
                                    :islink="false"
                                    @added="onAddedContactList()"
                                /> -->

                                 <OutlineButton
                                    :size="'lg'"
                                    :align="'left'"
                                    @click="upload_contact_list_modal_show=!upload_contact_list_modal_show"
                                    type="button"
                                    >
                                    Upload New Contact List
                                    </OutlineButton>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="currentStep === 2" class="step">
                    <div class="py-2">
                        <h5 class="">3. Message Builder</h5>
                        <div class="mb-2">
                            <div class="" style="width: 100px">
                                <input
                                    type="checkbox"
                                    name="onoffswitch1"
                                    v-model="onoffswitch1"
                                    class="onoffswitch1-checkbox w-20"
                                    id="myonoffswitch1"
                                />

                                <label
                                    class="onoffswitch1-label"
                                    for="myonoffswitch1"
                                >
                                    <span class="onoffswitch1-inner"></span>
                                    <span class="onoffswitch1-switch"></span>
                                </label>
                            </div>
                        </div>

                        <div
                            id="message-preview-container"
                            v-if="messageWindowMessageShow"
                        >
                            <div class="message-window">
                                {{ messageWindowMessage }}
                            </div>
                            <div>
                                <OutlineButton
                                    type="button"
                                    id="regenrate-sytax"
                                    :size="'lg'"
                                    :align="'left'"
                                    @click="regenrateSytax()"
                                >
                                    generate spintax
                                </OutlineButton>
                            </div>
                        </div>

                        <div
                            id="message-edit-container"
                            v-if="messageEditContainerShow"
                        >
                            <div class="form-group mb-1">
                                <textarea
                                    name="message"
                                    :class="{
                                        'border-error': !message && !isValid,
                                    }"
                                    v-model="message"
                                    rows="12"
                                    cols="12"
                                    id="message"
                                    :disabled="!onoffswitch1"
                                    class="w-full"
                                    required
                                ></textarea>
                            </div>
                            <div class="character-container">
                                <p class="ml-2">
                                    <span id="character_length">{{
                                        character_length
                                    }}</span
                                    >/<span id="total_character_length"
                                        >160</span
                                    >
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="w-1-2 d-flex flex-wrap">
                                    <button
                                        @click="addShortCode('FNAME')"
                                        class="shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        FNAME
                                    </button>
                                    <button
                                        @click="addShortCode('LNAME')"
                                        class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        LNAME
                                    </button>
                                    <button
                                        @click="
                                            openRandomizer(
                                                'Words Randomizer Syntax'
                                            )
                                        "
                                        class="ml-1 randomizer btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        Words Randomizer Syntax
                                    </button>
                                    <button
                                        @click="addShortCode('DOMAIN')"
                                        class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        DOMAIN
                                    </button>
                                </div>
                                <div class="w-1-2 d-flex flex-wrap">
                                    <button
                                        @click="addShortCode('Custom1')"
                                        class="shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        Custom1
                                    </button>
                                    <button
                                        @click="addShortCode('Custom2')"
                                        class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        Custom2
                                    </button>
                                    <button
                                        @click="addShortCode('Custom3')"
                                        class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        Custom3
                                    </button>
                                    <button
                                        @click="addShortCode('Email')"
                                        class="ml-1 shortcode btn btn-light1 btn-rounded btn-sm"
                                        type="button"
                                    >
                                        Email
                                    </button>
                                </div>
                            </div>
                            <div
                                class=""
                                id="allow_long_message_div"
                                v-show="allow_long_message_container_show"
                            >
                                <CheckboxWithLabel
                                    id="allow_long_message_elm"
                                    :checked="allow_long_message"
                                    :name="'allow_long_message'"
                                    :value="'YES'"
                                    @input="
                                        allow_long_message = !allow_long_message
                                    "
                                >
                                    Allow Long Messages You'll be billed for 1
                                    message per 160 Characters.
                                </CheckboxWithLabel>
                            </div>
                            <div class="form-group d-flex">
                                <div
                                    class="alert alert-danger"
                                    v-if="message_errors_show"
                                    id="message_errors"
                                >
                                    <!--<p>Please remove the following banned words.</p>
                            <br/>
                            <ol id="error_list"><li>aaa</li></ol>  -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="currentStep === 3" class="step">
                    <div class="">
                        <h5 class="mt-10" style="color: #4e4d4dd6">
                            4. Send Speed
                        </h5>
                        <div class="">
                            <Slider
                                v-model="drops_per_hour"
                                :min="2000"
                                :max="10000000"
                                :required="true"
                            />
                            <div class="py-2">
                                <label class="px-2"> Per Hour:</label>
                                <input
                                    class=""
                                    type="number"
                                    v-model="drops_per_hour"
                                    required
                                    min="2000"
                                    max="10000000"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="currentStep === 4" class="step">
                    <div class="">
                        <h5 class="py-2">5. Set Campaign Send Time</h5>
                        <div class="py-2">
                            <BasicButton
                                :disabled="submitButtonDisable"
                                type="button"
                                @click="submitForm(false)"
                                class="mr-3 px-3 ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
                                >Send Now</BasicButton
                            >

                            <BasicButton
                                :disabled="submitButtonDisable"
                                type="button"
                                @click="campaignTimeShow()"
                                class="ml-3 px-3 ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
                                >Send Later</BasicButton
                            >
                            <!-- <button type="button" @click="testApiCallModal()" class="btn btn-primary ml-20">Test Call</button> -->
                        </div>
                        <div
                            class="py-2 inline-flex"
                            id="later_date"
                            v-show="laterDateShow"
                        >
                            <HeroiconsSolidCalendar
                                class="inline-block h-9"
                                style=""
                            />
                            <datepicker
                                class="inline-block h-9"
                                v-model="campaign_time"
                                :clearable="true"
                            >
                            </datepicker>
                            <BasicButton
                                type="button"
                                @click="submitForm(true)"
                                class="inline-block ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
                                >Save</BasicButton
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="stepwizard-footer"
                style="flex-direction: row-reverse; gap: 16px"
            >
                <BasicButton
                    type="button"
                    class="px-3 ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
                    :disabled="submitButtonDisable"
                    v-show="currentStep !== totalSteps"
                    @click="nextStep()"
                    >Next &gt;</BasicButton
                >

                <BasicButton
                    type="button"
                    class="items-end mr-3 ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 disabled:opacity-75"
                    :disabled="submitButtonDisable"
                    v-show="currentStep !== 0"
                    @click="previousStep()"
                    >&lt; Previous</BasicButton
                >
            </div>
        </form>

        <Modal
            :show="loaderModelShow"
            data-testid="loader-modal"
            :role="'alertdialog'"
        >
            <form
                @submit.prevent="submit"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >
                <ModalHeader v-text="'Your Campaign Is Adding'" />
                <ModalContent>
                    <div class="spinner-border text-info spin"></div>
                    <div id="seconds-counter"></div>
                    <Loader />
                </ModalContent>
            </form>
        </Modal>
        <Modal
            :show="randomizerModelShow"
            data-testid="randomizer-modal"
            :role="'dialog'"
        >
            <form
                @submit.prevent="submit"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >
                <ModalHeader v-text="'Words Randomizer Syntax'" />
                <ModalContent>
                    <div class="mb-5">
                        <p>
                            Randomize words in your Ad Text to improve campaign
                            performance by using syntax <br />
                            @{{ "{word1|word2|word3}" }}
                        </p>
                    </div>
                    <div>
                        <div>Example</div>
                        <div>
                            Hi, we have a great @{{ "{gift|offer|discount}" }}
                            for you
                        </div>
                    </div>
                </ModalContent>
                <ModalFooter>
                    <LinkButton
                        dusk="cancel-upload-delete-button"
                        type="button"
                        @click.prevent="
                            (randomizerModelShow = false), closeRandomizer()
                        "
                        class="mr-3"
                    >
                        {{ "OK" }}
                    </LinkButton>
                </ModalFooter>
            </form>
        </Modal>
        <Modal
            :show="add_contact_list_modal_show"
            id="loader-modal-contact-list"
            data-testid="confirm-upload-removal-modal"
            :role="'alertdialog'"
        >
            <form
                @submit.prevent=""
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >
                <ModalHeader v-text="'Your Contact List Is Adding'" />
                <ModalContent>
                    <Loader />
                </ModalContent>
            </form>
        </Modal>
        <Modal
            :show="upload_contact_list_modal_show"
            id="upload_contact_list_modal"
            data-testid="confirm-upload-removal-modal"
            :role="'dialog'"
        >
            <form
                method="post"
                enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
                style="width: 460px"
            >
                <ModalHeader v-text="'Add Contact List'" />
                <ModalContent>
                    <div>
                        <div class="py-2">
                            <label>Contact List Name</label>
                            <div
                                class="rounded-lg px-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 my-1 overflow-hidden mb-20"
                            >
                                <input
                                    type="text"
                                    name="contactlistName"
                                    :class="{
                                        'border-error':
                                            !contactlistName && !isValid,
                                    }"
                                    class="h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800"
                                    v-model="contactlistName"
                                    id="campaignContactListName"
                                    placeholder="List Name"
                                    required
                                />
                            </div>
                        </div>
                        <div class="py-2">
                            <label for="">Upload Contact List</label>
                            <input
                                type="file"
                                name="file"
                                id="campaignContactListFile"
                                accept=".csv"
                                @change="csvValidate()"
                                required
                                style="border: 1px solid #ced4da !important"
                            />
                        </div>
                    </div>
                </ModalContent>
                <ModalFooter>
                    <BasicButton
                        dusk="cancel-upload-button"
                        type="button"
                        class="mr-3"
                        @click="
                            upload_contact_list_modal_show =
                                !upload_contact_list_modal_show
                        "
                    >
                        {{ __("Cancel") }}
                    </BasicButton>

                    <loading-button
                        type="button"
                        :size="'lg'"
                        :align="'left'"
                        :loading="upload_contact_list_loading"
                        :disabled="upload_contact_list_loading"
                        @click="createContactList()"
                    >
                        Add Contact list
                    </loading-button>
                </ModalFooter>
            </form>
        </Modal>
    </div>
</template>

<script>
import Multiselect from "@vueform/multiselect";
import Slider from "@vueform/slider";
import Datepicker from "vue3-datepicker";
//import { maska } from "maska";
import PhoneNumber from '../components/PhoneNumber.vue';

// import 'vue-universal-modal/dist/index.css'

export default {
    //directives: { maska },
    components: {
        Multiselect,
        Slider,
        Datepicker,
        PhoneNumber,
        // VueFormStepper,
    },
    data() {
        return {
            totalSteps: 4,
            currentStep: 0,
            routePrefix: "/nova-vendor/sms-campaign-builder",
            link: {
                campaigStoreUrl: "/store",
                validateContactListCsvUrl: "/sms_contact-lists/validate_csv",
                contactListStoreUrl: "/sms_contact-lists",
                getAllContactListURL: "/get_campaign_contact_list",
                getSmsBannedWordURL: "/get_banned_words",
            },

            add_contact_list_modal_show: false,
            upload_contact_list_modal_show: false,
            upload_contact_list_loading: false,
            allow_long_message_container_show: false,
            randomizerModelShow: false,
            allow_long_message_elm: false,

            alertSuccessShow: false,
            alertErrorShow: false,
            laterDateShow: false,
            loaderModelShow: false,

            character_length: 0,
            messageWindowMessage: "",
            messageWindowMessageShow: false,
            messageEditContainerShow: true,
            message_errors_show: false,

            addContactListSubmitBtnPointer: false,
            submitButtonDisable: false,

            contactListFlag: false,
            has_banned_words: 0,
            example5: {
            //mode: 'tags',
            recipient_options: {},
            //closeOnSelect: false,

            options: [{ value: 'two_way_chat', label: 'Two Way Chat In Portal' },
        { value: 'email', label: 'Email' },
        { value: 'webhook', label: 'Webhook' },],
            searchable: true,
            //createOption: true,
            },

            campaign_type_option: {
                "Unregistered": "Unregistered",
                "10dlc_group": "10DLC Group",
                "toll_free_group_name": "Toll Free Group Name",
            },
            sms_use_case_option: {
                "2FA":"2FA",
                "ACCOUNT_NOTIFICATION":"ACCOUNT_NOTIFICATION",
                "AGENTS_FRANCHISES":"AGENTS_FRANCHISES",
                "CARRIER_EXEMPT":"CARRIER_EXEMPT",
                "CHARITY":"CHARITY", CONVERSATIONAL:"CONVERSATIONAL",
                "CUSTOMER_CARE":"CUSTOMER_CARE",
                "DELIVERY_NOTIFICATION":"DELIVERY_NOTIFICATION",
                "EMERGENCY":"EMERGENCY",
                "FRAUD_ALERT":"FRAUD_ALERT",
                "HIGHER_EDUCATION":"HIGHER_EDUCATION",
                "LOW_VOLUME":"LOW_VOLUME",
                "MARKETING":"MARKETING",
                "MIXED":"MIXED",
                "POLITICAL":"POLITICAL",
                "POLITICAL_SECTION_527":"POLITICAL_SECTION_527",
                "POLLING_VOTING":"POLLING_VOTING",
                "PUBLIC_SERVICE_ANNOUNCEMENT":"PUBLIC_SERVICE_ANNOUNCEMENT",
                "SECURITY_ALERT":"SECURITY_ALERT",
                "SOCIAL":"SOCIAL",
                "SWEEPSTAKE":"SWEEPSTAKE",
                "TRIAL":"TRIAL"
            },
            true_false_options:{
                true: "True",
                false: "False"
            },
            domainUrlRegx: false,
            contactlistName: "",
            isValid: true,
            //step1
            campaign_type: "",
            campaign_name: "",
            forward_number: "",
            receive_response: "",
            domain_url: "",
            sms_use_case:"",
            description:"",
            message_flow: "",
            opt_in_message: "",
            opt_out_message: "",
            help_message: "",
            number_pooling_per_campaign: "",
            direct_lending: false,
            embedded_link : false,
            embedded_phone : false,
            age_gated_content : false,
            lead_generation : false,
            //setp2
            recipient: [],
            //step3
            onoffswitch1: true,
            message: "",
            allow_long_message: false,
            //step4
            drops_per_hour: "2000",
            //step5
            campaign_time: new Date(),
        };
    },
    mounted() {
       this.$refs.multiselect.focus()
        if (this.message.length > 160) {
            this.allow_long_message_container_show = true;
            this.allow_long_message = true;
        } else {
            this.allow_long_message_container_show = false;
            this.allow_long_message = false;
        }
    },
    watch: {
        message: function (n, o) {
            this.messageChange();
        },
        onoffswitch1: function (n, o) {
            this.onOfSwitchChange();
        },
        allow_long_message: function (n, o) {
            this.messageChange();
        },
    },
    methods: {
        regenrateSytax() {
            let messageText = this.message;
            let random = Math.floor(Math.random() * 3);
            random++;
            let index = "$" + random;
            messageText = messageText.replaceAll(
                /@{{{(\w+)\|(\w+)\|(\w+)}}}/g,
                index
            );
            messageText = messageText.replaceAll(/{(\w+)}/g, "$1");
            this.messageWindowMessage = messageText;
        },
        nextStep() {
            this.nextChecks();
        },
        stepUp() {
            ++this.currentStep;
        },
        previousStep() {
            --this.currentStep;
        },
        nextChecks() {

            this.isValid = true;
            let msg = "Some Input Pending to Refill!\n";
            if (this.currentStep == 0) {
                this.isValid = !!this.campaign_type;
                this.isValid = !!this.campaign_name;
                this.isValid = !!this.forward_number;
                this.isValid = !!this.receive_response;
                if(!this.domain_url){
                    this.isValid = false;

                }else{
                    var expression = /[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/gi;
                    var regex = new RegExp(expression);
                    var t = this.domain_url;
                    console.log('t.match(regex):',t.match(regex));
                    if(t.match(regex) == null) {
                        this.domainUrlRegx=false;
                        this.isValid = false;
                    }else{
                        this.isValid = true;
                    }
                }
                this.isValid = !!this.sms_use_case;
                this.isValid = !!this.opt_in_message;
                this.isValid = !!this.opt_out_message;
                this.isValid = !!this.help_message;
                this.isValid = !!this.number_pooling_per_campaign;
                this.isValid = !!this.direct_lending;
                this.isValid = !!this.embedded_link;
                this.isValid = !!this.embedded_phone;
                this.isValid = !!this.age_gated_content;
                this.isValid = !!this.lead_generation;

                if (this.isValid && this.description.length >= 40 && this.message_flow.length >=40){
                     if(!this.contactListFlag){
                        this.contactListSelectfn().then(()=>{this.stepUp();});
                     }
                }else if(this.description.length < 40){
                    Nova.warning("Description is too short (minimum is 40 characters)");
                }else if(this.message_flow.length < 40){
                    Nova.warning("Message Flow is too short (minimum is 40 characters)");
                }
                else{
                    Nova.warning(msg);
                }

            } else if (this.currentStep == 1) {
                if(this.isValid = !!this.recipient.length){
                this.stepUp();
                }else{
                    Nova.warning('Select atleast one ContactList!');
                }
            } else if (this.currentStep == 2) {
                if (!this.message.length) {
                    this.isValid = false;
                    Nova.warning(
                        "A message needs To be added in message field!"
                    );
                } else {
                    let ajaxData = new FormData();
                    ajaxData.append("message", this.message);
                    Nova.request()
                        .post(
                            this.routePrefix + this.link.getSmsBannedWordURL,
                            ajaxData
                        )
                        .then(({ data }) => {
                            let bannedWords = data["bannedWords"];
                            let message = this.message;
                            let notAllowedWords = [];
                            bannedWords.forEach((word) => {
                                var regex = new RegExp(
                                    "(?:^|[^\\pL0-9_])(?:" +
                                        word.word +
                                        ")(?=$|[^\\pL0-9_])",
                                    "i"
                                );
                                this.isValid = !regex.test(message);
                                if (!this.isValid) {
                                    notAllowedWords.push(word.word);
                                }
                            });
                            this.has_banned_words = !(
                                notAllowedWords.length === 0
                            );
                            if (this.has_banned_words) {
                                msg += "This message has some Band Words in it";
                                Nova.error(msg);
                            } else {
                                this.stepUp();
                            }
                        })
                        .catch((error) => {
                            this.isValid = false;
                            Nova.error("An error occurred!");
                            console.log("An error occurred.");
                            console.log(error);
                        });
                }
            } else if (this.currentStep == 3) {
                this.isValid =
                    !!this.drops_per_hour ||
                    this.drops_per_hour > 10000000 ||
                    this.drops_per_hour < 2000;
                if (this.isValid) {
                    this.stepUp();
                } else {
                    Nova.warning("Drops per hour needed to select/type!");
                }
            }
        },
        addShortCode(shortcode) {
            let expected_length = (this.message + "{" + shortcode + "}").length;
            if (expected_length < 160) {
                this.allow_long_message_container = false;
                this.allow_long_message = false;
                this.message = this.message + "{" + shortcode + "}";
            } else {
                this.allow_long_message_container = true;
                if (this.allow_long_message) {
                    this.message = this.message + "{" + shortcode + "}";
                    this.character_length = this.message.length;
                } else {
                    this.message = this.message.substring(0, 160);
                }
            }
            this.character_length = this.message.length;
            document.getElementById("message").focus();
        },
        openRandomizer(shortcode) {
            this.randomizerModelShow = true;
            // this.addShortCode(shortcode);
        },
        closeRandomizer() {
            this.randomizerModelShow = false;
            let expected_length = (this.message + "@{{{word1|word2|word3}}}")
                .length;
            console.log("expected_length", expected_length);
            if (expected_length < 160) {
                this.allow_long_message_container = false;
                this.message = this.message + "@{{{word1|word2|word3}}}";
            } else {
                this.allow_long_message_container = true;
                console.log("allow_long_message", this.allow_long_message);
                console.log("this.message", this.message);
                if (this.allow_long_message) {
                    this.message = this.message + "@{{{word1|word2|word3}}}";
                    this.character_length = this.message.length;
                    return;
                } else {
                    this.message = this.message.substring(0, 160);
                }
                console.log("finalmessage", this.message);
            }
            this.character_length = this.message.length;
            // docment.getElementById('message').focus();
        },
        onOfSwitchChange() {
            if (!this.onoffswitch1) {
                let messageText = this.message;
                let random = Math.floor(Math.random() * 3);
                random++;
                let index = "$" + random;
                messageText = messageText.replaceAll(
                    /@{{{(\w+)\|(\w+)\|(\w+)}}}/g,
                    index
                );
                messageText = messageText.replaceAll(/{(\w+)}/g, "$1");
                this.messageWindowMessage = messageText;
            }
            this.messageWindowMessageShow = !this.messageWindowMessageShow;
            this.messageEditContainerShow = !this.messageEditContainerShow;
        },
        messageChange() {
            this.has_banned_words = 0;
            if (this.message.length >= 160) {
                this.allow_long_message_container_show = true;
                if (this.allow_long_message) {
                    this.message_errors_show = false;
                } else {
                    this.message = this.message.substring(0, 160);
                }
            } else {
                this.allow_long_message_container_show = false;
                this.allow_long_message = false;
            }
            this.message_errors_show = false;
            this.character_length = this.message.length;
        },
        contactListSelectfn() {
            return Nova.request()
                .get(this.routePrefix + this.link.getAllContactListURL)
                .then((response) => {
                    if (response.status == 200) {
                        this.contactListFlag = true;
                        this.recipient_options = {};
                        for (let i = 0; i < response.data.length; i++) {
                            // if(this.recipient_options[response.data[i].id] != undefined)
                            this.recipient_options[response.data[i].id] =
                                response.data[i].name;
                        }
                    } else {
                        Nova.warning("No list found.");
                    }
                    console.log("Contact list loaded successful.");
                })
                .catch((error) => {
                    console.log("An error occurred.");
                    console.log(error);
                });
        },
        loader: function () {
            this.loaderModelShow = true;
        },
        contactListLoader: function () {
            this.add_contact_list_modal_show = true;
        },
        csvValidate: function () {
            var fileInput = document.getElementById("campaignContactListFile");
            var filePath = fileInput.value;

            var allowedExtensions = /(\.csv)$/i;
            console.log(filePath, allowedExtensions);
            if (!allowedExtensions.exec(filePath)) {
                alert("Please choose a csv file");
                fileInput.value = "";
                return false;
            }

            let ajaxData = new FormData();
            ajaxData.append("file", fileInput.files[0]);
            this.addContactListSubmitBtnPointer = false;
            Nova.request()
                .post(
                    this.routePrefix + this.link.validateContactListCsvUrl,
                    ajaxData
                )
                .then((ressponse) => {
                    console.log(ressponse.data["success"]);
                    if (!response.data["success"]) {
                        this.addContactListSubmitBtnPointer = true;
                        alert(
                            "Please add a phone,first_name,last_name column to your CSV."
                        );
                        fileInput.value = "";
                    } else {
                        this.addContactListSubmitBtnPointer = true;
                    }
                });
        },
        createContactList: function () {
            // event.preventDefault();
            this.upload_contact_list_loading =
                !this.upload_contact_list_loading;
            if (!this.contactlistName) {
                alert("List Name is required");
                return;
            }
            let fileInp = document.getElementById("campaignContactListFile");
            if (fileInp.files.length === 0) {
                alert("File is required");
                return;
            }
            let ajaxData = new FormData();
            ajaxData.append("name", this.contactlistName);
            ajaxData.append("file", fileInp.files[0]);
            this.recipient = [];
            Nova.request()
                .post(this.links.contactListStoreUrl, ajaxData)
                .then((responce) => {
                    this.contactlistName = "";
                    this.contactlistFile = "";
                    this.upload_contact_list_modal_show =
                        this.upload_contact_list_loading = false;

                    var response = responce.data["contactList"];
                    if (response !== null) {
                        for (let i = 0; i < response.length; i++)
                            this.recipient_options[response[i].id] =
                                response[i].name;
                        Nova.warning("Submission was successful.");
                    } else {
                        Nova.warning("contact list not added");
                    }
                })
                .catch((error) => {
                    console.log("error:", error);
                    Nova.warning("an error came!");
                    this.upload_contact_list_modal_show =
                        this.upload_contact_list_loading = false;
                });
        },
        campaignTimeShow: function () {
            this.laterDateShow = !this.laterDateShow;
        },
        closeAlert: function () {
            this.alertSuccessShow = false;
            this.alertErrorShow = false;
        },
        onAddedContactList: function () {
            console.log("onAddedContactList:triggered");
            this.contactListSelectfn();
        },
        submitForm: function (ifnow = false) {
            this.submitButtonDisable = true;
            var data = {
                has_banned_words: this.has_banned_words,
                campaign_type: this.campaign_type,
                campaign_name: this.campaign_name,
                forward_number: this.forward_number,
                receive_response: this.receive_response,
                domain_url: this.domain_url,
                sms_use_case: this.sms_use_case,
                description: this.description,
                message_flow: this.message_flow,
                opt_in_message: this.opt_in_message,
                opt_out_message: this.opt_out_message,
                help_message: this.help_message,
                number_pooling_per_campaign: this.number_pooling_per_campaign,
                direct_lending: this.direct_lending,
                embedded_link : this.embedded_link,
                embedded_phone : this.embedded_phone,
                age_gated_content : this.age_gated_content,
                lead_generation : this.lead_generation,
                //setp2
                recipient: this.recipient,
                //step3
                onoffswitch1: this.onoffswitch1,
                message: this.message,
                allow_long_message: this.allow_long_message,
                //step4
                drops_per_hour: this.drops_per_hour,
                //step5
                campaign_time: ifnow ? this.campaign_time : null,
                message_variations: null,
            };
            Nova.request()
                .post(this.routePrefix + this.link.campaigStoreUrl, data)
                .then((response) => {
                    // console.log(response);
                    this.submitButtonDisable = false;
                    if (response.status == 200) {
                        if (response.data.status == "success") {
                            Nova.info(response.data.message);
                            this.stepUp();
                            //redirect to campaign  list view
                            Nova.visit("/resources/sms-campaigns");
                        } else {
                            Nova.error("An error accured");
                            Nova.log("Sms Camapign Crestion:Error");
                        }
                    }
                })
                .catch((error) => {
                    this.submitButtonDisable = false;
                    Nova.error("An error accured!");
                    console.log("Sms Camapign Crestion:Error", error);
                });
        },
    },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
<style src="@vueform/slider/themes/default.css"></style>
<!-- <style scoped src="../../css/bootstrap.css"></style> -->
<style scoped>
.stepwizard-step p {
    margin-top: 10px;
}
/* .has-error{
        color: red !important;
    } */
.border-error {
    border: 1px solid red !important;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

/* .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;

    } */
.progress {
    position: absolute;
    top: 14px;
    bottom: 0;
    width: 100%;
    height: 1px !important;
    background-color: #ccc;
    transition: width 0.2s;
    right: 15px;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
    width: 40px;
    height: 40px;
    text-align: center;
    padding: 7px 0;
    font-size: 14px;
    line-height: 1.428571429;
    border-radius: 20px;
    border: 1px solid #ccc;
}
.form-control {
    border: none;
    border-bottom: 1px solid #cbd0d6;
    width: 50%;
}
.loader {
    width: 200px;
    height: 200px;
    position: relative;
    text-align: center;
    overflow: auto;
    z-index: 2;
}

[placeholder]:focus::-webkit-input-placeholder {
    transition: text-indent 0.4s 0.4s ease;
    text-indent: -100%;
    opacity: 1;
}
.card {
    width: 75%;
}
.card-body {
    padding: 40px 0px 40px 40px;
}
.btn.btn-light {
    background: #f9f9f9;
}
.bootstrap-select > .dropdown-toggle {
    width: 50%;
}
.bootstrap-select .dropdown-menu {
    min-width: 51%;
    position: initial !important;
}
.cursor-pointer {
    cursor: pointer;
}
#message {
    border: 2px solid #ccc;
    border-radius: 8px;
}
.character-container {
    justify-content: flex-end;
    width: 50%;
    display: flex;
}
.modal-backdrop {
    /* z-index: 10000; */
}
.none {
    display: none;
}
.my-badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
        border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.message-window {
    padding: 4px 9px;
    display: inline-block;
    max-width: 60%;
    background: #d7d7d7;
    margin: 15px 0 15px;
    border-radius: 12px;
}
.btn.btn-light1 {
    background: #dcdcdc;
}
.w-1-2 {
    width: 50%;
}
.randomizer,
.shortcode {
    font-size: 11px;
    padding-top: 4px;
    margin-bottom: 3px;
}
textarea.form-control:focus {
    box-shadow: none;
}
.onoffswitch1 {
    position: relative;
    width: 100px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.onoffswitch1-checkbox {
    display: none;
}

.onoffswitch1-label {
    display: block;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #999999;
    border-radius: 30px;
    position: relative;
}

.onoffswitch1-inner {
    display: block;
    width: 200%;
    margin-left: -100%;
    -moz-transition: margin 0.1s ease-in 0s;
    -webkit-transition: margin 0.1s ease-in 0s;
    -o-transition: margin 0.1s ease-in 0s;
    transition: margin 0.1s ease-in 0s;
}

.onoffswitch1-inner:before,
.onoffswitch1-inner:after {
    display: block;
    float: left;
    width: 50%;
    height: 30px;
    padding: 0;
    line-height: 30px;
    font-size: 14px;
    color: white;
    font-family: Trebuchet, Arial, sans-serif;
    font-weight: bold;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 30px;
    box-shadow: 0px 15px 0px rgba(0, 0, 0, 0.08) inset;
}

.onoffswitch1-inner:before {
    content: "Edit";
    padding-left: 10px;
    background-color: #007bff;
    color: #ffffff;
    border-radius: 30px 0 0 30px;
}

.onoffswitch1-inner:after {
    content: "Preview";
    padding-right: 10px;
    background-color: #eeeeee;
    color: #999999;
    text-align: right;
    border-radius: 0 30px 30px 0;
}

.onoffswitch1-switch {
    display: block;
    width: 30px;
    margin: 0px;
    background: #ffffff;
    border: 2px solid #999999;
    border-radius: 30px;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 66px;
    -moz-transition: all 0.1s ease-in 0s;
    -webkit-transition: all 0.1s ease-in 0s;
    -o-transition: all 0.1s ease-in 0s;
    transition: all 0.1s ease-in 0s;
    background-image: -moz-linear-gradient(
        center top,
        rgba(0, 0, 0, 0.1) 0%,
        rgba(0, 0, 0, 0) 80%
    );
    background-image: -webkit-linear-gradient(
        center top,
        rgba(0, 0, 0, 0.1) 0%,
        rgba(0, 0, 0, 0) 80%
    );
    background-image: -o-linear-gradient(
        center top,
        rgba(0, 0, 0, 0.1) 0%,
        rgba(0, 0, 0, 0) 80%
    );
    background-image: linear-gradient(
        center top,
        rgba(0, 0, 0, 0.1) 0%,
        rgba(0, 0, 0, 0) 80%
    );
    box-shadow: 0 1px 1px white inset;
}

.onoffswitch1-checkbox:checked + .onoffswitch1-label .onoffswitch1-inner {
    margin-left: 0;
}

.onoffswitch1-checkbox:checked + .onoffswitch1-label .onoffswitch1-switch {
    right: 0px;
}
div.checkbox.switcher label,
div.radio.switcher label {
    padding: 0;
}
div.checkbox.switcher label *,
div.radio.switcher label * {
    vertical-align: middle;
}
div.checkbox.switcher label input,
div.radio.switcher label input {
    display: none;
}
div.checkbox.switcher label input + span,
div.radio.switcher label input + span {
    position: relative;
    display: inline-block;
    margin-right: 10px;
    width: 56px;
    height: 28px;
    background: #f2f2f2;
    border: 1px solid #eee;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
}
div.checkbox.switcher label input + span small,
div.radio.switcher label input + span small {
    position: absolute;
    display: block;
    width: 50%;
    height: 100%;
    background: #fff;
    border-radius: 50%;
    transition: all 0.3s ease-in-out;
    left: 0;
}
div.checkbox.switcher label input:checked + span,
div.radio.switcher label input:checked + span {
    background: #269bff;
    border-color: #269bff;
}
div.checkbox.switcher label input:checked + span small,
div.radio.switcher label input:checked + span small {
    left: 50%;
}
</style>
