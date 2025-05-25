<template>
  <div class="p-4">
    <CardPartial class="overflow-y-auto">
      <template #title> Test Parameters </template>
      <template #cta>
        <input
          class="border-b border-gray-600"
          type="text"
          v-model="searchQuery"
          placeholder="Search"
        />
      </template>
      <template #content>
        <table class="w-full h-full text-xs">
          <thead class="bg-gray-200 text-black sticky top-0">
            <tr class="text-left">
              <th>Test Parameter</th>
              <th>Description</th>
            </tr>
            <!-- Filters -->
          </thead>
          <tbody class="overflow-y-auto">
            <tr
              v-for="(standard, key) in testStandards"
              :key="key"
              class="border-b border-opacity-20 hover:bg-gray-200"
            >
              <td class="p-2">
                {{ standard.name }}
              </td>

              <td class="p-2">
                <span v-if="standard.description">
                  {{ standard.description.content }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </template>
    </CardPartial>
  </div>
</template>
<script>
import CardPartial from "../../partials/CardPartial.vue";

export default {
  name: "test-standards",
  data() {
    return { searchQuery: "" };
  },
  components: {
    CardPartial,
  },
  created() {
    if (!this.$store.getters["systemLibrary/testStandards"].length > 0) {
      this.$store.dispatch("systemLibrary/getTestStandards");
    }
  },

  computed: {
    testStandards() {
      return this.$store.getters["systemLibrary/testStandards"]
        .filter((standard) => {
          if (!this.searchQuery.length) {
            return standard;
          }
          if (standard.name.toLowerCase().includes(this.searchQuery.toLowerCase())) {
            return standard;
          }
        })
        .sort(function (a, b) {
          return a.name > b.name ? 1 : -1;
        });
    },
  },
};
</script>
