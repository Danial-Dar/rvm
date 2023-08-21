import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-phone-number', IndexField)
  app.component('detail-nova-phone-number', DetailField)
  app.component('form-nova-phone-number', FormField)
})
