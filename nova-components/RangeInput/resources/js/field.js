import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-range-input', IndexField)
  app.component('detail-range-input', DetailField)
  app.component('form-range-input', FormField)
})
