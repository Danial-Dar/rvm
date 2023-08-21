import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-test-now', IndexField)
  app.component('detail-test-now', DetailField)
  app.component('form-test-now', FormField)
})
