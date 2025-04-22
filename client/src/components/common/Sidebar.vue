<template>
  <div class="h-screen w-64 bg-gray-900 text-white flex flex-col p-6 space-y-4">
    <div class="text-2xl font-bold text-green-400 mb-6">💸 SubTrack</div>

    <nav class="flex-1 space-y-2">
      <RouterLink
        v-for="item in menuItems"
        :key="item.name"
        :to="item.path"
        class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition"
        :class="{ 'bg-gray-800': route.path === item.path }"
      >
        <span class="text-lg">{{ item.meta.icon }}</span>
        <span>{{ item.name }}</span>
      </RouterLink>
    </nav>

    <div class="text-xs text-gray-500 mt-auto">
      &copy; {{ new Date().getFullYear() }} SubTrack
    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import { computed } from 'vue';

const route = useRoute();
const router = useRouter();

const menuItems = computed(() => {
  return router.options.routes
    .filter(route => route.name && route.path !== '*' && !route.path.includes(':') && route.meta && route.meta.icon)
    .map(route => ({
      name: route.name,
      path: route.path,
      meta: route.meta,
    }));
});
</script>

<style scoped>
::-webkit-scrollbar {
  display: none;
}
</style>