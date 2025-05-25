<template>
  <aside class="border-r w-60">
    <div class="bg-white rounded-sm p-2 h-full w-full">
      <slot name="content"></slot>
    </div>
  </aside>
</template>

<script>
export default {
  name: "AsidePartial",
};
</script>
