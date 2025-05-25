<template>
  <div class="page">
    <header ref="header">
      <slot name="header">Default Header</slot>
      <span class="page-number">{{ currentPage }} / {{ totalPages }}</span>
    </header>
    <main ref="main">
      <slot name="content" />
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  data() {
    return {
      pageHeight: 297,
      pageWidth: 210,
      headerWidth: 0,
      headerHeight: 0,
      contentWidth: 0,
      contentHeight: 0,
    };
  },
  mounted() {
    // Header
    this.headerWidth = this.$refs.header.clientWidth * 0.26;
    this.headerHeight = this.$refs.header.clientHeight * 0.26;
    //  Main
    this.contentWidth = this.$refs.main.clientWidth * 0.26;
    this.contentHeight = this.$refs.main.clientHeight * 0.26;
  },
  computed: {
    maxHeight() {
      return this.pageHeight - this.headerHeight;
    },
    totalPages() {
      return Math.ceil(this.contentHeight / this.maxHeight);
    },
    currentPage() {
      return 1;
    },
  },
};
</script>

<style>
.page {
  width: 210mm;
  height: 297mm;
  box-sizing: border-box;
  page-break-after: always;
  background: #fff;
}
</style>
