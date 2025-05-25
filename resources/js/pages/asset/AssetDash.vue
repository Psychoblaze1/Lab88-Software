<template>
  <AsidePartial>
    <template #content>
      <Tree :treeData="assetChain" />
    </template>
  </AsidePartial>
  <div class="p-4 w-full">
    <div v-show="!assetChain.length">
      <h1 class="text-2xl w-full text-center p-2">Fetching updated asset chain.</h1>
    </div>
    <div v-if="assetChain.length" class="bg-gray-100 overflow-y-auto p-4 w-full">
      <component :is="currentComponent" :asset="currentAsset" />
    </div>
  </div>
</template>

<script>
import AsidePartial from "../../partials/AsidePartial.vue";
import CardPartial from "../../partials/CardPartial.vue";
import Tree from "../../components/navigation/Tree.vue";
// Asset Types
import CreateAsset from "./types/CreateAsset.vue";
import Site from "./types/Site.vue";
import Asset from "./types/Asset.vue";
import Component from "./types/Component.vue";
import SamplePoint from "./types/SamplePoint.vue";

export default {
  name: "AssetDash",
  data() {
    return {};
  },
  components: {
    AsidePartial,
    CardPartial,
    Tree,
    CreateAsset,
    Site,
    Asset,
    Component,
    SamplePoint,
  },
  created() {
    if (!this.assetChain.length) {
      this.$store.dispatch("account/getAssetChain");
    }
  },

  computed: {
    currentComponent: function () {
      switch (
        this.currentAsset.type //TODO: array of 1??
      ) {
        case "site":
          return Site;
          break;
        case "asset":
          return Asset;
          break;
        case "component":
          return Component;
          break;
        case "sample_point":
          return SamplePoint;
          break;
        default:
          console.log(this.currentAsset);
          return CreateAsset;
          break;
      }
    },
    assetChain() {
      return this.$store.getters["account/assetChain"];
    },
    currentAsset() {
      return this.assetChain.filter((chain) => {
        if (chain.id === this.$route.params.id) {
          return chain;
        }
      });
    },
  },
};
</script>

<style scoped></style>
