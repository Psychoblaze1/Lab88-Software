<template>
  <div class="grid grid-cols-1 w-full p-4">
    <!-- <Scanner /> -->
    <CardPartial class="col-span-1 w-full overflow-y-auto">
      <template #title>Users</template>
      <template #cta>
        <div class="flex flex-row">
          <div class="pr-2">
            <router-link
              to="/sample/"
              class="flex flex-row w-full justify-between text-gray-900 hover:text-blue-500 hover:underline p-2 border rounded-md uppercase"
            >
              <span class="border-r pr-2"> Add User </span>
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
            </router-link>
          </div>
        </div>
      </template>
      <!--  -->
      <template #content>
        <table class="w-full h-full text-xs">
          <thead class="bg-gray-200 text-black sticky top-0">
            <tr class="text-left">
              <th class="p-2">User</th>
              <th class="p-2">Email</th>
              <th class="p-2">Allocation</th>
              <th class="p-2">Roles</th>
              <th class="p-2">Actions</th>
            </tr>
            <!-- Filters -->
            <tr class="text-left bg-gray-100 p-2">
              <th class="p-2">
                <div class="flex flex-row -p2">
                  <button>A/D</button>
                  <input type="text" placeholder="Search" class="w-full" />
                </div>
              </th>
              <th class="p-2">
                <select class="w-full">
                  <option value="">All Emails</option>
                  <option>
                    <span class="capitalize"> option</span>
                  </option>
                </select>
              </th>
              <th class="p-2">
                <select class="w-full">
                  <option value="">All Allocations</option>
                  <option>
                    <span class="capitalize">option</span>
                  </option>
                </select>
              </th>
              <th class="p-2">
                <select class="w-full">
                  <option value="">All Roles</option>
                  <option>
                    <span class="uppercase">option</span>
                  </option>
                </select>
              </th>
              <th class="p-2">
                <!-- DROPDOWN -->
                <div class="flex justify-start bg-gray-200">
                  <div>
                    <div class="dropdown relative">
                      <button
                        @click="columnOptionsToggle = !columnOptionsToggle"
                        class="text-xs capitalize flex items-center"
                        type="button"
                      >
                        Data
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="w-4 h-4"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                          />
                        </svg>
                      </button>
                      <ul
                        v-show="columnOptionsToggle"
                        class="absolute w-64 right-0 bg-gray-100 text-xs z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 m-0 bg-clip-padding border-none"
                      >
                        <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                          <input type="checkbox" />
                          Received Date
                        </li>
                        <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                          <input type="checkbox" />
                          Tested Date
                        </li>
                        <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                          <input type="checkbox" />
                          Released Date
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--  -->
              </th>
            </tr>
          </thead>
          <tbody class="overflow-y-auto">
            <tr
              v-for="(user, key) in users"
              :key="key"
              class="border-b border-opacity-20 hover:bg-gray-200"
            >
              <td class="p-2">
                <router-link
                  :to="'/user/' + user.id"
                  class="text-blue-500 hover:underline"
                >
                  {{ user.name }}
                </router-link>
              </td>

              <td class="p-2"></td>
              <td class="p-2"></td>

              <td class="p-2"></td>
              <td class="p-2">
                <!-- <button @click="deleteUser(key)">Delete</button> -->
              </td>
            </tr>
          </tbody>
          <!-- PAGINATE -->
          <!-- <Paginate /> -->
        </table>
      </template>
    </CardPartial>
  </div>
</template>
<script>
import CardPartial from "../../partials/CardPartial.vue";

export default {
  name: "UsersDash",
  components: { CardPartial },
  data() {
    return {
      users: [],
    };
  },
};
</script>

<style scoped></style>
