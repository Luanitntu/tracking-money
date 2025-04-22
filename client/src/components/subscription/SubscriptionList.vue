<template>
  <div class="h-full overflow-auto pr-2 space-y-4">
    <!-- Ô tìm kiếm -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 py-1 px-1">
      <input
        v-model="search"
        type="text"
        placeholder="🔍 Tìm theo tên..."
        class="bg-gray-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring focus:ring-blue-500 w-full"
      />
    </div>

    <!-- Danh sách đã lọc -->
    <div
      v-for="item in filteredSubscriptions"
      :key="item.id"
      class="p-4 bg-gray-700 text-white rounded-xl shadow flex justify-between items-center"
    >
      <div>
        <p class="text-lg font-semibold">{{ item.name }}</p>
        <p class="text-sm text-gray-300">💰 {{ item.price }} / {{ item.billingCycle }}</p>
      </div>
      <span class="text-sm text-gray-400">{{ item.renewalDate }}</span>
    </div>

    <!-- Trường hợp không có kết quả -->
    <p
      v-if="filteredSubscriptions.length === 0"
      class="text-center text-gray-400 italic mt-4"
    >
      Không tìm thấy subscription nào.
    </p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const search = ref('')

const subscriptions = [
  { id: 1, name: 'Netflix', price: '$9.99', billingCycle: 'month', renewalDate: '2025-05-01' },
  { id: 2, name: 'Spotify', price: '$4.99', billingCycle: 'month', renewalDate: '2025-04-22' },
  { id: 3, name: 'Figma Pro', price: '$12.00', billingCycle: 'month', renewalDate: '2025-04-30' },
  { id: 4, name: 'YouTube Premium', price: '$6.99', billingCycle: 'month', renewalDate: '2025-05-03' },
  { id: 5, name: 'ChatGPT Plus', price: '$20.00', billingCycle: 'month', renewalDate: '2025-04-18' },
  { id: 6, name: 'ChatGPT Plus', price: '$20.00', billingCycle: 'month', renewalDate: '2025-04-18' },
]

// Tạo computed để lọc dữ liệu theo search
const filteredSubscriptions = computed(() =>
  subscriptions.filter((item) =>
    item.name.toLowerCase().includes(search.value.toLowerCase())
  )
)
</script>
