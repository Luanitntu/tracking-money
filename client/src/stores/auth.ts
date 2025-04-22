import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as null | { email: string },
  }),

  actions: {
    login(email: string, password: string) {
      // ✅ Đây là fake login, sau này thay bằng API
      if (email === 'admin@example.com' && password === '123456') {
        this.user = { email }
      } else {
        throw new Error('Sai email hoặc mật khẩu')
      }
    },

    logout() {
      this.user = null
    },
  },
})
