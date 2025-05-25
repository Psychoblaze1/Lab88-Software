<template>
  <!-- SIDEBAR -->
  <aside class="hidden sm:block w-64 overflow-y-auto border-r">
    <div class="m-auto bg-white rounded-sm p-2 h-full">
      <div
        v-for="(step, stepKey) in steps"
        :key="stepKey"
        class="p-2 border rounded-md uppercase w-full mt-2"
      >
        <StepItem
          :title="step"
          :stepProgress="stepProgress(stepKey)"
          :currentStatus="sample.status"
        />
      </div>
      <!-- FOR DEV PURPOSES ONLY -->
      <!-- <div class="absolute bottom-10 left-10 p-2">
        <button @click="sample.status -= 1" class="p-2 bg-white">-</button>
        <button @click="sample.status += 1" class="p-2 bg-white">+</button>
        {{ sample.status }}
        <button @click="flush">FLUSH</button>
      </div> -->
      <!-- //FOR DEV PURPOSES ONLY -->
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="bg-gray-100 overflow-y-auto p-4 w-full">
    <component :is="currentComponent" :sample="sample" />
  </main>
</template>

<script>
import StepItem from "../../components/navigation/StepItem.vue";
// Steps
import PrepareSample from "./steps/PrepareSample.vue";
import ReceiveSample from "./steps/ReceiveSample.vue";
import RegisterSample from "./steps/RegisterSample.vue";
import ReportSample from "./steps/ReportSample.vue";
import TestSample from "./steps/TestSample.vue";
import ValidateSample from "./steps/ValidateSample.vue";

export default {
  name: "SampleStepper",
  components: {
    StepItem,
    // STEPS
    PrepareSample,
    ReceiveSample,
    RegisterSample,
    ReportSample,
    TestSample,
    ValidateSample,
  },
  data() {
    return {};
  },

  methods: {
    // dev
    flush() {
      this.$store.dispatch("account/flushAll");
      this.$store.dispatch("limitTesting/flushAll");
      this.$store.dispatch("sample/flushAll");
      this.$store.dispatch("testParameters/flushAll");
    },
    // dev
    stepProgress(stepKey) {
      let currentStatus = 0;
      //lazy fix
      if (this.sample.status > 0) {
        currentStatus = this.sample.status;
      }
      if (currentStatus === stepKey) {
        return "current";
      } else if (stepKey < currentStatus) {
        return "complete";
      } else if (stepKey > currentStatus) {
        return "pending";
      }
    },
  },
  computed: {
    currentComponent: function () {
      switch (this.sample.status) {
        case 1:
          return ReceiveSample;
          break;
        case 2:
          return PrepareSample;
          break;
        case 3:
          return TestSample;
          break;
        case 4:
          return ValidateSample;
          break;
        case 5:
          return ReportSample;
          break;
        // Register as Default -> case 0:
        default:
          return RegisterSample;
          break;
      }
    },
    steps() {
      return this.$store.getters["sample/statuses"];
    },
    sample() {
      let sample = this.$store.getters["sample/samples"].find(
        (sample) => sample.id === this.$route.params.id
      );
      if (sample === undefined) {
        return { sample: { status: 0 } };
      }
      return sample;
    },
  },
};
</script>

<style scoped></style>
