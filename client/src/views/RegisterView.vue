<template>
  <div class="max-w-sm mx-auto mt-16 p-6 bg-gray-800 rounded-2xl shadow space-y-4">
    <div class="bg-gray-800 rounded-2xl shadow w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Tạo tài khoản</h2>

      <form @submit.prevent="register">
        <div class="space-y-4">
          <div>
            <label class="block mb-1 text-sm">Email</label>
            <input
              v-model="email"
              type="email"
              placeholder="your@email.com"
              class="w-full px-4 py-2 rounded-xl bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div>
            <label class="block mb-1 text-sm">Mật khẩu</label>
            <div class="relative">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                placeholder="********"
                class="w-full px-4 py-2 pr-10 rounded-xl bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
              <span
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"
                @click="togglePassword"
              >
                {{ showPassword ? "🙈" : "👁️" }}
              </span>
            </div>
          </div>

          <div>
            <label class="block mb-1 text-sm">Nhập lại mật khẩu</label>
            <div class="relative">
              <input
                :type="showConfirm ? 'text' : 'password'"
                v-model="confirmPassword"
                placeholder="********"
                class="w-full px-4 py-2 pr-10 rounded-xl bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
              <span
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"
                @click="toggleConfirm"
              >
                {{ showConfirm ? "🙈" : "👁️" }}
              </span>
            </div>
          </div>

          <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>

          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 transition text-white py-2 rounded-xl font-semibold"
          >
            Đăng ký
          </button>
        </div>
      </form>

      <p class="mt-4 text-sm text-center text-gray-400">
        Đã có tài khoản?
        <RouterLink to="/login" class="text-blue-400 hover:underline">
          Đăng nhập
        </RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import isEmail from "validator/lib/isEmail";

const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const showPassword = ref(false);
const showConfirm = ref(false);
const error = ref("");
const router = useRouter();
const authStore = useAuthStore();

function togglePassword() {
  showPassword.value = !showPassword.value;
}

function toggleConfirm() {
  showConfirm.value = !showConfirm.value;
}

function register() {
  error.value = "";

  if (!isEmail(email.value)) {
    error.value = "Email không hợp lệ!";
    return;
  }

  if (password.value.length < 6) {
    error.value = "Mật khẩu phải có ít nhất 6 ký tự!";
    return;
  }

  if (password.value !== confirmPassword.value) {
    error.value = "Mật khẩu không khớp!";
    return;
  }

  authStore.register(email.value, password.value);
  router.push("/");
}
</script>
