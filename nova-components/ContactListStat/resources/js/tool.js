import Tool from './pages/Tool'

Nova.booting((app, store) => {
//   Nova.inertia('ContactListStat', Tool)
  Nova.inertia('contact-list-stat/{id}', Tool)

})
