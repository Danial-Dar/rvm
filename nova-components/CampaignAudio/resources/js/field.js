import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-campaign-audio', IndexField)
  app.component('detail-campaign-audio', DetailField)
  app.component('form-campaign-audio', FormField)
})
