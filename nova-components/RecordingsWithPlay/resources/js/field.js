import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-recordings-with-play', IndexField)
  app.component('detail-recordings-with-play', DetailField)
  app.component('form-recordings-with-play', FormField)
})
