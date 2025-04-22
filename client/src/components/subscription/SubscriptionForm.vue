<template>
  <div class="h-full bg-gray-800 p-6 rounded-2xl flex flex-col overflow-auto">
    <p class="text-lg font-semibold text-white mb-4">Thêm Subscription</p>

    <input
      class="w-full mb-3 px-4 py-2 rounded-xl border border-gray-600 bg-gray-900 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
      placeholder="Tên dịch vụ"
    />

    <select
      class="w-full mb-3 px-4 py-2 rounded-xl border border-gray-600 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
    >
      <option disabled selected>Chọn gói sử dụng</option>
      <option value="1">1 tháng</option>
      <option value="3">3 tháng</option>
      <option value="6">6 tháng</option>
      <option value="12">12 tháng</option>
    </select>

    <input
      type="number"
      class="w-full mb-3 px-4 py-2 rounded-xl border border-gray-600 bg-gray-900 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
      placeholder="Giá tiền"
    />

    <div class="relative w-full mb-3">
      <span
        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"
      >
        📅
      </span>
      <input
        type="date"
        class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-600 bg-gray-900 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
      />
    </div>

    <div class="mb-3">
      <label class="block text-sm text-white mb-1">👥 Người chia sẻ:</label>
      <Multiselect
        v-model="selectedUsers"
        :options="users"
        :multiple="true"
        :close-on-select="false"
        :custom-label="formatLabel"
        :track-by="'id'"
        placeholder="Chọn người chia sẻ..."
        label="name"
        class="multiselect-custom"
      >
        <template #option="{ option }">
          <div class="flex items-center gap-2">
            <img :src="option.avatar" class="w-6 h-6 rounded-full" />
            <span>{{ option.name }}</span>
          </div>
        </template>

        <template #tag="{ option, remove }">
          <div
            class="flex items-center gap-2 bg-blue-600 text-white rounded-full px-2 py-1 text-sm mr-1 mb-1"
          >
            <img :src="option.avatar" class="w-4 h-4 rounded-full" />
            <span>{{ option.name }}</span>
            <button
              @click.prevent="remove(option)"
              class="ml-1 text-white hover:text-gray-200"
            >
              ×
            </button>
          </div>
        </template>
      </Multiselect>
    </div>

    <!-- Upload logo -->
    <input
      type="file"
      accept="image/*"
      @change="handleFileUpload"
      class="w-full mb-3 text-sm text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition"
    />

    <div v-if="previewImage" class="mb-4">
      <p class="text-sm text-white mb-1">📸 Xem trước logo:</p>
      <img
        :src="previewImage"
        alt="Preview"
        class="w-24 h-24 object-contain rounded-md border border-gray-600"
      />
    </div>

    <button
      class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl w-full transition"
    >
      💾 Lưu lại
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

const selectedUsers = ref([]);
const users = [
  { id: 1, name: "An", avatar: "https://i.pravatar.cc/40?u=1" },
  { id: 2, name: "Bình", avatar: "https://i.pravatar.cc/40?u=2" },
  { id: 3, name: "Cường", avatar: "https://i.pravatar.cc/40?u=3" },
  { id: 4, name: "Dương", avatar: "https://i.pravatar.cc/40?u=4" },
  { id: 5, name: "Hòa", avatar: "https://i.pravatar.cc/40?u=5" },
  { id: 6, name: "Khoa", avatar: "https://i.pravatar.cc/40?u=6" },
  { id: 7, name: "Linh", avatar: "https://i.pravatar.cc/40?u=7" },
  { id: 8, name: "Minh", avatar: "https://i.pravatar.cc/40?u=8" },
];

const previewImage = ref<string | null>(null);

function handleFileUpload(event: Event) {
  const file = (event.target as HTMLInputElement).files?.[0];
  if (file && file.type.startsWith("image/")) {
    const reader = new FileReader();
    reader.onload = () => {
      previewImage.value = reader.result as string;
    };
    reader.readAsDataURL(file);
  } else {
    previewImage.value = null;
  }
}
</script>

<style scoped>
.multiselect-custom .multiselect {
  background-color: #1f2937; /* gray-800 */
  border: 1px solid #4b5563; /* gray-600 */
  color: white;
  border-radius: 0.75rem; /* rounded-xl */
  padding: 0.5rem 0.75rem;
}

.multiselect-custom .multiselect__input {
  background-color: transparent;
  color: white;
}

.multiselect-custom .multiselect__option--highlight {
  background: #3b82f6 !important; /* blue-500 */
  color: white !important;
}

/* Selected option */
.multiselect-custom .multiselect__option--selected {
  background: #2563eb !important; /* blue-600 */
  color: white !important;
}
.multiselect-custom .multiselect__tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem; /* spacing giữa các tag */
  padding: 0.25rem;
}

.multiselect__tags-wrap{
  display: flex !important;
  flex-wrap: wrap !important;
}
</style>
