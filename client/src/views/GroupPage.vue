<template>
  <div>
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-2xl font-bold text-white">📋 Danh sách nhóm</h1>
      <CreateGroupModal
        :visible="showModal"
        @close="showModal = false"
        @save="handleSave"
      />
      <button
        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl cursor-pointer"
        @click="showModal = true"
      >
        ➕ Tạo nhóm mới
      </button>
    </div>

    <ul class="space-y-2">
      <li
        v-for="group in groups"
        :key="group.id"
        class="bg-gray-800 p-4 rounded-xl hover:bg-gray-700 transition"
      >
        <RouterLink :to="`/group/${group.id}`" class="block text-white">
          {{ group.name }} ({{ group.members.length }} thành viên)
        </RouterLink>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useGroupStore } from "@/stores/group";
import { RouterLink } from "vue-router";
import CreateGroupModal from "@/components/group/CreateGroupModal.vue";

const groupStore = useGroupStore();
const groups = groupStore.groups;

const showModal = ref(false);
function handleSave(newGroup) {
  console.log("Nhóm mới:", newGroup);
  // TODO: Lưu vào store hoặc xử lý tiếp
}
</script>
