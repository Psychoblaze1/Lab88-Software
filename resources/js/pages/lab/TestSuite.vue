<template>
  <div class="w-full p-4">
    <form
      @submit.prevent="submit"
      method="POST"
      class="grid grid-cols-3 w-full space-x-4"
    >
      <div class="col-span-1 w-full space-y-4">
        <CardPartial class="w-full">
          <template #title>Prepare Sample</template>
          <template #content>
            <div class="w-full flex flex-col p-2">
              <label class="font-semibold align-middle">Limit Suite</label>
              <input
                type="text"
                v-model="form.limit_suite.name"
                class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
              />
            </div>
          </template>
        </CardPartial>
        <CardPartial class="w-full">
          <template #title>Parameters</template>
          <template #content>
            <div class="w-full flex flex-col p-2">
              <label class="font-semibold align-middle">Categories:</label>
              <select
                @change="addToAdditionalParamsArr"
                v-model="param_category_id"
                class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
              >
                <option value="" disabled>Select Parameter Category</option>
                <option
                  v-for="(parameter, tpKey) in testParameters"
                  :key="tpKey"
                  :value="parameter.id"
                >
                  {{ parameter.name }}
                </option>
              </select>
            </div>

            <div class="w-full flex flex-col p-2">
              <table class="min-w-full text-xs">
                <thead class="bg-white border-b">
                  <tr class="text-left">
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                      Select
                    </th>
                    <th
                      scope="col"
                      class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                    >
                      Test Parameter
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(param, key) in categoryParams"
                    class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
                  >
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                    >
                      <input
                        @click="param.checked = !param.checked"
                        type="checkbox"
                        :checked="param.checked"
                      />
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                    >
                      {{ param.name }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <button @click="getSelectedAndAdd" class="w-full p-4 border rounded-md">
                Add Param/s
              </button>
            </div>
          </template>
        </CardPartial>
      </div>
      <!--  -->
      <div class="col-span-2 w-full">
        <!-- Params -->
        <CardPartial>
          <template #title>Limit Suite Parameters</template>
          <template #content>
            <table class="min-w-full text-xs">
              <thead class="bg-gray-200 text-black border-b p-2">
                <tr class="text-left">
                  <th class="p-2">Parameter</th>
                  <th class="p-2">Unit</th>
                  <th class="p-2">Min</th>
                  <th class="p-2">Max</th>
                  <th class="p-2">comparator</th>
                  <th class="p-2">Actions</th>
                </tr>
              </thead>
              <tbody class="overflow-x-auto">
                <tr
                  v-for="(parameter, pArrKey) in newParameters"
                  :key="pArrKey"
                  class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
                >
                  <td class="p-2">{{ parameter.name }}</td>
                  <td class="p-2">{{ parameter.unit }}</td>
                  <td class="p-2"><input :value="parameter.min" /></td>
                  <td class="p-2"><input :value="parameter.max" /></td>
                  <td class="p-2"><input :value="parameter.comparator" /></td>
                  <td class="p-2">
                    <button @click="form.testParams.splice(pArrKey, 1)">remove</button>
                    <!-- TODO: fix the delete -->
                  </td>
                </tr>
              </tbody>
            </table>
          </template>
          <template #action-button>
            <SubmitButton />
          </template>
        </CardPartial>
      </div>
    </form>
  </div>
</template>

<script>
import CardPartial from "../../partials/CardPartial.vue";
import SubmitButton from "../../components/SubmitButton.vue";

export default {
  name: "TestSuite",
  data() {
    return {
      additonal_test_param_id: "",
      param_category_id: "",
      form: {
        limit_suite: {
          id: "",
          temp_id: "",
          name: "",
        },
        testParams: [],
      },
    };
  },
  components: {
    CardPartial,
    SubmitButton,
  },
  created() {
    if (!this.$store.getters["limitTesting/limitSuites"].length) {
      this.$store.dispatch("limitTesting/getLimitSuites");
    }
    if (!this.$store.getters["systemLibrary/testParameters"].length) {
      this.$store.dispatch("systemLibrary/getTestParameters");
    }
  },
  methods: {
    addToTestParams(parameter) {
      // TODO: check if already in test params
      this.form.testParams.push(parameter);
      // this.additonal_test_param_id = "";
    },
    getSelectedAndAdd() {
      this.categoryParams.forEach((param) => {
        if (param.checked) {
          this.addToTestParams(param);
          param.checked = false;
          console.log(param);
        }
      });
      this.param_category_id = "";
    },
    setLimitParams() {
      // Get Selected Suite
      let selectedSuite = this.limitSuites.find(
        (suite) => suite.id === this.form.limit_suite.temp_id
      );
      selectedSuite.limit_parameters.forEach((limit) => {
        let param = this.getParameterFromStore(limit.test_parameter_id);
        limit.name = param.name;
        limit.unit = param.unit;
        this.form.testParams.push(limit);
      });
    },
    getParameterFromStore(parameter_id) {
      return this.testParameters.find((parameter) => parameter.id === parameter_id);
    },
  },
  computed: {
    limitSuites() {
      return this.$store.getters["limitTesting/limitSuites"];
    },
    testParameters() {
      return this.$store.getters["systemLibrary/testParameters"];
    },
    newParameters() {
      return this.form.testParams;
    },
    categoryParams() {
      if (!this.param_category_id.length) {
        return [];
      }
      let category = this.$store.getters["systemLibrary/testParameters"].find(
        (category) => category.id === this.param_category_id
      );
      return category.test_parameters.map((param) => {
        return Object.assign(param, {
          checked: false,
          min: "",
          max: "",
          comparator: "",
        });
      });
    },
    limitParameters() {
      if (!this.form.limit_suite.id.length) {
        return [];
      }

      let limitSuite = this.$store.getters["limitTesting/limitSuites"].find(
        (limitSuite) => limitSuite.id === this.form.limit_suite.id
      );

      return limitSuite.limit_parameters.map((param) => {
        return Object.assign(param, {
          checked: false,
          min: param.min,
          max: param.max,
          comparator: param.comparator,
        });
      });
    },
  },
};

// TODO: parameters to test table is automatically populated with selected limit params.
// TODO: if param is removed or new test param added, then the suite needs to be saved as new limit suite

// TODO: option to adjust the parameter needs to be reviewed
</script>

<style scoped></style>
