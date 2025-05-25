<template>
  <div
    class="flex items-center rounded shadow-md overflow-hidden max-w-xl relative bg-white"
  >
    <div class="p-4 flex-1">
      <h3 class="text-xl font-bold">{{ content }}</h3>
      <p class="text-sm">
        {{ type }}
      </p>
      <span class="text-xs text-gray-300 absolute top-4 right-4 z-10">
        {{ timerCount }}
      </span>
    </div>
    <div class="text-blue-500 opacity-70 p-4 mr-4 hover:opacity-100">
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
          d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"
        />
      </svg>
    </div>
    <button
      type="button"
      class="absolute top-3 right-3 z-20 font-semibold text-red-600"
      @click="this.$store.dispatch('system/removeMessage', key)"
    >
      x
    </button>
  </div>
</template>

<script>
export default {
  name: "SnackBar",
  data() {
    return {
      timerCount: 3,
    };
  },
  props: {
    content: "",
    expires: { default: true },
    key: "",
    type: { default: "notice" },
  },
  watch: {
    timerCount: {
      handler(value) {
        if (value > 0) {
          setTimeout(() => {
            this.timerCount--;
          }, 1000);
        }
        if (value === 0) {
          this.$store.dispatch("system/removeMessage", this.$props.key);
        }
      },
      immediate: true,
    },
  },
};
</script>
