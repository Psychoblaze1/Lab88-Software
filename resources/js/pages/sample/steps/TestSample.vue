<template>
  <div class="w-full p-4 bg-white shadow-md mb-4 rounded-md">
    <h1 class="text-2xl font-semibold leading-none">
      {{ sample.name }}
    </h1>
  </div>
  <form
    @submit.prevent="submit"
    method="POST"
    class="grid grid-flow-row grid-cols-2 w-full"
  >
    <div class="col-span-1">
      <DragDrop />
    </div>
    <CardPartial class="col-span-2">
      <template #title>Results</template>
      <template #content>
        <table class="col-span-3 w-full overflow-hidden p-4">
          <thead class="bg-gray-200 text-black border-b max-h-8">
            <tr>
              <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Category
              </th>
              <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Test Parameter
              </th>
              <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Unit</th>
              <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Method
              </th>
              <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                Result
              </th>
            </tr>
          </thead>
          <tbody class="overflow-x-auto">
            <tr
              v-for="(result, rKey) in form.results"
              :key="rKey"
              class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
            >
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.category }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.name }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                <span v-if="!result.unit"> - </span>
                {{ result.unit }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                <select>
                  <!-- <option v-for="(standard, sKey) in result.test_methods">
                    {{ standard.name }}
                  </option> -->
                </select>
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                <input
                  type="text"
                  class="bg-gray-200"
                  v-model="form.results[rKey].value"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </template>
    </CardPartial>

    <div class="col-span-1">
      <input
        class="border-b"
        type="text"
        v-model="form.tested_by"
        placeholder="Tested By"
      />
    </div>

    <div class="col-span-1">
      <SubmitButton />
    </div>
  </form>
</template>

<script>
import CardPartial from "../../../partials/CardPartial.vue";
import DragDrop from "../../../components/DragDrop.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

export default {
  name: "TestSample",
  components: {
    CardPartial,
    DragDrop,
    SubmitButton,
  },
  props: {
    sample: "",
  },
  data() {
    return {
      form: {
        tested_by: "",
        sample_id: this.$route.params.id,
        results: [],
      },
    };
  },
  created() {
    this.form.results = this.sample.results
      .map((result) => {
        let testParameter = this.$store.getters["systemLibrary/testParameters"].find(
          (storeParameter) => storeParameter.id === result.test_parameter_id
        );
        console.log(testParameter.category);

        return Object.assign(result, {
          name: testParameter.name,
          unit: testParameter.unit,
          category: testParameter.category.name,
          categoryId: testParameter.category.id,
        });
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
  methods: {
    submit() {
      this.$store.dispatch("sample/testSample", { formData: this.form });
    },
  },
  computed: {
    lab() {
      return this.$store.getters["lab/labs"].find((lab) => lab.id === this.sample.lab_id);
    },
    instruments() {
      return this.lab.instruments;
    },
  },
};
</script>

<style scoped></style>
