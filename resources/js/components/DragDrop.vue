<template>
  <div class="w-full bg-white p-2 rounded-md mb-4">
    <form ref="form" @submit.prevent method="post" enctype="multipart/form-data">
      <input
        class="cursor-pointer"
        ref="fileInput"
        type="file"
        @change="uploadFile"
        style="display: none"
        multiple
      />
      <div @drop="onDrop" @dragover.prevent @dragenter.prevent>
        <div
          class="flex flex-row justify-center border border-gray-500 hover:border-blue-500 rounded-md border-dashed m-auto text-blue-500 hover:font-semibold"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-8 h-8"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"
            />
          </svg>
          <p class="p-4 uppercase">drag and drop here</p>
        </div>
      </div>
    </form>
    <table v-if="files.length" class="file-table w-full overflow-hidden p-4 mt-4">
      <thead class="bg-gray-200 text-black border-b max-h-8">
        <tr>
          <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
          <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Size</th>
          <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Actions</th>
        </tr>
      </thead>
      <tbody class="overflow-x-auto">
        <tr
          v-for="(file, index) in files"
          :key="file.name"
          class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100"
        >
          <td class="p-4 text-sm font-medium text-gray-900">
            {{ file.name }}
          </td>
          <td class="p-4 text-sm font-medium text-gray-900">{{ file.size }} bytes</td>
          <td class="p-4 text-sm font-medium text-gray-900">
            <button @click="removeFile(index)" class="remove-file-button">Remove</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="submit-button-container">
      <button v-if="files.length" @click="submitForm" class="submit-button">
        Submit
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "DragDrop",
  data() {
    return {
      files: [],
    };
  },
  methods: {
    onDrop(e) {
      e.preventDefault();
      this.uploadFile(e.dataTransfer.files);
    },
    uploadFile(fileList) {
      this.files = fileList;
    },
    removeFile(index) {
      console.log(index, this.files);
      this.files.splice(index, 1);
    },
    submitForm() {
      const formData = new FormData(this.$refs.form);
      axios
        .post("/api/upload/instrument-files", formData)
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
.drag-and-drop-text {
  padding: 20px;
  text-align: center;
  background-color: #f5f5f5;
  border: 2px dashed #ccc;
}
</style>
