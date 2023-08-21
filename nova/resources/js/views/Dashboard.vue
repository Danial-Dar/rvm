<template>
    <div :dusk="'dashboard-' + this.name">

        <Head :title="label" />

        <Heading v-if="label && cards.length > 1" class="mb-3">{{
      __(label)
    }}</Heading>

        <div v-if="tabs.length >0">
            <ul
                class="mb-2 flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <li class="mr-2" @click="activeTab = tab.name" v-for="tab in tabs" :key="tab.name">
                    <a href="#" aria-current="page"
                        class="inline-block p-4 rounded-t-lg dark:bg-gray-800 dark:text-blue-500"
                        :class="{ 'bg-gray-100 text-primary font-bold': tab.name == activeTab }">{{tab.name}}</a>
                </li>
            </ul>
            <div v-for="tab in tabs" :key="tab.name">

                <div v-show="tab.name == activeTab">
                    <Cards v-if="tab.cards.length > 0" :cards="tab.cards" />
                </div>
            </div>
        </div>
        <div v-else-if="shouldShowCards">
            <Cards v-if="cards.length > 0" :cards="cards" />
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: false,
                default: 'main',
            },
        },

        data: () => ({
            label: '',
            cards: [],
            tabs: [],
            activeTab: null
        }),

        created() {
            this.fetchDashboard()
        },

        methods: {
            async fetchDashboard() {
                try {
                    const {
                        data: {
                            label,
                            cards,
                            tabs
                        },
                    } = await Nova.request().get(this.dashboardEndpoint, {
                        params: this.extraCardParams,
                    })

                    this.label = label
                    this.cards = cards
                    this.tabs = tabs
                    if (tabs[0] != null)
                        this.activeTab = tabs[0].name
                } catch (error) {
                    if (error.response.status == 401) {
                        return Nova.redirectToLogin()
                    }

                    Nova.visit('/404')
                }
            },
        },

        computed: {
            /**
             * Get the endpoint for this dashboard.
             */
            dashboardEndpoint() {
                return `/nova-api/dashboards/${this.name}`
            },

            /**
             * Determine whether we have cards to show on the Dashboard
             */
            shouldShowCards() {
                return this.cards.length > 0
            },

            /**
             * Get the extra card params to pass to the endpoint.
             */
            extraCardParams() {
                return null
            },
        },
    }

</script>
<style>
.text-primary{
    color: #23a2d9;
}
</style>
