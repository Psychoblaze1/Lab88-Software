<template>
  <div class="flex justify-center space-x-1">
    <button
      title="previous"
      type="button"
      class="inline-flex items-center justify-center w-8 h-8 py-0 border rounded-md shadow-md"
    >
      <svg
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="w-4"
      >
        <polyline points="15 18 9 12 15 6"></polyline>
      </svg>
    </button>
    <button
      type="button"
      title="Page 1"
      class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold border rounded shadow-md"
    >
      1
    </button>
    <button
      type="button"
      class="inline-flex items-center justify-center w-8 h-8 text-sm border rounded shadow-md"
      title="Page 2"
    >
      2
    </button>
    <button
      type="button"
      class="inline-flex items-center justify-center w-8 h-8 text-sm border rounded shadow-md"
      title="Page 3"
    >
      3
    </button>
    <button
      type="button"
      class="inline-flex items-center justify-center w-8 h-8 text-sm border rounded shadow-md"
      title="Page 4"
    >
      4
    </button>
    <button
      title="next"
      type="button"
      class="inline-flex items-center justify-center w-8 h-8 py-0 border rounded-md shadow-md"
    >
      <svg
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
        fill="none"
        stroke-linecap="round"
        stroke-linejoin="round"
        class="w-4"
      >
        <polyline points="9 18 15 12 9 6"></polyline>
      </svg>
    </button>
  </div>
</template>
<script>
export default {
  name: "Paginate",
  props: {
    itemCount: "",
    itemsPerPage: "",
  },
  data() {
    return {
      paginate: {
        current_page: 1,
        total_pages: 1,
        show_items: 1,
      },
    };
  },
  methods: {},
};
</script>
