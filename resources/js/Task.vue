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
    export default {
        data(){
            return {
                tasks :[],
                task_name:''
            }
        },
        created() {
            axios.get('/api/tasks').then(response =>(this.tasks = response.data))

            this.task_name =  " "

            Echo.channel('tasks').listen('TaskEvent', ({task}) => {
                this.tasks.push({'task_name': task.task_name})
            });

            // window.Echo.channel("tasks").listen("TaskEvent", ({task}) =>{
            //     this.tasks.push({'task_name': task.task_name})
            // })
        },
        methods:{
            addTask(){
                axios.post('/tasks-create', {task_name:this.task_name})
            }
        }

    }
</script>
