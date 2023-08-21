<template>
    <div>
        <Head title="Bot" />

        <Heading class="mb-6">Bot</Heading>
        <!--
        <Card
            class="flex flex-col items-center justify-center"
            style="min-height: 800px"
        > -->

        <iframe :src="url"></iframe>

        <!-- </Card> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: "",
        };
    },
    mounted() {
        this.url = "https://steady-treacle-6e5ea0.netlify.app/";
    },
    methods: {},
};
</script>

<style>
/* Scoped Styles */
iframe {
    height: 100vh;
    width: 150vh;
}
</style>
