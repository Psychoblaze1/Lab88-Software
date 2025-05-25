<template>
  <section
    class="flex items-center h-full p-16 bg-white text-black dark:bg-gray-900 dark:text-gray-100"
  >
    <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
      <div class="max-w-md text-center">
        <h2 class="mb-8 font-extrabold text-9xl dark:text-gray-600">
          <span class="sr-only">Error</span>404
        </h2>
        <p class="text-2xl font-semibold md:text-3xl">
          Sorry, we couldn't find this page.
        </p>
        <!-- <p class="mt-4 mb-8 dark:text-gray-400">
          But dont worry, you can find plenty of other things on our homepage.
        </p> -->
        <button
          rel="noopener noreferrer"
          @click="$router.go(-1), (working = true)"
          class="px-8 py-3 font-semibold rounded bg-blue-500 text-white"
        >
          <span v-if="!working">Back</span>
          <span v-else>WORKING <i class="fa fa-spinner animate-spin" /></span>
        </button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "NotFound404",
  data() {
    return {
      working: false,
    };
  },
};
</script>

<style scoped></style>
