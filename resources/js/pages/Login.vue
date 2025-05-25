<template>
  <div
    class="space-y-8 bg-white p-8 border border-gray-500 shadow-xl rounded-md w-80 bg-opacity-75"
  >
    <img
      class="w-full h-auto align-middle border-none"
      src="/images/lab_88.png"
      alt="LAB 88"
    />
    <h2 class="mt-6 text-left text-xl uppercase">Sign in to your account</h2>

    <div class="rounded-md shadow-sm -space-y-px">
      <div>
        <label for="email-address" class="sr-only">Email address</label>
        <input
          v-model="email"
          id="email-address"
          name="email"
          type="email"
          autocomplete="email"
          required
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
          placeholder="Email address"
        />
      </div>
      <div>
        <label for="password" class="sr-only">Password</label>
        <input
          v-model="password"
          @keyup.enter="login"
          id="password"
          type="password"
          autocomplete="current-password"
          required
          class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
          placeholder="Password"
        />
      </div>
      <div class="p-4"></div>

      <button
        @click.prevent="login"
        class="w-full flex justify-center py-2 px-4 border border-blue-500 text-sm font-medium rounded-md focus:outline-none focus:ring-gray-500"
        :class="
          loading
            ? 'bg-accent animate-pulse text-white'
            : 'text-gray-500 bg-white hover:border-blue-500'
        "
      >
        <span v-if="!loading"> SIGN IN </span>
        <span v-else class="font-semibold">AUTHENTICATING</span>
      </button>
    </div>
  </div>
  <!--  -->
  <div class="flex items-center justify-between">
    <div class="text-sm">
      <router-link to="forgot-password" class="font-medium text-blue-500 hover:border-b">
        Forgot your password?
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  components: {},
  beforeCreate() {
    axios.get("/sanctum/csrf-cookie");
    this.$store.dispatch("system/setLoading", false);
  },
  methods: {
    async login() {
      this.$store.dispatch("system/setLoading", true);
      await this.$store
        .dispatch("auth/login", {
          email: this.email,
          password: this.password,
        })
        .then((r) => {
          this.$store.dispatch("account/getAccountData", false);
          this.$store.dispatch("system/setLoading", false);
          this.$router.replace("/samples");
        });
    },
  },
  computed: {
    loading() {
      return this.$store.getters["system/loading"];
    },
  },
};
</script>

<style scoped></style>
