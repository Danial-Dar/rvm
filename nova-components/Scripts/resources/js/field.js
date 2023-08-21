import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-scripts', IndexField)
  app.component('detail-scripts', DetailField)
  app.component('form-scripts', FormField)
})
