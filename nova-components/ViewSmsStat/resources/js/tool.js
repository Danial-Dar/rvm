import Tool from './pages/Tool'

Nova.booting((app, store) => {
//   Nova.inertia('ViewSmsStat', Tool)
Nova.inertia('view-sms-stat/{id}', Tool)
})
