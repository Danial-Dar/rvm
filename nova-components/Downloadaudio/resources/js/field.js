import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-downloadaudio', IndexField)
  app.component('detail-downloadaudio', DetailField)
  app.component('form-downloadaudio', FormField)
})
