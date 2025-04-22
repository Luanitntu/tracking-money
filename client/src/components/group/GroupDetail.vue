<template>
  <div v-if="group" class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
      <h2 class="text-xl font-bold mb-1">{{ group.name }}</h2>
      <p class="text-sm text-gray-500 dark:text-gray-400">
        👥 {{ group.members.length }} thành viên
      </p>
    </div>

    <div class="space-y-4">
      <div
        v-for="sub in group.subscriptions"
        :key="sub.id"
        class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl"
      >
        <div class="flex justify-between items-center">
          <div>
            <p class="font-semibold text-lg">{{ sub.name }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-300">
              💰 {{ formatCurrency(sub.price) }} / tháng — chia cho
              {{ sub.sharedWith.length }} người
            </p>
            <p class="text-sm text-gray-500 mt-1">
              🗓️ Gia hạn: {{ formatDate(sub.dueDate) }}
            </p>
          </div>
          <span class="text-blue-600 dark:text-blue-400 font-medium">
            {{ formatCurrency(perPerson(sub)) }} / người
          </span>
        </div>

        <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
          <div
            v-for="member in sub.sharedWith"
            :key="member.name"
            class="flex items-center justify-between bg-white dark:bg-gray-800 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600"
          >
            <span>{{ member.name }}</span>
            <label
              class="flex items-center space-x-1 text-sm text-gray-600 dark:text-gray-300"
            >
              <input
                type="checkbox"
                :checked="member.paid"
                @change="() => togglePaid(group.id, sub.id, member.name)"
                class="form-checkbox text-blue-600"
              />
              <span>Đã thu</span>
            </label>
          </div>
        </div>

        <div class="mt-3 text-sm text-red-500 font-medium">
          💸 Còn thiếu: {{ formatCurrency(unpaidTotal(sub)) }}
        </div>

        <button
          @click="remindUnpaid(sub)"
          class="mt-2 text-sm text-blue-500 hover:underline"
        >
          🔔 Gửi nhắc thành viên chưa trả
        </button>
      </div>
    </div>
  </div>

  <div v-else class="text-center text-gray-500 dark:text-gray-400">
    Chọn một nhóm để xem chi tiết
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useGroupStore } from "@/stores/group";
import { useRoute } from "vue-router";

const groupStore = useGroupStore();
const togglePaid = groupStore.togglePaid;

const route = useRoute();
const groupId = computed(() => route.params.id);
const group = computed(() => groupStore.groups.find((g) => g.id === groupId.value));

function formatCurrency(value) {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
    maximumFractionDigits: 0,
  }).format(value);
}

function perPerson(sub) {
  const count = sub.sharedWith.length || 1;
  return sub.price / count;
}

function unpaidTotal(sub) {
  return sub.sharedWith
    .filter((m) => !m.paid)
    .reduce((sum, m) => sum + perPerson(sub), 0);
}

function formatDate(dateStr) {
  return new Date(dateStr).toLocaleDateString("vi-VN");
}

function remindUnpaid(sub) {
  const unpaid = sub.sharedWith.filter((m) => !m.paid).map((m) => m.name);
  if (unpaid.length === 0) {
    alert("🎉 Tất cả thành viên đã thanh toán!");
  } else {
    alert(`🔔 Gửi nhắc tới: ${unpaid.join(", ")}`);
  }
}
</script>
