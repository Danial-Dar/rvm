import Card from './components/Card'

Nova.booting((app, store) => {
  app.component('average-calls-per-campaign', Card)
})
