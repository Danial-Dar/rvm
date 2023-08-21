import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {
  state: () => ({
    baseUri: '/nova',
    currentUser: null,
    mainMenu: [],
    userMenu: [],
    resources: [],
    version: '4.x',
    mainMenuShown: false,
    notificationsShown: false,
    notifications: [],
    unreadNotifications: false,
    canLeaveForm: true,
    canLeaveModal: true,
    pushStateWasTriggered: false,
    validLicense: true,
  }),

  getters: {
    currentUser: s => s.currentUser,
    currentVersion: s => s.version,
    mainMenu: s => s.mainMenu,
    userMenu: s => s.userMenu,
    mainMenuShown: s => s.mainMenuShown,
    notificationsShown: s => s.notificationsShown,
    notifications: s => s.notifications,
    unreadNotifications: s => s.unreadNotifications,
    canLeaveForm: s => s.canLeaveForm,
    canLeaveFormToPreviousPage: s => s.canLeaveForm && !s.pushStateWasTriggered,
    canLeaveModal: s => s.canLeaveModal,
    validLicense: s => s.validLicense,
  },

  mutations: {
    allowLeavingForm(state) {
      state.canLeaveForm = true
    },

    preventLeavingForm(state) {
      state.canLeaveForm = false
    },

    allowLeavingModal(state) {
      state.canLeaveModal = true
    },

    preventLeavingModal(state) {
      state.canLeaveModal = false
    },

    triggerPushState(state) {
      Inertia.pushState(Inertia.page)
      Inertia.ignoreHistoryState = true
      state.pushStateWasTriggered = true
    },

    resetPushState(state) {
      state.pushStateWasTriggered = false
    },

    toggleMainMenu(state) {
      state.mainMenuShown = !state.mainMenuShown
      console.log('hello world');
      localStorage.setItem('nova.mainMenu.open', state.mainMenuShown)
    },

    toggleNotifications(state) {
      state.notificationsShown = !state.notificationsShown
      localStorage.setItem('nova.mainMenu.open', state.notificationsShown)
    },
  },

  actions: {
    async login({ commit, dispatch }, { email, password, remember }) {
      await Nova.request().post(Nova.url('/login'), {
        email,
        password,
        remember,
      })
    },

    async logout({ state }, customLogoutPath) {
      let response = null

      if (!Nova.config('withAuthentication') && customLogoutPath) {
        response = await Nova.request().post(customLogoutPath)
      } else {
        response = await Nova.request().post(Nova.url('/logout'))
      }

      return response?.data?.redirect || null
    },

    async startImpersonating({}, { resource, resourceId }) {
      let response = null

      response = await Nova.request().post(`/nova-api/impersonate`, {
        resource,
        resourceId,
      })

      let redirect = response?.data?.redirect || null

      if (redirect !== null) {
        location.href = redirect
        return
      }

      Nova.visit('/')
    },

    async stopImpersonating({}) {
      let response = null

      response = await Nova.request().delete(`/nova-api/impersonate`)

      let redirect = response?.data?.redirect || null

      if (redirect !== null) {
        location.href = redirect
        return
      }

      Nova.visit('/')
    },

    async assignPropsFromInertia({ state }) {
      let config = usePage().props.value.novaConfig || Nova.appConfig
      let { resources, base, version, mainMenu, userMenu } = config

      let user = usePage().props.value.currentUser
      let validLicense = usePage().props.value.validLicense

      Nova.appConfig = config
      state.currentUser = user
      state.validLicense = validLicense
      state.resources = resources
      state.baseUri = base
      state.version = version
      state.mainMenu = mainMenu
      state.userMenu = userMenu
    },

    async fetchPolicies({ state, dispatch }) {
      await dispatch('assignPropsFromInertia')
    },

    async fetchNotifications({ state }) {
      const {
        data: { notifications, unread },
      } = await Nova.request().get(`/nova-api/nova-notifications`)

      state.notifications = notifications
      state.unreadNotifications = unread

      const { data } = await Nova.request().get(`/nova-api/custom/get-user-notifications`)

      data.notifications.forEach(notification => {
        Nova.$toasted.show(notification.data.message, { type: notification.data.info, position : 'top-right' });
      });
    },

    async markNotificationAsRead({ state, dispatch }, id) {
      await Nova.request().post(`/nova-api/nova-notifications/${id}/read`)
      dispatch('fetchNotifications')
    },

    async deleteNotification({ state, dispatch }, id) {
      await Nova.request().delete(`/nova-api/nova-notifications/${id}/delete`)
      dispatch('fetchNotifications')
    },

    async markAllNotificationsAsRead({ state, dispatch }, id) {
      await Nova.request().post(`/nova-api/nova-notifications/read-all`)
      dispatch('fetchNotifications')
    },
  },
}
