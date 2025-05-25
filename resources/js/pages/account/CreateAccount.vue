<template>
  <form @submit.prevent="submit" class="grid grid-cols-3">
    <CardPartial class="col-span-1 w-full overflow-y-auto pr-4">
      <template #title>Account Details</template>
      <template #cta> </template>
      <!--  -->
      <template #content>
        <div class="w-full flex flex-col p-2">
          <div class="w-full p-2">
            <label class="font-semibold align-middle">Account Name </label>

            <input
              type="text"
              v-model="form.name"
              class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
            />
          </div>
          <div class="w-full p-2">
            <label class="font-semibold align-middle">Select Parent Account </label>
            <select
              v-model="form.parent_id"
              class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
            >
              <option value="">None</option>
              <option v-for="account in accounts" :value="account.id">
                {{ account.name }}
              </option>
            </select>
          </div>
        </div>
      </template>
      <template #action-button>
        <SubmitButton />
      </template>
    </CardPartial>
  </form>
</template>

<script>
import CardPartial from "../../partials/CardPartial.vue";
import SubmitButton from "../../components/SubmitButton.vue";

export default {
  name: "CreateAccount",
  components: { CardPartial, SubmitButton },
  data() {
    return {
      form: {
        name: "",
        parent_id: "",
      },
    };
  },
  methods: {
    submit() {
      console.log(this.form);
    },
  },
  computed: {
    accounts() {
      return this.$store.getters["account/accounts"];
    },
  },
};
</script>

<style scoped></style>
