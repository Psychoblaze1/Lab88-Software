<template>
  <div class="w-full p-4 bg-white shadow-md mb-4 rounded-md">
    <h1 class="text-2xl font-semibold leading-none">
      {{ sample.name }}
    </h1>
  </div>
  <form @submit.prevent="submit" method="POST" class="grid grid-cols-3 w-full space-x-4">
    <CardPartial class="col-span-1">
      <template #title>Receive Sample</template>

      <template #content>
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Receiving Lab:</label>
          <select
            v-model="form.lab_id"
            class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          >
            <option disabled value="">Select Receiving Lab</option>
            <option v-for="(lab, lKey) in labs" :key="lKey" :value="lab.id">
              <span class="capitalize"> {{ lab.name }}</span>
            </option>
          </select>
        </div>
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Receipt Date: </label>
          <input
            v-model="form.received_at"
            type="date"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          />
        </div>
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Received By: </label>
          <input
            v-model="form.received_by"
            placeholder="Full Name"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          />
        </div>
      </template>
      <template #action-button>
        <SubmitButton />
      </template>
    </CardPartial>
  </form>
</template>

<script>
import moment from "moment";
import CardPartial from "../../../partials/CardPartial.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

export default {
  name: "ReceiveSample",
  components: { CardPartial, SubmitButton },
  data() {
    return {
      form: {
        lab_id: "",
        received_at: "",
        received_by: "",
        sample_id: "",
      },
    };
  },
  props: {
    sample: "",
  },
  created() {
    this.form.received_at = moment(moment()).format("YYYY-MM-DD");
    this.form.received_by = this.$store.getters["auth/user"].name;
    this.form.sample_id = this.$route.params.id;
    if (this.labs.length === 1) {
      this.form.lab_id = this.labs[0].id;
    }
  },
  methods: {
    submit() {
      this.$store.dispatch("sample/receiveSample", this.form);
    },
  },
  computed: {
    labs() {
      return this.$store.getters["lab/labs"];
    },
  },
};
</script>

<style scoped></style>
