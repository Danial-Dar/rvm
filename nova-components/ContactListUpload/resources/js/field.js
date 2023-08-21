import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-contact-list-upload', IndexField)
  app.component('detail-contact-list-upload', DetailField)
  app.component('form-contact-list-upload', FormField)
})
