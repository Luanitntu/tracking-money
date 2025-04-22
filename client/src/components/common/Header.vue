<template>
  <header
    class="bg-gray-900 text-white px-6 py-4 flex justify-between items-center rounded-xl mb-4 shadow-md"
  >
    <div>
      <h1 class="text-xl font-bold">📊 SubTrack</h1>
      <p class="text-sm text-yellow-400">Tổng chi tháng này: 1.200.000 VND</p>
    </div>
    <nav class="flex space-x-4">
      <router-link
        to="/"
        class="px-3 py-1 rounded hover:bg-gray-700"
        :class="{ 'bg-blue-600 text-white': $route.path === '/' }"
      >
        🏠 Trang chủ
      </router-link>
      <router-link
        to="/group"
        class="px-3 py-1 rounded hover:bg-gray-700"
        :class="{ 'bg-blue-600 text-white': $route.path === '/group' }"
      >
        👥 Nhóm
      </router-link>
    </nav>
  </header>
</template>
