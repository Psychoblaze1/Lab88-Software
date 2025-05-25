<template>
  <div class="p-2 border rounded-md uppercase w-full mt-2">
    <div class="flex justify-start text-blue-500">
      <span class="pr-2">
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
      <span class="border-l pl-2 border-blue-500 font-semibold">
        {{ title }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "NavLink",
  props: {
    title: "",
  },
  methods: {},
};
</script>

<style></style>
