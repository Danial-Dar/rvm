import Tool from './pages/Tool'

Nova.booting((app, store) => {
//   Nova.inertia('BotTrain', Tool)
  Nova.inertia('bot-train/{id}', Tool)
})
