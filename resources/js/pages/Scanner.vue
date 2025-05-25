<template>
  <AsidePartial>
    <template #content>
      <div class="flex flex-col h-full justify-between">
        <ul>
          <NavItem toName="sample-stepper" title="New Sample">
            <template #icon>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
              </svg>
            </template>
          </NavItem>
          <!--  -->
          <NavItem toName="scanner" title="Scan QR/Barcode">
            <template #icon>
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
                  d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"
                />
              </svg>
            </template>
          </NavItem>
        </ul>
      </div>
    </template>
  </AsidePartial>
  <CardPartial class="p-4 col-span-1 w-full overflow-y-auto">
    <template #title> Scanner Window </template>
    <template #cta>
      <button
        @click="startScanner"
        class="flex flex-row w-full justify-between text-gray-900 hover:text-blue-500 hover:underline p-2 border rounded-md uppercase"
      >
        <span class="border-r pr-2"> Start </span>
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
            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z"
          />
        </svg>
      </button>
      <button
        @click="stopScanner"
        class="flex flex-row w-full justify-between text-gray-900 hover:text-blue-500 hover:underline p-2 border rounded-md uppercase"
      >
        <span class="border-r pr-2"> Stop </span>
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
            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 019 14.437V9.564z"
          />
        </svg>
      </button>
    </template>
    <template #content>
      <div>
        <div id="scanner-container"></div>
      </div>
    </template>
    <div class="col-span-2">
      response from scanner:
      <p>{{ barcode }}</p>
    </div>
  </CardPartial>
</template>
<script>
import AsidePartial from "../partials/AsidePartial.vue";
import CardPartial from "../partials/CardPartial.vue";
import Quagga from "quagga";
export default {
  name: "Scanner",
  data() {
    return {
      barcode: "",
    };
  },
  components: { AsidePartial, CardPartial },
  mounted() {},
  beforeDestroy() {
    Quagga.offDetected(this.onDetected);
  },
  methods: {
    startScanner() {
      Quagga.init(
        {
          inputStream: {
            type: "LiveStream",
            target: document.querySelector("#scanner-container"),
            constraints: {
              width: 640,
              height: 480,
              aspectRatio: 1,
              facingMode: "environment",
            },
          },
          decoder: {
            readers: ["code_128_reader"],
          },
        },
        function (err) {
          if (err) {
            console.log(err);
            return;
          }
          console.log("Initialization finished. Ready to start");
          Quagga.start();
        }
      );
      Quagga.onDetected(this.onDetected);
    },
    stopScanner() {
      Quagga.stop();
    },
    onDetected(result) {
      this.barcode = result.codeResult.code;
    },
  },
};
</script>

<style scoped></style>
