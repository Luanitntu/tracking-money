import { defineStore } from 'pinia'

export const useGroupStore = defineStore('group', {
  state: () => ({
    groups: [
      {
        id: '1',
        name: 'Nhóm Spotify',
        members: ['Tú', 'Linh', 'Nam'],
        subscriptions: [
          {
            id: 'sub1',
            name: 'Spotify Family',
            price: 149000,
            sharedWith: [
              { name: 'Tú', paid: true },
              { name: 'Linh', paid: false },
              { name: 'Nam', paid: false },
            ],
          },
          {
            id: 'sub2',
            name: 'Netflix Standard',
            price: 260000,
            sharedWith: [
              { name: 'Tú', paid: true },
              { name: 'Linh', paid: true },
            ],
          },
        ],
      },
      {
        id: '2',
        name: 'Team học tập',
        members: ['An', 'Bình'],
        subscriptions: [
          {
            id: 'sub3',
            name: 'ChatGPT Plus',
            price: 500000,
            sharedWith: [
              { name: 'An', paid: true },
              { name: 'Bình', paid: false },
            ],
          },
        ],
      },
    ],
  }),

  actions: {
    togglePaid(groupId: string, subId: string, memberName: string) {
      const group = this.groups.find((g) => g.id === groupId)
      const sub = group?.subscriptions.find((s) => s.id === subId)
      const member = sub?.sharedWith.find((m) => m.name === memberName)
      if (member) member.paid = !member.paid
    },
  },
})
