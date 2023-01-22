require('./bootstrap');
import { createApp} from "vue";
import example from './components/ExampleComponent'

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import task from './Task'
import chat from './chat/Main'

let app = createApp({
    components:{example, task, chat}
}).mount('#chatApp')


createApp({
    components: {chat}
}).mount("#chatting")
