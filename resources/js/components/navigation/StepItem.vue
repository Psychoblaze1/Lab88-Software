<template>
  <!-- TODO: refactor when You are done to make this neater -->
  <!-- COMPLETE -->
  <div class="flex justify-between text-gray-300" v-show="stepProgress === 'complete'">
    <span>
      {{ title }}
    </span>
    <span class="pl-2 border-l">
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
          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
    </span>
  </div>
  <!-- PENDING -->
  <div class="flex justify-between text-gray-500" v-show="stepProgress === 'pending'">
    <span>
      {{ title }}
    </span>
    <span class="pl-2 border-l">
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
          d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
    </span>
  </div>
  <!-- CURRENT -->
  <div class="flex justify-between text-blue-500" v-show="stepProgress === 'current'">
    <span>
      {{ title }}
    </span>
    <span class="pl-2 border-l">
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
          d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
    </span>
  </div>
</template>

<script>
export default {
  name: "StepItem",
  props: {
    title: "",
    stepProgress: { default: "pending" },
    currentStatus: { default: 0 },
  },
  methods: {
    getStepProgress(stepKey) {
      let currentStatus = this.$props.currentStatus;
      if (currentStatus === stepKey) {
        return "current";
      } else if (stepKey < currentStatus) {
        return "complete";
      } else if (stepKey > currentStatus) {
        return "pending";
      }
    },
  },
};
</script>

<style></style>
