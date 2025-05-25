<template>
  <label class="font-semibold align-middle">{{ label }} </label>
  <select
    :placeholder="placeholder"
    class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
  >
    <option v-for="option in options" :value="option.value">{{ option.label }}</option>
  </select>
</template>
<script>
export default {
  name: "SelectInput",
  props: {
    label: { default: "" },
    placeholder: { default: "" },
    options: { default: [{ option: { value: null, label: null } }] },
  },
  methods() {},
};
</script>
