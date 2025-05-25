<template>
  <button
    @click="working = true"
    :type="type"
    class="flex flex-row justify-between w-64 p-2 border border-accent text-sm font-medium rounded-md focus:outline-none focus:ring-gray-500"
    :disabled="disabled"
    :class="
      working
        ? 'bg-blue-500 animate-pulse text-white'
        : 'text-gray-500 bg-white hover:bg-accent hover:text-white hover:opacity-70'
    "
  >
    <div class="w-full uppercase text-center">
      <span v-if="!working" class="pr-2 mx-1">{{ title }}</span>
      <span v-else class="pr-2 mx-1">Working</span>
    </div>
    <!--  -->
    <div class="border-l pl-2">
      <!-- <svg
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
      </svg> -->
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
          d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"
        />
      </svg>
    </div>
  </button>
</template>
<script>
export default {
  name: "SubmitButton",
  props: {
    disabled: { default: false },
    title: { default: "Submit" },
    type: { default: "submit" },
  },
  data() {
    return {
      working: false,
    };
  },
};
</script>
