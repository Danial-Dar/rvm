<template>
    <!--<PanelItem :index="index" :field="field" />-->
    <div
        class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
        dusk="{{this.field.attribute}}"
    >
        <div class="md:w-1/4 md:py-3">
            <h4 class="font-bold md:font-normal">
                <span>{{ this.field.name }}</span>
            </h4>
        </div>
        <div class="md:w-3/4 md:py-3 break-words">
            <p
                class="text-90 flex items-center"
                v-if="this.field.type !== 'main'"
            >
                {{ this.field.recordingName }}
            </p>
            <span
                class="inline-block text-sm mb-1 mr-2 px-2 py-0 bg-primary-500 text-white dark:text-gray-900 rounded"
                v-else
                >{{ this.field.recordingName }}</span
            >
        </div>
    </div>
</template>

<script>
export default {
    props: ["index", "resource", "resourceName", "resourceId", "field"],
    // mounted() {
    //     console.log("dddad", this.field);
    // },
};
</script>
