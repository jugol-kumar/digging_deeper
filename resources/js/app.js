require('./bootstrap');
import { createApp} from "vue";
import { createPinia } from "pinia";
import VueFeather from 'vue-feather';



import example from './components/ExampleComponent'

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import task from './Task'
import chat from './chat/Main'


// let app = createApp({
//     components:{example, task}
// }).mount('#app')
//
//
let app = createApp(chat)
app.use(createPinia())
app.mount('#chatApp')
app.component(VueFeather.name, VueFeather)
// createApp(agora).mount('#agora')
