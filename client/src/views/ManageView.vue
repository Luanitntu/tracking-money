<template>
  <div class="flex h-screen bg-gray-900 text-white">
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">📦 Quản lý Subscription</h1>
        <select
          class="bg-gray-800 text-white px-4 py-2 rounded-xl border border-gray-700"
        >
          <option>Sắp xếp: Tên</option>
          <option>Sắp xếp: Ngày</option>
        </select>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- FORM -->
        <SubscriptionForm
          :editing-subscription="editingSubscription"
          @submitted="handleFormSubmit"
        />

        <!-- LIST -->
        <SubscriptionList
          :subscriptions="filteredSubscriptions"
          v-model:search="search"
          @edit="editingSubscription = $event"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import Sidebar from "@/components/common/Sidebar.vue";
import SubscriptionForm from "@/components/subscription/SubscriptionForm.vue";
import SubscriptionList from "@/components/subscription/SubscriptionList.vue";


const subscriptions = ref([
  {
    id: 1,
    name: "Netflix",
    price: "$9.99",
    billingCycle: "month",
    renewalDate: "2025-05-01",
  },
  {
    id: 2,
    name: "Spotify",
    price: "$4.99",
    billingCycle: "month",
    renewalDate: "2025-04-22",
  },
  {
    id: 3,
    name: "Figma Pro",
    price: "$12.00",
    billingCycle: "month",
    renewalDate: "2025-04-30",
  },
  {
    id: 4,
    name: "YouTube Premium",
    price: "$6.99",
    billingCycle: "month",
    renewalDate: "2025-05-03",
  },
  {
    id: 5,
    name: "ChatGPT Plus",
    price: "$20.00",
    billingCycle: "month",
    renewalDate: "2025-04-18",
  },
]);

const editingSubscription = ref(null);

function handleFormSubmit(sub) {
  if (sub.id) {
    const idx = subscriptions.value.findIndex((s) => s.id === sub.id);
    if (idx !== -1) subscriptions.value[idx] = sub;
  } else {
    sub.id = Date.now();
    subscriptions.value.push(sub);
  }
  editingSubscription.value = null;
}
</script>
