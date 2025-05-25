<template>
  <li class="border-l-2 w-full p-2 ml-${indent}" :class="visible ? 'border-accent' : ''">
    <button
      class="flex justify-between w-full"
      :class="visible ? 'text-accent' : 'text-gray-600'"
      type="button"
      @click="visible = !visible"
    >
      <router-link :to="'/assets/' + node.id">
        {{ node.name }}
      </router-link>
      <div v-if="node.children">
        <svg
          v-if="!visible"
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
            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
          />
        </svg>

        <svg
          v-if="visible"
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
            d="M4.5 15.75l7.5-7.5 7.5 7.5"
          />
        </svg>
      </div>
    </button>
    <!--  -->
    <ul v-if="node.children">
      <Nodetree
        v-for="child in node.children"
        v-show="visible"
        :node="child"
        :indent="indent + 2"
      />
    </ul>
  </li>
</template>
<script>
export default {
  name: "NodeTree",
  data() {
    return {
      visible: false,
    };
  },
  props: {
    node: {},
    indent: 0,
  },
  computed: {},
};
</script>

<style></style>
