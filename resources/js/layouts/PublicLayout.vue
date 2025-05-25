<template>
  <vue-particles
    class="bg-hero"
    color="#19B5FE"
    :particleOpacity="0.7"
    :particlesNumber="80"
    shapeType="polygon"
    :particleSize="2"
    linesColor="#29c5ff"
    :linesWidth="1"
    :lineLinked="true"
    :lineOpacity="0.4"
    :linesDistance="150"
    :moveSpeed="2"
    :hoverEffect="true"
    hoverMode="grab"
    :clickEffect="true"
    clickMode="repulse"
  />

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

  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <!-- Rendered Public View -->
    <router-view :key="$route.fullPath" />
  </div>
</template>

<script>
import SnackBar from "../components/notification/SnackBar.vue";

export default {
  name: "PublicLayout",
  components: { SnackBar },
  computed: {
    messages() {
      return this.$store.getters["system/messages"];
    },
  },
};
</script>
<style scoped>
#particles-js {
  height: 100vh;
  width: 100vw;
}
</style>
