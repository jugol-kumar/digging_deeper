require('./bootstrap');
import { createApp} from "vue";
import example from './components/ExampleComponent'

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import task from './Task'
import chat from './chat/Main'

import agora from './chat/agora/Main'

// let app = createApp({
//     components:{example, task}
// }).mount('#app')
//
//
createApp(chat).mount('#chatApp')
// createApp(agora).mount('#agora')
