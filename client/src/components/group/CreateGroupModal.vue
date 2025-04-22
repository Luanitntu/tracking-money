<template>
  <div
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    v-if="visible"
    @click.self="closeModal"
  >
    <div class="bg-gray-800 rounded-xl p-6 w-full max-w-lg">
      <h2 class="text-xl text-white font-semibold mb-4">➕ Tạo nhóm mới</h2>

      <!-- Tên nhóm -->
      <div class="mb-4">
        <input
          v-model="groupName"
          type="text"
          placeholder="Tên nhóm"
          class="w-full px-4 py-2 rounded-lg border border-gray-600 bg-gray-900 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <p v-if="errors.name" class="text-red-400 text-sm mt-1">{{ errors.name }}</p>
      </div>

      <!-- Chọn gói -->
      <div class="mb-4">
        <Multiselect
          v-model="selectedSubscription"
          :options="subscriptions"
          label="name"
          placeholder="Chọn gói subscription"
          track-by="id"
        />
        <p v-if="errors.subscription" class="text-red-400 text-sm mt-1">
          {{ errors.subscription }}
        </p>
      </div>

      <!-- Chọn người chia sẻ -->
      <div class="mb-6">
        <Multiselect
          v-model="selectedUsers"
          :options="users"
          label="name"
          placeholder="Chọn người chia sẻ"
          track-by="id"
          :multiple="true"
        />
        <p v-if="errors.users" class="text-red-400 text-sm mt-1">{{ errors.users }}</p>
      </div>

      <div class="flex justify-end gap-2">
        <button
          class="px-4 py-2 rounded-lg bg-gray-600 text-white hover:bg-gray-500 transition cursor-pointer"
          @click="close"
        >
          ❌ Cancel
        </button>
        <button
          class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition cursor-pointer"
          @click="submit"
        >
          💾 Save
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import Multiselect from "vue-multiselect";
import { ref, defineEmits } from "vue";

defineProps({ visible: Boolean });
const emit = defineEmits(["close", "save"]);

const groupName = ref("");
const selectedSubscription = ref(null);
const selectedUsers = ref([]);

const subscriptions = [
  { id: 1, name: "Netflix Premium" },
  { id: 2, name: "Spotify Family" },
  { id: 3, name: "YouTube Premium" },
];

const users = [
  { id: 1, name: "An" },
  { id: 2, name: "Bình" },
  { id: 3, name: "Cường" },
  { id: 4, name: "Dương" },
  { id: 5, name: "Hạnh" },
];

// Error states
const errors = ref({
  name: "",
  subscription: "",
  users: "",
});

// Close
const close = () => emit("close");

// Validate before submit
const submit = () => {
  errors.value = {
    name: "",
    subscription: "",
    users: "",
  };

  if (!groupName.value.trim()) {
    errors.value.name = "⚠️ Vui lòng nhập tên nhóm";
  }
  if (!selectedSubscription.value) {
    errors.value.subscription = "⚠️ Vui lòng chọn gói subscription";
  }
  if (selectedUsers.value.length === 0) {
    errors.value.users = "⚠️ Vui lòng chọn ít nhất một người chia sẻ";
  }

  const hasError = Object.values(errors.value).some((err) => err);
  if (hasError) return;

  const newGroup = {
    id: Date.now(),
    name: groupName.value,
    subscription: selectedSubscription.value,
    members: selectedUsers.value,
  };

  emit("save", newGroup);

  // reset
  groupName.value = "";
  selectedSubscription.value = null;
  selectedUsers.value = [];
  close();
};
</script>

<style scoped>
@import "vue-multiselect/dist/vue-multiselect.css";
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

.multiselect__tags-wrap {
  display: flex !important;
  flex-wrap: wrap !important;
}
</style>
