<template>
  <div
    class="flex justify-center col-span-full md:col-span-1 md:flex-col md:justify-start md:items-start uppercase"
  >
    <div
      v-for="(step, key) in steps"
      :key="key"
      class="px-2 py-1 border-b-2 md:border-l-2 md:border-b-0 md:py-3"
      :class="step.active ? activeCLass : completedClass"
    >
      {{ step.label }}
    </div>
  </div>
</template>

<script>
export default {
  name: "Stepper",
  props: {
    currentStatus: { default: 0 },
    steps: { default: [] },
  },
  created() {},
  computed: {
    activeCLass() {
      return "px-2 py-1 border-b-2 md:border-l-2 md:border-b-0 md:py-3 border-blue-500 text-black";
    },
    completedClass() {
      return "px-2 py-1 border-b-2 md:border-l-2 md:border-b-0 md:py-3 text-red-500";
    },
  },
};
</script>

<style></style>
