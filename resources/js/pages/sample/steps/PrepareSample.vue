<template>
  <div class="w-full p-4 bg-white shadow-md mb-4 rounded-md">
    <h1 class="text-2xl font-semibold leading-none">
      {{ sample.name }}
    </h1>
  </div>
  <form @submit.prevent="submit" method="POST" class="grid grid-cols-3 w-full space-x-4">
    <div class="col-span-1 w-full mr-4">
      <CardPartial class="w-full">
        <template #title>Prepare Sample</template>

        <!-- TODO: Standards/Suites/ neither -->

        <template #content>
          <div class="w-full flex flex-col p-2">
            <label class="font-semibold align-middle">Limit Suite:</label>
            <select
              v-model="form.limit_suite_id"
              @change="setLimitParams"
              class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
            >
              <option value="" disabled>Select Limit Suite</option>
              <option
                v-for="(suite, lskey) in limitSuites"
                :key="lskey"
                :value="suite.id"
              >
                <span class="capitalize"> {{ suite.name }}</span>
              </option>
            </select>
          </div>
        </template>
      </CardPartial>
      <!--  -->
      <CardPartial class="w-full mr-4">
        <template #title>Additional Parameters </template>

        <template #content>
          <div class="w-full">
            <div class="w-full flex flex-col p-2">
              <label class="font-semibold align-middle">Categories:</label>
              <select
                v-model="category_id"
                class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
              >
                <option value="">Select Parameter Category</option>
                <option
                  v-for="(category, cKey) in categories"
                  :key="cKey"
                  :value="category.id"
                  class="capitalize"
                >
                  <span class="capitalize"> {{ category.name }}</span>
                </option>
              </select>
            </div>

            <div class="w-full flex flex-col p-2">
              <table v-show="category_id !== ''" class="min-w-full text-xs">
                <thead class="bg-white border-b">
                  <tr class="text-left">
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                      <input
                        type="checkbox"
                        v-model="SelectAllParametersState"
                        @click="toggleSelectAllParameters"
                      />
                      Select All
                    </th>
                    <th
                      scope="col"
                      class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                    >
                      Parameter Name
                    </th>
                  </tr>
                </thead>
                <tbody class="h-auto overflow-y-auto">
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
              <button
                @click="addSelectedParams"
                type="button"
                class="flex flex-row justify-between w-64 p-2 border border-accent text-sm font-medium rounded-md focus:outline-none focus:ring-gray-500 text-gray-500 bg-white hover:bg-accent hover:text-white hover:opacity-70"
              >
                <div class="w-full uppercase text-center">
                  <span class="pr-2 mx-1">Add</span>
                </div>
                <!--  -->
                <div class="border-l pl-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15"
                    />
                  </svg>
                </div>
              </button>
            </div>
          </div>
        </template>
      </CardPartial>
    </div>
    <!--  -->
    <div class="col-span-2 w-full mr-4">
      <!-- New Test Suite -->
      <CardPartial v-show="isNewTestSuite">
        <template #title> Save as new limit suite? </template>
        <template #content>
          <div class="w-full flex flex-col p-2">
            <label class="font-semibold align-middle">New Limit Suite Name:</label>
            <input
              v-model="form.new_suite_name"
              type="text"
              class="w-full text-black border-b-2 placeholder-gray-800 px-4 py-2.5 mt-2 text-base"
            />
          </div>
        </template>
      </CardPartial>
      <!-- Params -->
      <CardPartial class="pr-4">
        <template #title>Parameters To Test</template>
        <template #cta
          ><button @click.prevent="clearAllParametersToTest">Clear All</button></template
        >
        <template #content>
          <table class="min-w-full text-xs">
            <thead class="bg-gray-200 text-black border-b p-2">
              <tr class="text-left">
                <th class="p-2 capitalize">Category</th>
                <th class="p-2 capitalize">Parameter</th>
                <th class="p-2 capitalize">Unit</th>
                <th class="p-2 capitalize">Comparator</th>
                <th class="p-2 capitalize">Min</th>
                <th class="p-2 capitalize">Max</th>
                <th class="p-2 capitalize">Actions</th>
              </tr>
            </thead>
            <tbody class="overflow-x-auto">
              <tr
                v-for="(parameter, pArrKey) in formParameters"
                :key="pArrKey"
                class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
              >
                <td class="p-2 capitalize">{{ parameter.category.name }}</td>
                <td class="p-2">{{ parameter.name }}</td>
                <td class="p-2">{{ parameter.unit }}</td>
                <!--  -->
                <td class="p-2">
                  <!-- TODO: CHANGE THE FLOW OF THIS TO SELECT COMPARATOR FIRST THEN SHOW MIN/MAX INPUTS -->
                  <select v-model="formParameters[pArrKey].comparator">
                    <option
                      v-for="comparator in comparators"
                      :value="comparator.value"
                      :title="comparator.name"
                    >
                      {{ comparator.value }}
                    </option>
                  </select>
                </td>
                <!--  -->
                <td class="p-2">
                  <input
                    v-show="inputIsVisible(parameter.comparator).showMin"
                    type="number"
                    class="border-b"
                    v-model="parameter.min"
                  />
                </td>

                <td class="p-2">
                  <input
                    v-show="inputIsVisible(parameter.comparator).showMax"
                    type="number"
                    class="border-b"
                    v-model="parameter.max"
                  />
                  <!-- TODO: make sure that max is > min -->
                </td>

                <td class="p-2">
                  <button
                    type="button"
                    @click.prevent="removeFromTestableParameters(pArrKey)"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </button>
                  <!-- TODO: fix the delete -->
                </td>
              </tr>
            </tbody>
          </table>
        </template>
        <template #action-button>
          <SubmitButton :disabled="!form.parameters_to_test.length" />
        </template>
      </CardPartial>
    </div>
  </form>
