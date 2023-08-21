import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-upload-audio', IndexField)
  app.component('detail-upload-audio', DetailField)
  app.component('form-upload-audio', FormField)
})
