<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3">
      <h3 class="text-3xl text-gray-500 font-light">Agent Ranking</h3>
      <br>
      <div style="overflow-x: hidden; height: 200px;">
      <table
                    class="w-full table-default card-scroll"
                    cellpadding="0"
                    cellspacing="0"
                    data-testid="resource-table"
                >
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="text-left whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Agent</span>
                            </th>
                            <th
                                class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Start Date</span>
                            </th>
                            <th
                                class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Score</span>
                            </th>
                            <th
                                class="text-left px-4 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"
                            >
                                <span>Rate</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr
                            v-for="item in listStats"
                            :key="item.name"
                            dusk="53-row"
                            class="group"
                            addition-actions="[object Object]"
                        > -->
                        <tr
                        v-for="agent in agents"
                            :key="agent.id"
                            dusk="53-row"
                            class="group"
                            addition-actions="[object Object]"
                        >
                            <td
                                class=" py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{agent.first_name}} {{agent.last_name}}
                                </div>
                            </td>
                            <td
                                class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{agent.created_at}}
                                </div>
                            </td>
                            <td
                                class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    {{agent.score}} %
                                </div>
                            </td>
                            <td
                                class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
                            >
                                <div
                                    class="text-left"
                                    resource="[object Object]"
                                >
                                    0.01%
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                </div>
    </div>
  </Card>
</template>

<script>
export default {
    data() {
    return {
      agents: [],
    };
  },
  props: [
    'card',

  ],

  mounted() {
    let start_date = "";
    let end_date = "";
    this.getData();
  },
  methods: {
        async getData() {
            let baseUrl = "/nova-api/custom/agents";
            await Nova.request()
                .get(baseUrl)
                .then((response) => {
                    // if (response.data.query.length > 0) {
                        this.agents = response.data.agents;
                        console.log(this.agents)
                    // }
                    // console.log("8.liststats------>", response.data.query);
                });
        },
    },
}
</script>
