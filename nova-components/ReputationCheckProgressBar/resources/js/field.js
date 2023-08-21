import IndexField from './components/IndexField'
// import DetailField from './components/DetailField'
// import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-reputation-check-progress-bar', IndexField)
//   app.component('detail-reputation-check-progress-bar', DetailField)
//   app.component('form-reputation-check-progress-bar', FormField)
})
