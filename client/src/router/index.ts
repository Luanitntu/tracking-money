// src/router/index.ts
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import GroupPage from '../views/GroupPage.vue'
import GroupDetail from '../components/group/GroupDetail.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import ForgotPasswordView from '../views/ForgotPasswordView.vue'
import ManageView from '../views/ManageView.vue'

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: HomeView,
    meta: { icon: '📊', order: 1 },
  },
  {
    path: '/manage',
    name: 'Manage Subscriptions',
    component: ManageView,
    meta: { icon: '🧾', order: 2 },
  },
  {
    path: '/group',
    name: 'Page Groups',
    component: GroupPage,
    meta: { icon: '📂', order: 3 },
  },
  {
    path: '/group/:id',
    name: 'GroupDetail',
    component: GroupDetail,
    props: true,
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterView,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView,
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPasswordView,
  },

  // {
  //   path: '/users',
  //   name: 'Users',
  //   component: () => import('../views/UsersView.vue'), // Giả sử bạn có component này
  //   meta: { icon: '👥', order: 3 },
  // },
  // {
  //   path: '/settings',
  //   name: 'Settings',
  //   component: () => import('../views/SettingsView.vue'), // Giả sử bạn có component này
  //   meta: { icon: '⚙️', order: 7 },
  // },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
