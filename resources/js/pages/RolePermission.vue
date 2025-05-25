<template>
  <div class="grid grid-cols-3 w-full p-4">
    <!-- ROLES -->
    <CardPartial class="col-span-1 w-full overflow-y-auto pr-4">
      <template #title>Roles</template>
      <template #cta>
        <div class="flex flex-row">
          <div class="pr-2">
            <router-link
              to="/sample/"
              class="flex flex-row w-full justify-between text-gray-900 hover:text-blue-500 hover:underline p-2 border rounded-md uppercase"
            >
              <span class="border-r pr-2"> Add Role </span>
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
              <th class="p-2">Name</th>
              <th class="p-2">Description</th>
              <th class="p-2">Status</th>
              <th class="p-2">Actions</th>
            </tr>
          </thead>
          <tbody class="overflow-y-auto">
            <tr
              v-for="(role, rKey) in roles"
              :key="rKey"
              class="border-b border-opacity-20 hover:bg-gray-200"
              :class="selectedRole === rKey ? 'bg-accent text-white' : ''"
            >
              <td class="p-2">
                {{ role.name }}
              </td>

              <td class="p-2">
                <button @click="setRole(rKey)">select</button>
              </td>
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
    <!-- PERMISSIONS -->
    <CardPartial class="col-span-2 w-full overflow-y-auto">
      <template #title>Role Permissions</template>
      <!--  -->
      <template #content>
        <table class="w-full h-full text-xs">
          <thead class="bg-gray-200 text-black sticky top-0">
            <tr class="text-left">
              <th class="p-2">Name</th>
              <th class="p-2">Description</th>
              <th class="p-2">Status</th>
            </tr>
          </thead>
          <tbody class="overflow-y-auto">
            <tr
              v-for="(permission, key) in permissions"
              :key="key"
              class="border-b border-opacity-20 hover:bg-gray-200"
            >
              <td class="p-2">
                {{ permission.name }}
              </td>

              <td class="p-2"></td>
              <td class="p-2"></td>
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
import CardPartial from "../partials/CardPartial.vue";

export default {
  name: "RolePermission",
  components: { CardPartial },
  data() {
    return {
      selectedRole: 0,
      rolePermissions: [
        { roleId: 0, name: "access.something" },
        { roleId: 0, name: "access.something-else" },
        { roleId: 0, name: "access.something-more" },
        { roleId: 1, name: "access.less" },
        { roleId: 2, name: "view.something" },
        { roleId: 2, name: "view.something-else" },
      ],
      roles: [
        { name: "do stuff" },
        { name: "do more stuff" },
        { name: "do other stuff" },
      ],
    };
  },
  methods: {
    setRole(key) {
      this.selectedRole = key;
    },
  },
  computed: {
    permissions() {
      return this.rolePermissions.filter((perm) => {
        if (perm.roleId === this.selectedRole) {
          return perm;
        }
      });
    },
  },
};
</script>

<style scoped></style>
