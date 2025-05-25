<template>
  <div class="w-full p-4 bg-white shadow-md mb-4 rounded-md">
    <h1 class="text-2xl font-semibold leading-none">
      {{ sample.name }}
    </h1>
  </div>
  <form @submit.prevent="submit" method="POST" class="grid grid-cols-3 w-full">
    <CardPartial class="col-span-3 w-full">
      <template #title> Validate Sample Results </template>
      <template #cta>
        <button
          class="flex flex-row justify-between w-64 p-2 border border-accent text-sm font-medium rounded-md focus:outline-none focus:ring-gray-500 text-gray-500 bg-white hover:bg-accent hover:text-white hover:opacity-70"
          type="button"
          @click="retestSample"
        >
          <div class="w-full uppercase text-center pr-2 mx-1">Retest</div>
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
                d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"
              />
            </svg>
          </div>
        </button>
      </template>

      <template #content>
        <table class="w-full overflow-hidden">
          <thead class="bg-white border-b">
            <tr>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Test Parameter
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Unit
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Min
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Max
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Comparator
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Result
              </th>
              <th
                scope="col"
                class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
              >
                Pass
              </th>
            </tr>
          </thead>
          <tbody class="overflow-x-auto">
            <tr
              v-for="(result, rKey) in results"
              :key="rKey"
              class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
            >
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ getParameter(result.test_parameter_id).name }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ getParameter(result.test_parameter_id).unit }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.min }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.max }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.comparator }}
              </td>
              <td class="p-4 text-sm font-medium text-gray-900">
                {{ result.value }}
              </td>
              <td
                class="p-4 text-sm font-medium text-gray-900"
                :class="getPassFail(result) ? '' : 'text-red-400'"
              >
                {{ getPassFail(result) }}
              </td>
            </tr>
          </tbody>
        </table>
      </template>
    </CardPartial>

    <CardPartial class="col-span-1 w-full">
      <template #title>Release Sample </template>

      <template #content>
        <input
          v-model="form.released_by"
          placeholder="Released By"
          class="relative block w-full p-4 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm mb-4"
        />
        <input
          v-model="form.conformity"
          placeholder="Release Message"
          class="relative block w-full p-4 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm mb-4"
        />
      </template>
      <template #action-button>
        <SubmitButton title="Approve Results" />
      </template>
    </CardPartial>
  </form>
</template>

<script>
import CardPartial from "../../../partials/CardPartial.vue";
import Slider from "../../../components/Slider.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

export default {
  name: "ValidateSample",
  components: { CardPartial, Slider, SubmitButton },
  data() {
    return {
      approveAllState: false,
      form: {
        sample_id: this.$route.params.id,
        released_by: "",
        conformity: "",
        results: [],
      },
    };
  },
  props: {
    sample: "",
  },
  created() {
    this.form.released_by = this.sample.released_by;
  },
  methods: {
    submit() {
      this.form.results = this.results;
      this.$store.dispatch("sample/validateSample", { formData: this.form });
    },
    getParameter(parameterId) {
      return this.$store.getters["systemLibrary/testParameters"].find(
        (testParam) => testParam.id === parameterId
      );
    },
    getPassFail(result) {
      let resultValue = parseFloat(result.value);
      if (isNaN(resultValue)) {
        return "-";
      }
      if (result.min === null && result.max === null) {
        result.pass = null;
        return result.pass;
      }
      let passed = this.compare(result.comparator, result.min, result.max, resultValue);
      result.pass = passed;

      return result.pass;
    },
    compare(comparator, min, max, result) {
      min = parseFloat(min);
      max = parseFloat(max);

      switch (comparator) {
        case "><":
          return result > min && result < max;
          break;
        case "<>":
          return min > result && max < result;
          break;
        case ">=":
          return min >= result;
          break;
        case "<=":
          return result <= max;
          break;
        case "!=":
          return min !== result || max !== result;
          break;
        case "=":
          return min === result || max === result;
          break;
        default:
          console.log(comparator, min, max, result);
          break;
      }
    },
    retestSample() {
      return (this.sample.status -= 1);
    },
    toggleAllResultsApproval() {
      this.approveAllState = !this.approveAllState;
    },
  },
  computed: {
    results() {
      return this.sample.results
        .map((result) => {
          return Object.assign(result, { pass: "" });
        })
        .sort(function (a, b) {
          return a.name > b.name ? 1 : -1;
        });
    },
  },
};
</script>

<style scoped></style>
