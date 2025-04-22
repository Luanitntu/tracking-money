<template>
  <div class="max-w-7xl mx-auto p-6 space-y-8">
    <!-- Tổng chi phí -->
    <div class="bg-gray-800 p-6 rounded-xl shadow flex justify-between items-center">
      <h2 class="text-xl font-bold">💰 Tổng chi phí:</h2>
      <span class="text-2xl text-green-400 font-semibold"
        >{{ totalCost.toLocaleString() }}₫</span
      >
    </div>

    <!-- Biểu đồ -->
    <div class="bg-gray-800 p-6 rounded-xl shadow">
      <BarChart :chart-data="chartData" />
    </div>

    <!-- Subscription Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <SubscriptionCard
        v-for="(sub, index) in subscriptions"
        :key="index"
        :subscription="sub"
      />
    </div>

    <!-- Danh sách người dùng -->
    <div class="bg-gray-800 p-6 rounded-xl shadow">
      <h2 class="text-xl font-bold mb-4">👥 Danh sách người dùng</h2>
      <table
        class="w-full table-auto text-left text-sm border-separate border-spacing-y-2"
      >
        <thead>
          <tr class="text-gray-400 border-b border-gray-700">
            <th class="py-2">ID</th>
            <th class="py-2">Tên</th>
            <th class="py-2">Email</th>
            <th class="py-2">Gói tham gia</th>
            <th class="py-2">Tiền nợ</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users"
            :key="user.id"
            class="bg-gray-700 hover:bg-gray-600 rounded-lg"
          >
            <td class="py-2 px-2 rounded-l-lg">{{ user.id }}</td>
            <td class="py-2 px-2">{{ user.name }}</td>
            <td class="py-2 px-2">{{ user.email }}</td>
            <td class="py-2 px-2">{{ user.plan }}</td>
            <td class="py-2 px-2 text-red-400 rounded-r-lg">
              {{ user.debt.toLocaleString() }}₫
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import BarChart from "../components/chart/BarChart.vue";
import SubscriptionCard from "../components/subscription/SubscriptionCard.vue";

const subscriptions = [
  {
    name: "Spotify",
    plan: "Family",
    price: 59000,
    renewDate: "2025-05-12",
    sharedWith: ["Long", "Thao"],
    icon: "https://cdn-icons-png.flaticon.com/512/174/174872.png",
  },
  {
    name: "Netflix",
    plan: "Premium",
    price: 260000,
    renewDate: "2025-05-12",
    sharedWith: [],
    icon: "https://cdn-icons-png.flaticon.com/512/732/732228.png",
  },
  {
    name: "YouTube Premium",
    plan: "Family",
    price: 149000,
    renewDate: "2025-05-20",
    sharedWith: ["An", "Hùng", "Thảo"],
    icon: "https://cdn-icons-png.flaticon.com/512/1384/1384060.png",
  },
  {
    name: "iCloud",
    plan: "200GB",
    price: 59000,
    renewDate: "2025-05-15",
    sharedWith: ["Long"],
    icon: "https://cdn-icons-png.flaticon.com/512/888/888879.png",
  },
  {
    name: "Canva Pro",
    plan: "Team",
    price: 290000,
    renewDate: "2025-05-18",
    sharedWith: ["Minh", "Thảo"],
    icon: "https://cdn-icons-png.flaticon.com/512/5968/5968520.png",
  },
  {
    name: "Figma",
    plan: "Professional",
    price: 300000,
    renewDate: "2025-05-22",
    sharedWith: [],
    icon: "https://cdn-icons-png.flaticon.com/512/5968/5968705.png",
  },
  {
    name: "ChatGPT Plus",
    plan: "Plus",
    price: 460000,
    renewDate: "2025-05-25",
    sharedWith: [],
    icon: "https://cdn-icons-png.flaticon.com/512/9131/9131449.png",
  },
];

const totalCost = subscriptions.reduce((sum, sub) => sum + sub.price, 0);

const chartData = {
  labels: subscriptions.map((s) => s.name),
  datasets: [
    {
      label: "Chi phí theo dịch vụ",
      data: subscriptions.map((s) => s.price),
      backgroundColor: ["#3B82F6", "#EF4444"],
    },
  ],
};

const users = [
  { id: 1, name: "Long", email: "long@example.com", plan: "Spotify", debt: 20000 },
  { id: 2, name: "Thảo", email: "thao@example.com", plan: "Spotify", debt: 20000 },
  { id: 3, name: "An", email: "an@example.com", plan: "Netflix", debt: 65000 },
];
</script>