</template>

<script>
import CardPartial from "../../../partials/CardPartial.vue";
import SubmitButton from "../../../components/SubmitButton.vue";
import Slider from "../../../components/Slider.vue";

import ToolTip from "../../../components/notification/ToolTip.vue";

export default {
  name: "PrepareSample",
  components: { CardPartial, Slider, SubmitButton, ToolTip },
  data() {
    return {
      isNewTestSuite: false,
      additionalTestParamId: "",
      category_id: "",
      SelectAllParametersState: false,
      form: {
        sample_id: this.$route.params.id,
        parameters_to_test: [],
        limit_suite_id: "",
        new_suite_name: "",
      },
    };
  },
  props: {
    sample: "",
  },
  created() {
    if (!this.$store.getters["limitTesting/limitSuites"].length) {
      this.$store.dispatch("limitTesting/getLimitSuites");
    }
    if (!this.$store.getters["systemLibrary/testParameters"].length) {
      this.$store.dispatch("systemLibrary/getTestParameters");
    }
    if (!this.$store.getters["systemLibrary/testParameterCategories"].length) {
      this.$store.dispatch("systemLibrary/getTestParameterCategories");
    }
  },
  methods: {
    submit() {
      if (this.form.new_suite_name !== "") {
        // todo: improve this
        this.$store.dispatch("limitTesting/flushAll");
        this.$store.dispatch("limitTesting/getLimitSuites");
      }

      return this.$store.dispatch("sample/prepareSample", { formData: this.form });
    },
    addToTestParams(parameter) {
      // check if already in test params
      if (
        this.form.parameters_to_test.find((parameterToTest) => {
          parameterToTest.id === parameter.id;
        })
      ) {
        // Check the min/max/comparator values, then push
        console.log(parameterToTest, parameter);
      }

      this.form.parameters_to_test.push(parameter);
      this.checkIfNewLimitSuite();
    },
    addSelectedParams() {
      this.categoryParams.filter((param) => {
        if (param.checked) {
          this.addToTestParams(param);
          param.checked = false;
        }
      });
      this.category_id = "";
    },
    clearAllParametersToTest() {
      this.form.limit_suite_id = "";
      this.form.parameters_to_test = [];
      this.isNewTestSuite = false;
      this.form.new_suite_name = "";
    },
    removeFromTestableParameters(key) {
      this.form.parameters_to_test.splice(key, 1);
      this.checkIfNewLimitSuite();
    },
    setLimitParams() {
      // Confirm Clear table
      if (this.form.new_suite_name !== "") {
        if (confirm("Changing this will clear the table")) {
          this.setTestSuiteParameters(this.form.limit_suite_id);
          this.form.new_suite_name = "";
        } else {
          // reset the input to previous id
          this.form.limit_suite_id = "";
        }
      } else {
        this.setTestSuiteParameters(this.form.limit_suite_id);
      }
    },
    setTestSuiteParameters(limitSuiteId) {
      // Clear table
      this.form.parameters_to_test = [];
      // Get Selected Suite
      let selectedSuite = this.limitSuites.find((suite) => suite.id === limitSuiteId);

      selectedSuite.limit_parameters.forEach((limit) => {
        let param = this.getParameterFromStore(limit.test_parameter_id);
        limit.category = { name: param.category.name, id: param.category.id };
        limit.name = param.name;
        limit.unit = param.unit;
        this.form.parameters_to_test.push(limit);
      });
    },
    getParameterFromStore(parameter_id) {
      return this.testParameters.find((parameter) => parameter.id === parameter_id);
    },
    toggleSelectAllParameters() {
      this.SelectAllParametersState = !this.SelectAllParametersState;
      this.categoryParams.filter((cParam) => {
        cParam.checked = this.SelectAllParametersState;
      });
    },
    inputIsVisible(comparator) {
      switch (comparator) {
        case "=":
          return { showMin: true, showMax: false };
          break;
        case "!=":
          return { showMin: true, showMax: false };
          break;
        case ">=":
          return { showMin: true, showMax: false };
          break;
        case "<=":
          return { showMin: false, showMax: true };
          break;
        case "<>":
          return { showMin: true, showMax: true };
          break;
        case "><":
          return { showMin: true, showMax: true };
          break;
        default:
          return { showMin: false, showMax: false };
          break;
      }
    },

    checkIfNewLimitSuite() {
      // check that limit suite is set && testable params is set
      if (this.form.limit_suite_id !== "" && this.form.parameters_to_test.length > 0) {
        // get limit params
        let limitParams = this.$store.getters["limitTesting/limitSuites"].find(
          (limitSuite) => limitSuite.id === this.form.limit_suite_id
        ).limit_parameters;
        //
        // compare lengths
        if (limitParams.length !== this.form.parameters_to_test.length) {
          this.isNewTestSuite = true;
          console.log("length !==");
        }
        // compare params && limit values
      }
      if (this.form.limit_suite_id === "" && this.form.parameters_to_test.length > 0) {
        this.isNewTestSuite = true;
      }
    },
  },
  computed: {
    limitSuites() {
      return this.$store.getters["limitTesting/limitSuites"];
    },
    testParameters() {
      return this.$store.getters["systemLibrary/testParameters"];
    },
    formParameters() {
      return this.form.parameters_to_test.sort(function (a, b) {
        // same category, sort by Parameter Name
        if (a.category === b.category) {
          return a.name > b.name ? 1 : -1;
        }
        // return category sort
        return a.category > b.category ? 1 : -1;
      });
    },
    categories() {
      return this.$store.getters["systemLibrary/testParameterCategories"].sort(function (
        a,
        b
      ) {
        return a.name > b.name ? 1 : -1;
      });
    },
    categoryParams() {
      if (this.category_id === "") {
        return [];
      }
      return this.testParameters
        .filter((param) => {
          if (param.category.id === this.category_id) {
            return Object.assign(param, {
              checked: false,
              category: { name: param.category.name, id: param.category.id },
              min: "",
              max: "",
              comparator: "",
              test_parameter_id: param.id,
            });
          }
        })
        .sort(function (a, b) {
          return a.name > b.name ? 1 : -1;
        });
    },
    limitParameters() {
      if (!this.form.limit_suite_id) {
        return [];
      }

      let limitSuite = this.$store.getters["limitTesting/limitSuites"].find(
        (limitSuite) => limitSuite.id === this.form.limit_suite_id
      );

      return limitSuite.limit_parameters.map((param) => {
        return Object.assign(param, {
          checked: false,
          min: param.min,
          max: param.max,
          comparator: "",
        });
      });
    },
    comparators() {
      return [
        { name: "None", value: "" },
        { name: "Equal to", value: "=" },
        { name: "Does Not Equal", value: "!=" },
        { name: "Greater than or Equal to", value: ">=" },
        { name: "Less than or Equal to", value: "<=" },
        { name: "Between Range", value: "><" },
        { name: "Outside Range", value: "<>" },
      ];
    },
  },
};
</script>

<style scoped></style>
