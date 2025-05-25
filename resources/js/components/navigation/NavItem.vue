<template>
  <li class="w-full mb-2">
    <router-link
      :to="{ name: toName }"
      class="flex flex-row w-full justify-between text-gray-900 hover:text-blue-500 hover:underline p-2 border rounded-md uppercase"
    >
      <span>{{ title }}</span>
      <div class="border-l pl-2">
        <slot name="icon"> </slot>
      </div>
    </router-link>
  </li>
</template>

<script>
export default {
  name: "NavItem",
  props: {
    toName: "",
    title: "",
  },
  methods: {},
};
</script>

<style></style>
