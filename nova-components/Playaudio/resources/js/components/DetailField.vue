<template>
    <div class="flex flex-col align-center md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0 border-t border-gray-100 dark:border-gray-700"
        dusk="filename">
        <div class="md:w-1/4 md:py-3">
            <h4 class="font-bold md:font-normal"><span>Audio</span></h4>
        </div>
        <div class="md:w-3/4 md:py-3 break-words">
            <p class="text-90 flex items-center">
              <audio controls>
                <source :src="'https://rvm.nyc3.digitaloceanspaces.com/RVM/'+field.value" type="audio/wav">
              </audio>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
    }

</script>
