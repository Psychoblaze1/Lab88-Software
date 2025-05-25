<template>
  <ul class="overflow-y-auto w-full">
    <NodeTree v-for="(node, key) in treeData" :node="node" />
  </ul>
</template>

<script>
import NodeTree from "./Nodetree.vue";

export default {
  name: "Tree",
  components: {
    NodeTree,
  },
  props: {
    treeData: Object,
  },
  computed: {},
};
</script>

<style></style>
