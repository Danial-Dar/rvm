import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-file-drag-drop', IndexField)
  app.component('detail-file-drag-drop', DetailField)
  app.component('form-file-drag-drop', FormField)
})
