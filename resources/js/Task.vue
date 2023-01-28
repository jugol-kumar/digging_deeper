<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        <ul>
                            <li v-for="task in tasks" v-html="task.task_name"></li>
                        </ul>
                    </div>

                    <input type="text" v-model="task_name" @blur="addTask">
                </div>
            </div>
        </div>
    </div>
</template>php

<script>
    import Echo from "laravel-echo";

    export default {
        data(){
            return {
                tasks :[],
                task_name:'',
                echo:''
            }
        },
        created() {
            if(!this.echo){
                this.echo = new Echo({
                    key: process.env.MIX_PUSHER_APP_KEY,
                    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                    forceTLS: true,
                    broadcaster: 'pusher',
                    encrypted: true,
                    //csrfToken: null,
                    //namespace: 'App',
                })
                this.echo.connector.pusher.connection.bind('connected', (event) => this.connect(event))
                this.echo.connector.pusher.connection.bind('disconnected', () => this.disconnect())
            }
            // this.echo.connector.pusher.config.auth.headers.Authorization = 'Bearer ' + this.currentUser.api_token
            this.echo.connector.pusher.connect()
        },
        mounted() {
            axios.get('/api/tasks').then(response => (this.tasks = response.data))
            this.task_name = " "
            if (this.echo !== null){
                // Echo.channel('tasks').listen('TaskEvent', ({task}) => {
                //     this.tasks.push({'task_name': task.task_name})
                // });
                // Echo.channel('mychanel').listen('MyChanelEvent', function (data) {
                //     console.log(data);
                // })
                //
                // window.Echo.channel("tasks").listen("TaskEvent", ({task}) => {
                //     this.tasks.push({'task_name': task.task_name})
                // })
                this.echo.chanel('tasks' + '.' + this.currentUser.id)
                    .notification((object) => vm.notifications.push(object))
            }else{
                console.log('not connect pusher')
            }
        },
        methods:{
            addTask(){
                axios.post('/tasks-create', {task_name:this.task_name})
            },
            disconnect(){
                if(!this.echo) return
                this.echo.disconnect()
            },
        }




    }
</script>
