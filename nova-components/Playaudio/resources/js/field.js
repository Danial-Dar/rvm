import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-playaudio', IndexField)
  app.component('detail-playaudio', DetailField)
  app.component('form-playaudio', FormField)
})
