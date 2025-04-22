<template>
  <div class="min-h-screen dark bg-gray-900 text-white flex">
    <Sidebar />
    <main class="p-4 flex-1">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Sidebar from "@/components/common/Sidebar.vue";
import Header from "@/components/common/Header.vue";
</script>
