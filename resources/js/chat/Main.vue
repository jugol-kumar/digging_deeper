<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1>Hello Mr {{ name }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="d-flex chat-item align-items-center mb-2">
                            <img src="../../../public/sundor.jpg" alt="" class="rounded-circle">
                            <div class="d-flex flex-column">
                                <p class="chat-content mb-2">Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem optio perspiciatis sed tenetur. Architecto consectetur ex id incidunt minima molestias natus ratione. Deleniti eos, eveniet harum ipsa quis quisquam reprehenderit.</p>
                                <p class="chat-content">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>

                        <div class="d-flex chat-item align-items-center flex-row-reverse mb-2">
                            <img src="../../../public/sundor.jpg" alt="" class="rounded-circle">
                            <p class="chat-content">Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem optio perspiciatis sed tenetur. Architecto consectetur ex id incidunt minima molestias natus ratione. Deleniti eos, eveniet harum ipsa quis quisquam reprehenderit.</p>
                        </div>

                        <div class="d-flex chat-item align-items-center mb-2">
                            <img src="../../../public/sundor.jpg" alt="" class="rounded-circle">
                            <div class="d-flex flex-column">
                                <p class="chat-content mb-2">Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem optio perspiciatis sed tenetur. Architecto consectetur ex id incidunt minima molestias natus ratione. Deleniti eos, eveniet harum ipsa quis quisquam reprehenderit.</p>
                                <p class="chat-content">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>

                        <div class="d-flex chat-item align-items-center flex-row-reverse mb-2">
                            <img src="../../../public/sundor.jpg" alt="" class="rounded-circle">
                            <p class="chat-content">Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem optio perspiciatis sed tenetur. Architecto consectetur ex id incidunt minima molestias natus ratione. Deleniti eos, eveniet harum ipsa quis quisquam reprehenderit.</p>
                        </div>


                    </div>
                    <div class="card-footer footer-design d-flex align-items-center">
                        <input type="text" placeholder="Aa" class="input-text" v-model="message" @keypress.enter="submit" @input="sound">
                        <button class="button" @click="submit">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, ref, onMounted} from "vue"
    let props = defineProps({
        name:''
    })


    let message = ref('');

    let submit = () =>{
        if(message.value.length > 0){
            axios.post('/chat/send', {data: {message:message.value, file:[], name:'jugol kumar', id:1, is_notify:true}}).then((res) =>{
                message.value = ''
                new Audio("./audio/message-1.mp3").play();

                window.Echo.channel('chat').listen('ChatEvent', ({res})=>{
                    // new Audio("./audio/message-1.mp3").play();
                    console.log("call hrere");
                    console.log(res)
                })

            }).catch((err) =>{
                alert(err)
            })
        }
    }

    let sound = (e) =>{
        if(e.target.value.length === 1){
            new Audio("./audio/typing.mp3").play();
        }
    }

    var pusher = new Pusher('c5bc4306fdf4745ed09d', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('chat');
    channel.bind('ChatEvent', function(data) {
        alert("ok")
        console.log(data)
    });


</script>




<style scoped>
    .card-body{
        height: calc(100vh - 15rem);
        overflow-y: scroll;
    }
    .chat-item img{
        width: 50px;
        height:50px;
        margin-right: 20px;
    }
    .chat-content{
        margin: 0;
        background: #d7d7d79c;
        border-radius: 27px;
        padding: 11px 16px;
        font-size: 12px;
        max-width: 50%;
        color: #282424;
    }
    .input-text{
        width: 100%;
        border: none;
        padding: 9px 18px;
        border-radius: 50px;
        font-size: 17px;
        background: #d7d7d79c;
    }
    .footer-design{
        border-top: none;
        background: transparent;
    }

    .footer-design .button{
        padding: 11px 13px;
        border: none;
        color: #a59e9e;
        display: flex;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
        background: transparent;
    }
    .footer-design .button:hover{
        background: #e7e7e7;
    }
    .footer-design .button svg{
        margin-left: -3px;
        transform: rotate(45deg);
    }

</style>
