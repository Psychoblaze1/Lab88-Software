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
        <table class="w-full h-full text-xs overflow-y-auto">
          <thead class="bg-gray-200 text-black sticky top-0">
            <tr class="text-left">
              <th>Category</th>
              <th>Test Parameter</th>
              <th>Description</th>
              <th>Unit</th>
            </tr>
            <!-- Filters -->
          </thead>
          <tbody class="overflow-y-auto">
            <tr
              v-for="(paramter, key) in testParameters"
              :key="key"
              class="border-b border-opacity-20 hover:bg-gray-200"
            >
              <td class="p-2">
                {{ paramter.category.name }}
              </td>
              <td class="p-2">
                {{ paramter.name }}
              </td>
              <td class="p-2">
                <span v-if="paramter.description">
                  {{ paramter.description.content }}
                </span>
              </td>
              <td class="p-2">
                {{ paramter.unit }}
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
  name: "test-paramters",
  data() {
    return { searchQuery: "" };
  },
  components: {
    CardPartial,
  },
  computed: {
    testParameters() {
      return this.$store.getters["systemLibrary/testParameters"]
        .filter((parameter) => {
          if (!this.searchQuery.length) {
            return parameter;
          }
          if (parameter.name.toLowerCase().includes(this.searchQuery.toLowerCase())) {
            return parameter;
          }
        })
        .sort(function (a, b) {
          // same category, sort by Parameter Name
          if (a.category === b.category) {
            return a.name > b.name ? 1 : -1;
          }
          // return category sort
          return a.category > b.category ? 1 : -1;
        });
    },
  },
};
</script>
