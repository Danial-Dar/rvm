import Tool from './pages/Tool'

Nova.booting((app, store) => {
  // Nova.inertia('ViewStat', Tool),
  Nova.inertia('view-stat/{id}', Tool)
})
