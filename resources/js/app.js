require('./bootstrap');
import { createApp} from "vue";
import example from './components/ExampleComponent'

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import task from './Task'

let app = createApp({
    components:{example, task}
}).mount('#chatApp')
