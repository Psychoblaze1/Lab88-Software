<template>
  <form @submit.prevent="submit" method="POST" class="grid grid-cols-3 w-full space-x-4">
    <CardPartial class="col-span-1 w-full">
      <template #title> Sample Details </template>

      <template #content>
        <!--  -->
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Sample Name: </label>
          <input
            v-model="form.sample.name"
            placeholder="Sample Name"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          />
        </div>
        <!--  -->
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Sample Type: </label>
          <select
            v-model="form.sample.type"
            placeholder="Sample Type"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          >
            <option v-for="type in sampleTypes" :value="type">{{ type }}</option>
          </select>
        </div>
        <!--  -->
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Drawn By: </label>
          <input
            v-model="form.sample.drawn_by"
            placeholder="Drawn By"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          />
        </div>
        <!--  -->
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Date Drawn: </label>
          <input
            v-model="form.sample.drawn_at"
            placeholder="Drawing Date"
            type="date"
            class="w-full text-black placeholder-gray-800 bg-gray-200 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          />
        </div>
      </template>
    </CardPartial>

    <CardPartial class="col-span-1 w-full">
      <template #title>
        <h1 class="text-2xl font-semibold leading-none pl-4">Asset Chain Details</h1>
      </template>

      <template #content>
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Account:</label>
          <select
            v-model="form.chain.account_id"
            @change="updateSitesByAccount"
            class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          >
            <option value="" disabled>Select Account to Sample For</option>
            <option v-for="(account, akey) in accounts" :key="akey" :value="account.id">
              {{ account.name }}
            </option>
          </select>
        </div>
        <!--  -->
        <hr class="my-4" />
        <!--  -->
        <div class="w-full flex flex-col p-2">
          <label class="font-semibold align-middle">Sample Point:</label>
          <select
            v-model="form.chain.sample_point.id"
            class="w-full text-black placeholder-gray-800 px-4 py-2.5 mt-2 text-base transition duration-500 ease-in-out transform border-transparent rounded-md focus:outline-none"
          >
            <option value="" disabled>Select Asset Chain</option>
            <option
              v-for="(samplePoint, spKey) in samplePoints"
              :key="spKey"
              :value="samplePoint.id"
            >
              {{ samplePoint.name }}
            </option>
          </select>
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
  name: "RegisterSample",
  components: {
    CardPartial,
    SubmitButton,
  },
  data() {
    return {
      form: {
        create_chain: false,
        sample: {
          id: "",
          name: "",
          drawn_by: "",
          drawn_at: "",
          type: "",
        },
        chain: {
          account_id: "",
          site: { id: "", name: "" },
          asset: { id: "", name: "" },
          component: { id: "", name: "" },
          sample_point: { id: "", name: "" },
        },
      },
    };
  },
  created() {
    if (this.$store.getters["account/samplePoints"].length === 0) {
      this.$store.dispatch("account/getSamplePoints");
    }
    this.setSample();
  },
  methods: {
    setSample() {
      let sampleId = this.$route.params.id;
      // Set current date
      this.form.sample.drawn_at = moment().format("YYYY-MM-DD");
      this.form.sample.type = this.sampleTypes[0];

      if (sampleId) {
        let sampleStore = this.$store.getters["sample/samples"].find(
          (sample) => sample.id === sampleId
        );
        // Set form values if exist
        this.form.sample.id = sampleStore.id;
        this.form.chain.account_id = sampleStore.account_id;
        this.form.sample.drawn_by = sampleStore.drawn_by;
        this.form.sample.drawn_at = moment(String(sampleStore.drawn_at)).format(
          "YYYY-MM-DD"
        );
        this.form.sample.name = sampleStore.name;
        this.form.chain.sample_point.id = sampleStore.sample_point_id;
        this.form.sample.type = sampleStore.type;

        // when asset chain is altered, so there is a fallback
        this.original_sample_point_id = sampleStore.sample_point_id;
      }
    },
    // SUBMIT
    async submit() {
      console.log(this.form);
      await this.$store.dispatch("sample/registerSample", this.form).then((res) => {
        // if new sample, redir to sample-dash
        if (!this.$route.params.id) {
          //update samples/assets on return
          this.$store.dispatch("sample/flushAll");
          this.$router.replace("/samples");
          this.$store.dispatch("account/flushAll");
        }
      });
    },
  },
  computed: {
    accounts() {
      return this.$store.getters["account/accounts"];
    },

    samplePoints() {
      let samplePoints = this.$store.getters["account/samplePoints"];
      return samplePoints;
    },

    sampleTypes() {
      return this.$store.getters["sample/sampleTypes"];
    },
  },
};
</script>

<style scoped></style>
