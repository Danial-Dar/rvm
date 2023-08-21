import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-audio-fields', IndexField)
  app.component('detail-audio-fields', DetailField)
  app.component('form-audio-fields', FormField)
})
