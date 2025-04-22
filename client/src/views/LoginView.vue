<template>
  <div class="max-w-sm mx-auto mt-16 p-6 bg-gray-800 rounded-2xl shadow space-y-4">
    <h2 class="text-2xl font-bold text-center">🔐 Đăng nhập</h2>

    <input
      v-model="email"
      type="email"
      placeholder="Email"
      class="w-full px-4 py-2 rounded-xl bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
    />

    <div class="relative">
      <input
        :type="showPassword ? 'text' : 'password'"
        v-model="password"
        placeholder="Mật khẩu"
        class="w-full px-4 py-2 pr-10 rounded-xl bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <span
        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"
        @click="togglePassword"
      >
        {{ showPassword ? "🙈" : "👁️" }}
      </span>
    </div>

    <button
      @click="handleLogin"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl cursor-pointer"
    >
      🚀 Đăng nhập
    </button>

    <div class="flex justify-between items-center text-sm text-blue-400 mt-2">
      <button @click="handleForgotPassword" class="hover:underline cursor-pointer">
        🔑 Quên mật khẩu?
      </button>
      <button @click="goToRegister" class="hover:underline cursor-pointer">
        📝 Đăng ký tài khoản
      </button>
    </div>

    <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import isEmail from "validator/lib/isEmail";

const router = useRouter();
const authStore = useAuthStore();

const email = ref("");
const password = ref("");
const showPassword = ref(false);
const error = ref("");

function togglePassword() {
  showPassword.value = !showPassword.value;
}

function handleLogin() {
  error.value = "";
  if (!isEmail(email.value)) {
    error.value = "Email không hợp lệ!";
    return;
  }

  if (password.value.length < 6) {
    error.value = "Mật khẩu phải có ít nhất 6 ký tự!";
    return;
  }

  try {
    authStore.login(email.value, password.value);
    router.push("/");
  } catch (err) {
    error.value = err.message;
  }
}

function handleForgotPassword() {
  router.push("/forgot-password");
}

function goToRegister() {
  router.push("/register");
}

onMounted(() => {
  if (authStore.user) {
    router.push("/");
  }
});
</script>
