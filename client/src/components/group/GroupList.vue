<template>
  <div class="space-y-4">
    <div
      v-for="group in groups"
      :key="group.id"
      class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow flex justify-between items-center cursor-pointer hover:ring-2 hover:ring-blue-500 transition"
      @click="$emit('select', group.id)"
    >
      <div>
        <p class="text-lg font-semibold">{{ group.name }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          👥 {{ group.members.length }} thành viên • 💰
          {{ formatCurrency(group.totalCost) }}
        </p>
      </div>
      <div class="text-blue-600 dark:text-blue-400 font-medium">Chi tiết →</div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useGroupStore } from "@/stores/group";

const groupStore = useGroupStore();

const groups = computed(() => groupStore.groups);

function formatCurrency(value) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
    maximumFractionDigits: 0,
  }).format(value);
}
</script>
