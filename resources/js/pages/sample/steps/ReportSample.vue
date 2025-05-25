<template>
  <div
    class="w-full flex flex-row justify-between p-4 bg-white shadow-md mb-4 rounded-md"
  >
    <h1 class="text-2xl font-semibold leading-none">
      {{ sample.name }}
    </h1>

    <button
      @click="createPDF"
      type="button"
      class="flex flex-row justify-between w-64 p-2 border border-accent text-sm font-medium rounded-md focus:outline-none focus:ring-gray-500 text-gray-500 bg-white hover:bg-accent hover:text-white hover:opacity-70"
    >
      <div class="w-full uppercase text-center">
        <span class="pr-2 mx-1">SAVE PDF</span>
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
            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
          />
        </svg>
      </div>
    </button>
  </div>
  <!--  -->
  <!-- Report -->
  <div class="bg-white p-4 w-full flex flex-col space-y-2 page" ref="pdf">
    <!-- Header -->
    <div class="w-full grid grid-cols-5 border-b pb-2">
      <div class="col-span-1 w-full">
        <div class="flex flex-row justify-start">
          <img src="/images/lab_88.png" class="h-8 w-auto" alt="Logo" />
        </div>
      </div>
      <div class="col-span-2 w-full">
        <div class="w-full flex flex-row justify-end text-end">
          <h1 class="text-2xl">Asset Chain</h1>
          <!-- <h2 class="text-xl capitalize">{{ sample.type }}: Fuel Analysis</h2> -->
        </div>
      </div>
      <div class="col-span-2 w-full">
        <div class="w-full flex flex-row justify-end text-end">
          <h1 class="text-2xl">{{ sample.name }}</h1>
          <!-- <h2 class="text-xl capitalize">{{ sample.type }}: Fuel Analysis</h2> -->
        </div>
      </div>
    </div>
    <!--/Header-->

    <!-- Conformity -->
    <div class="grid grid-cols-5 w-full p-2 text-center mb-2">
      <div class="col-span-1">
        <!-- Dates -->
        <!-- <ul class="text-xs">
          <li>
            Drawn By: {{ sample.drawn_by }} &nbsp; {{ formatDateTime(sample.drawn_at) }}
          </li>
          <li>
            Received By: {{ sample.received_by }} &nbsp;
            {{ formatDateTime(sample.received_at) }}
          </li>
          <li>
            Tested By: {{ sample.tested_by }} &nbsp;
            {{ formatDateTime(sample.tested_at) }}
          </li>
          <li>
            Released By: {{ sample.released_by }} &nbsp;
            {{ formatDateTime(sample.released_at) }}
          </li>
        </ul> -->
        <!-- //Dates -->
      </div>
      <div class="col-span-2 w-full text-center">{{ sample.conformity }}</div>
      <div class="col-span-1 w-full flex flex-col">
        <div
          v-show="sample.pass !== null"
          class="w-full text-white text-center rounded-sm"
          :class="sample.pass ? 'bg-green-500' : 'bg-red-500'"
        >
          <span v-if="sample.pass"> PASS</span>
          <span v-if="!sample.pass">FAIL </span>
        </div>
        <div></div>
      </div>
    </div>
    <!-- /Conformity -->

    <!-- Body -->
    <ComparatorTable
      :headers="['parameter', 'unit', 'limit', 'result']"
      :rows="results"
    />

    <!-- <BarChart /> -->
    <!-- /Body -->
  </div>
  <!-- //Report -->

  <CardPartial class="col-span-1 w-full mt-4">
    <template #title> Sample Report</template>

    <template #content>
      <div class="px-5 pb-5">List of report types, also option to send by email</div>
    </template>
    <template #action-button>
      <SubmitButton />
    </template>
  </CardPartial>
</template>

<script>
import moment from "moment";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";

import CardPartial from "../../../partials/CardPartial.vue";
import ReportPartial from "../../../partials/ReportPartial.vue";
import ComparatorTable from "../../../components/ComparatorTable.vue";
import SubmitButton from "../../../components/SubmitButton.vue";
import BarChart from "../../../components/chart/BarChart.vue";

export default {
  name: "ReportSample",
  components: { BarChart, CardPartial, ReportPartial, ComparatorTable, SubmitButton },
  data() {
    return {};
  },
  props: {
    sample: "",
  },
  methods: {
    async createPDF() {
      const canvas = await html2canvas(this.$refs.pdf, { scale: 3 });
      const pdf = new jsPDF("p", "mm", "a4");
      pdf.addImage(canvas.toDataURL("image/png"), "PNG", 0, 0, 210, 297);
      pdf.save(this.sample.name + ".pdf");
    },
    getParameter(parameterId) {
      return this.$store.getters["systemLibrary/testParameters"].find(
        (testParam) => testParam.id === parameterId
      );
    },
    formatDateTime(dateStr) {
      if (!dateStr.length) {
        return "";
      }
      return moment(dateStr).format("YYYY-MM-DD");
    },
  },
  computed: {
    results() {
      return this.$props.sample.results;
    },
  },
};
</script>

<style scoped>
.page {
  height: 297mm;
  page-break-inside: avoid;
  background: #fff;
}
.pdf-component {
  page-break-after: always;
}

.body {
  page-break-inside: avoid;
}
</style>
