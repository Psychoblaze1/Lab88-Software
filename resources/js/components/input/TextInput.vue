<template>
  <label class="font-semibold align-middle">{{ label }} </label>
  <input
    :placeholder="placeholder"
    class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
  />
</template>
<script>
export default {
  name: "TextInput",
  props: {
    label: { default: "" },
    placeholder: { default: "" },
  },
};
// TODO: $emits input.value
</script>
