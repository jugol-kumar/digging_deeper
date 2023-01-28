<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-header">
<!--                        <h1>Hello Mr {{ name }}</h1>-->
                    </div>
                    <div class="card-body">

                        <span v-for="item in messages">
                            <div class="d-flex chat-item align-items-center flex-row-reverse mb-2" v-if="item.is_me">
                                <img src="../../../public/sundor.jpg" alt="" class="rounded-circle" :title="item.name">
                                <p class="chat-content">{{ item.message }}</p>
                                <small class="badge bg-light text-warning">{{ item.name }}</small>
                            </div>

                            <div class="d-flex chat-item align-items-center mb-2" v-else>
                                <img src="../../../public/sundor.jpg" alt="" class="rounded-circle" :title="item.name">
                                <div class="d-flex flex-column">
                                    <p class="chat-content mb-2">{{ item.message }}</p>
                                </div>
                                <small class="badge bg-light text-info">{{ item.name }}</small>

                            </div>
                        </span>

                        <span v-text="typing_msg"></span>
                        <img src="../../../public/images/typing.gif" v-show="is_typing" alt="" width="50">
                    </div>
                    <div class="card-footer footer-design d-flex align-items-center">
                        <input type="text" v-model="msg" placeholder="Aa" class="input-text" @input="typing"  @keyup.enter="send">
                        <button class="button" @click="send">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {watch, ref, onMounted} from "vue"
import MyMessage from "./MyMessage";
import UserMessage from "./UserMessage";

    let msg        = ref('');
    let messages   = ref([]);
    let is_typing  = ref(false);
    let typing_msg = ref('');


    console.log(messages.value)

    let send = ()=>{
        if (msg.value === ""){
            return ;
        }
        messages.value.push({
            "name" : "You",
            "message" : msg.value,
            "is_me" : true
        })
        axios.post('/chat/chats', {message:msg.value});
        msg.value = ''
    }


    onMounted(()=>{
        // Echo.channel('send-message').listen('SendMessageEvent', function (res){
        Echo.private('send-message').listen('SendMessageEvent', function (res){
            new Audio('./audio/success.mp3').play();
            messages.value.push({
                "name" : res.user.name,
                "message" : res.message,
                "is_me" : false
            })
            typing_msg.value = '';
            is_typing = false;
        })

        Echo.private(`send-message`).listenForWhisper('typing', (e) => {
            if(e.message.length === 1){
                typing_msg.value = `${e.name} is Typing....`;
                is_typing = true;
                new Audio('./audio/typhing.mp3').play()
            }
        });

        // Echo.join(`send-message`).here((users) => {
        //
        // }).joining((user) => {
        //
        // }).leaving((user) => {
        //
        // }).error((error) => {
        //
        // });



    })

    watch(msg,()=>{
        // Echo.channel('send-message').whisper('typing', {
        Echo.private('send-message').whisper('typing', {
            name: "Jugol Kumar",
            message: msg.value
        });
    })


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
        /*max-width: 50%;*/
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
