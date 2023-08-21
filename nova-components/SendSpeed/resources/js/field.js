import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-send-speed', IndexField)
  app.component('detail-send-speed', DetailField)
  app.component('form-send-speed', FormField)
})
