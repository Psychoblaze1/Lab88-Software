<template>
  <table class="w-full h-full text-xs">
    <thead class="bg-gray-200 text-black sticky top-0">
      <tr class="text-left">
        <th v-if="headers.length > 0" v-for="header in headers" class="p-2">
          {{ header.label }}
        </th>
      </tr>
    </thead>
    <tbody class="overflow-y-auto">
      <tr v-if="rows.length > 0" v-for="(row, key) in rows">
        <td v-for="(column, key) in row">{{ column }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
// TODO: assign column properties by matching it to header key field
export default {
  name: "DynamicTable",
  setup() {
    const headers = [
      { key: "sample_id", label: "Sample Id" },
      { key: "type", label: "Type" },
      { key: "asset_chain", label: "Asset Chain" },
      { key: "status", label: "Status" },
      { key: "action", label: "Actions" },
    ];
    // Example so far
    // return { headers };
  },
  props: {
    headers: { default: [] },
    rows: { default: [] },
  },
  data() {
    return {
      columnOptionsToggle: false,
      filter: {
        searchField: "",
        asset: "",
        type: "",
        status: "",
      },
    };
  },
};
</script>
