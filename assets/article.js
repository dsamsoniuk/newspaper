import { createApp } from 'vue'
import example from './components/Article'
/**
* Create a fresh Vue Application instance
*/

const app = createApp(example)
app.mount('#article')