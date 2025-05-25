<template>
  <nav class="flex justify-between py-4 px-10 items-center bg-white border-b">
    <router-link :to="{ name: 'sample-dash' }">
      <img src="/images/lab_88.png" class="h-8" alt="Lab88" />
    </router-link>
    <div class="flex items-center">
      <ul class="flex items-center space-x-6">
        <li v-for="(item, key) in navItems">
          <router-link
            :to="item.path"
            class="uppercase text-md text-gray-700 hover:text-blue-500 hover:border-b hover:border-blue-500"
            :active-class="'text-blue-500'"
          >
            {{ item.name }}
          </router-link>
        </li>
        <!-- Notification -->
        <!-- <li>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
            />
          </svg>
        </li> -->
        <!-- USER -->
        <li></li>
      </ul>

      <button type="button" @click="logout">
        <svg
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
            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
          />
        </svg>
      </button>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      navItems: [
        // { name: "Home", path: "/" },
        { name: "Account", path: "/accounts" },
        { name: "Asset", path: "/assets" },
        { name: "Lab", path: "/lab" },
        { name: "Sample", path: "/samples" },
      ],
    };
  },
  methods: {
    logout() {
      this.$store.dispatch("auth/logout");
      this.$router.replace("/login");
    },
  },
};
</script>

<style></style>
