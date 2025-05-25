<template>
  <table class="border-collapse border border-slate-500">
    <thead>
      <tr class="text-left uppercase border bg-gray-200">
        <th v-for="header in headers" class="pl-2 border">
          {{ header }}
        </th>
      </tr>
    </thead>
    <tbody class="border">
      <tr class="border" v-for="(row, rKey) in rows" :key="rKey">
        <td class="pl-2 border">
          {{ getParameter(row.test_parameter_id).name }}
        </td>
        <td class="pl-2 border">
          {{ getParameter(row.test_parameter_id).unit }}
        </td>
        <td class="pl-2 border">
          {{ Math.floor(row.min) }} {{ row.comparator }} {{ Math.floor(row.max) }}
        </td>
        <td class="pl-2 border">
          <div class="flex flex-row justify-between">
            {{ row.value }}
            <div v-show="row.pass !== null" class="pr-2">
              <span v-if="row.pass"> [P] </span>
              <span v-if="!row.pass" class="text-red-500"> [F] </span>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "ComparatorTable",
  props: {
    headers: {
      default: [],
    },
    rows: {
      default: [],
    },
  },
  methods: {
    getParameter(parameterId) {
      return this.$store.getters["systemLibrary/testParameters"].find(
        (testParam) => testParam.id === parameterId
      );
    },
  },
};
</script>
