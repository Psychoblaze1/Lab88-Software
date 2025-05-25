<template>
  <div class="w-full p-4">
    <CardPartial class="overflow-y-auto">
      <template #title>Instruments</template>
      <template #content>
        <table class="min-w-full text-xs">
          <thead class="bg-gray-200 text-black border-b p-2">
            <tr class="text-left">
              <th class="p-2">Manufacturer</th>
              <th class="p-2">Name</th>
              <th class="p-2">Focus</th>
              <th class="p-2">Paramters</th>
              <th class="p-2">Standards</th>
              <th class="p-2">Docs</th>
              <th class="p-2">Actions</th>
            </tr>
          </thead>
          <tbody class="overflow-x-auto">
            <tr
              v-for="(instrument, iKey) in instruments"
              :key="iKey"
              class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
            >
              <td class="p-2">{{ instrument.make }}</td>
              <td class="p-2">{{ instrument.name }}</td>
              <td class="p-2">distilation</td>
              <td class="p-2">
                <span
                  v-for="param in instrument.test_parameters"
                  class="text-xs pr-2 hover:text-accent hover:cursor-pointer"
                >
                  {{ param.name }}
                </span>
              </td>
              <td class="p-2">
                <span
                  v-for="method in instrument.test_methods"
                  class="text-xs pr-2 hover:text-accent hover:cursor-pointer"
                >
                  {{ method.name }}
                </span>
              </td>
              <td class="p-2">Doc</td>
              <td class="p-2">Add to Lab</td>
            </tr>
          </tbody>
        </table>
      </template>
    </CardPartial>
  </div>
</template>

<script>
import CardPartial from "../../partials/CardPartial.vue";
import SubmitButton from "../../components/SubmitButton.vue";

export default {
  name: "Instrument",
  data() {
    return {};
  },
  components: {
    CardPartial,
    SubmitButton,
  },
  computed: {
    instruments() {
      return this.$store.getters["systemLibrary/instruments"];
    },
  },
};
</script>
