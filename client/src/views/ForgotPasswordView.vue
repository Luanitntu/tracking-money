<template>
  <div class="max-w-sm mx-auto mt-16 p-6 bg-gray-800 rounded-2xl shadow space-y-4">
    <h2 class="text-2xl font-bold text-center">🔑 Quên mật khẩu?</h2>
    <p class="text-sm text-gray-400 text-center">
      Nhập email để nhận hướng dẫn đặt lại mật khẩu.
    </p>

    <input
      v-model="email"
      type="email"
      placeholder="Email"
      class="w-full px-4 py-2 rounded-xl bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
      required
    />

    <button
      @click="handleReset"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl"
    >
      📩 Gửi hướng dẫn
    </button>

    <p v-if="success" class="text-green-400 text-sm text-center">
      Hướng dẫn đã được gửi (giả lập 😄)
    </p>
    <p v-if="error" class="text-red-500 text-sm text-center">{{ error }}</p>

    <button
      @click="goToLogin"
      class="w-full text-sm text-blue-400 hover:underline mt-2 cursor-pointer"
    >
      Quay lại đăng nhập
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import isEmail from "validator/lib/isEmail";

const router = useRouter();
const email = ref("");
const success = ref(false);
const error = ref("");

function handleReset() {
  error.value = "";
  success.value = false;

  if (!email.value || !isEmail(email.value)) {
    error.value = "Email không hợp lệ!";
    return;
  }

  // Giả lập gửi email
  success.value = true;
  console.log("Gửi email reset tới:", email.value);
}

function goToLogin() {
  router.push("/login");
}
</script>
