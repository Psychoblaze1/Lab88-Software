<template>
  <!-- mobile menu -->
  <div class="hidden absolute mobile-menu overflow-none w-full">
    <div class="h-screen w-64 bg-opacity-90 bg-gray-300">
      mobile menu
      <button
        onclick="toggleMobileMenu()"
        class="border h-8 px-2 ml-4 bg-gray-100 shadow rounded-full hover:bg-gray-200"
      >
        toggle mobile
      </button>
    </div>
    <div class="w-full h-screen bg-opacity-80 bg-indigo-300"></div>
  </div>
  <!-- //mobile menu -->

  <div class="flex flex-col h-screen">
    <Header />
    <div class="flex flex-1 overflow-hidden bg-gray-100">
      <router-view :key="$route.fullPath" />

      <!-- notices -->
      <ul
        v-show="messages.length"
        v-for="(message, key) in messages"
        class="absolute top-16 right-8"
      >
        <li>
          <SnackBar :type="message.type" :content="message.content" :key="key" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import Header from "../components/navigation/Header.vue";
import Footer from "../components/navigation/Footer.vue";
import SnackBar from "../components/notification/SnackBar.vue";

export default {
  name: "AuthLayout",
  components: {
    Header,
    Footer,
    SnackBar,
  },
  computed: {
    messages() {
      return this.$store.getters["system/messages"];
    },
  },
};
</script>

<style></style>
