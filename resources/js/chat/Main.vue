<template>
    <div class="container">
        <div class="row justify-content-center match-height">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <h2>Active Users</h2>
                            <span class="badge badge-primary bg-success" @click="chats.increments">{{ chats.count }} {{ chats.getRemaning }}</span>
                        </div>
                        <ul class="nav flex-column">
                            <li class="nav-item"
                                :class="active_id === persitipens.id ? 'active' : '', isOnline(persitipens.id) ? 'online' : 'offline'"
                                v-for="persitipens in activeUsers"
                                :key="persitipens.id"
                                @click="chats.setUserById(persitipens.id), active_id = persitipens.id">{{ persitipens.name }}
                                <span class="badge bg-success" style="width: 10px; height: 10px; background: red;"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 col-sm-12">
                <div v-if="chats.getUserById  != null" class="card">
                    <div class="card-header chat-bar">
                        <div class="avatar">
                            <img class="user-active" :src="`https://i.pravatar.cc/50?u=${chats.getUserById.user.email}`" alt="">
                            <div class="d-flex align-items-start flex-column p-2">
                                <p class='mb-0 fw-bold text-capitalize'>{{ chats.getUserById.user.name }}</p>
                                <small>{{ chats.getUserById.user.email }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-body-overflow" id="cardScroll">
                        <span v-for="(item, index) in chats.getUserById.chats" :key="item.id">
                            <div v-if="item.form_id === authData.id">
                                <div class="d-flex chat-item align-items-center flex-row-reverse mb-2" >
                                    <img :src="`https://i.pravatar.cc/50?u=${item.user.email}`" alt="" class="rounded-circle" :title="item.name">
                                    <div class="d-flex flex-column align-items-end">
                                        <p class="chat-content">{{ item.message }}</p>
                                        <small class="text-warning name">~{{ item.user.name }}</small>

                                        <small v-if="is_sending && index == chats.getUserById.chats.length - 1" class="text-warning">Sending...</small>
                                        <small v-else-if="index == chats.getUserById.chats.length - 1" class="text-success">Send.</small>
                                    </div>
                                </div>

                                <img src="../../images/circle.svg" v-if="is_sending && index == chats.getUserById.chats.length - 1" class="icon"/>
                                <img src="../../images/send.svg" v-else-if="index == chats.getUserById.chats.length - 1 &&  !item.is_seen" class="icon"/>
                                <img :src="`https://i.pravatar.cc/50?u=${chats.getUserById.user.email}`" v-else-if="index == chats.getUserById.chats.length - 1 && item.is_seen" class="seen icon"/>
                            </div>
                            <div class="d-flex chat-item align-items-center mb-2" v-else>
                                <img :src="`https://i.pravatar.cc/50?u=${item.user.email}`" alt="" class="rounded-circle" :title="item.name">
                                <div class="d-flex flex-column align-items-start">
                                    <p class="chat-content">{{ item.message }}</p>
                                    <small class="text-info">~{{ item.user.name }}</small>
                                </div>
                            </div>
                        </span>

                        <span v-if="activePeer" v-text="activePeer.name+' is Typhing.'"></span>
                        <img src="../../../public/images/typing.gif" v-show="activePeer" alt="" width="50">
                    </div>
                    <div class="card-footer match- footer-design d-flex align-items-center">
                        <input type="text" v-model="msg" placeholder="Aa" class="input-text" @input="typing"  @keyup.enter="send">
                        <button class="button" @click="send">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </div>
                <div v-else class="card">
                    <div class="card-body">
                        <div class="user text-center">
                            <div class="profile">
                                <img :src="`https://i.pravatar.cc/50?u=${authData.email}`" class="img-fluid">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                                <h4 class="mb-0 text-capitalize">{{ authData.name }}</h4>
                                <span class="text-muted d-block mb-2">{{ authData.email}}</span>
                                <button class="btn btn-primary btn-sm follow">Follow</button>
                                <div class="d-flex justify-content-between align-items-center mt-4 px-4">
                                    <div class="stats">
                                        <h6 class="mb-0">Followers</h6>
                                        <span>8,797</span>
                                    </div>
                                    <div class="stats">
                                        <h6 class="mb-0">Projects</h6>
                                        <span>142</span>
                                    </div>
                                    <div class="stats">
                                        <h6 class="mb-0">Ranks</h6>
                                        <span>129</span>

                                    </div>

                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from "vue"
import {useChats} from "../stores/ChatStore";
import lodash from 'lodash';

let authData = JSON.parse(document.getElementById('chatApp').getAttribute('user'));

    let chats = useChats();
    chats.setAllUsers();
    let msg = ref('');
    let messages   = ref([]);
    // let is_typing  = ref(false);
    // let typing_msg = ref('');
    let partisipents = ref([]);
    let user = ref(null);
    let activePeer = ref(false);
    let typhingTimer = ref(false);
    let active_id = ref(null);
    let is_sending = ref(false)

    let joined_users = ref([]);

    let send = ()=>{
        if (msg.value === ""){
            return ;
        }
        is_sending.value = true;
        let sendData = {
            "name"    : "You",
            "message" : msg.value,
            "to_id"   : chats.getUserById.user.id,
            "is_me"   : true
        };

        messages.value.push(sendData)
        axios.post('/chat/chats', {sendData}).then((res) => {
            chats.setUserById(chats.getUserById.user.id)
            setTimeout(()=>{
                is_sending.value = false
            }, 3000)
        });
        msg.value = ''
    }


    onMounted(()=>{
        // Echo.channel('send-message').listen('SendMessageEvent', function (res){
        Echo.private('send-message').listen('SendMessageEvent', function (res){
            new Audio('./audio/success.mp3').play();
            chats.setUserById(res.user.id)

            // messages.value.push({
            //     "name" : res.user.name,
            //     "message" : res.message,
            //     "is_me" : false
            // })
            // typing_msg.value = '';
            // is_typing = false;
        })

        // Echo.private(`send-message`).listenForWhisper('typing', (e) => {
        //     if(e.message.length === 1){
        //         typingTimer()
        //         // typing_msg.value = `${e.name} is Typing....`;
        //         // is_typing = true;
        //         new Audio('./audio/typhing.mp3').play()
        //     }
        // });

        Echo.private(`send-message`).listenForWhisper('typing', typingTimer)


        Echo.join(`send-message`).here((users) => {
            joined_users.value = users;
            // console.log(users)
        }).joining((user) => {
            joined_users.value.push(user)
        }).leaving((user) => {
            joined_users.value.splice(partisipents.value.indexOf(user), 1)
        }).error((error) => {

        });
        scrollEnd()
    })


    let typingTimer = (e) =>{
        activePeer.value = e;
        if(e.message.length === 1) {
            new Audio('./audio/typhing.mp3').play()
        }
        if(typhingTimer)clearTimeout(typhingTimer)
        typhingTimer.value = setTimeout(()=>{
            activePeer.value = false;
        }, 3000)
    }

    let activeUsers = computed(() =>{
       return chats.getAllUsers;
    });

    let isOnline = (userId) =>{
        let data = lodash.find(joined_users.value, {'id':userId})
        return data;
    };

    let scrollEnd = () =>{
        let container = document.getElementById('cardScroll');
    }


    watch(msg,()=>{
        // Echo.channel('send-message').whisper('typing', {
        Echo.private('send-message').whisper('typing', {
            name: "Jugol Kumar",
            message: msg.value
        });
    })


</script>

<style scoped>
    .card-body-overflow{
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
    .nav li{
        padding: 10px;
        cursor: pointer;
    }
    .nav li a{
        text-decoration: none;
        color: #4a4848;
    }
    .active{
        background: #e6e6e6;
        border-left: 5px solid #5eff5e;
    }
    .active a{
        color: black;
        font-weight: bold;
    }
    .chat-bar .avatar{
        display: flex;
        align-items: center;
    }
    .chat-bar p{

    }
    .chat-bar img{
        border: 1px solid #51ff55;
        padding: 4px;
        border-radius: 50px;
    }
    .name{
        width: max-content;
    }
    .icon{
        float: right;
        margin-top: -35px;
    }
    .seen{
        width: 20px;
        border-radius: 50px;
        border: 1px solid #dfdfdf;
        padding: 2px;
    }
    .online:after{
        content: "";
        width: 8px !important;
        height: 8px;
        background: #0a53be;
        position: absolute;
        border-radius: 50px;
    }
    .offline:after{
        content: "";
        width: 8px !important;
        height: 8px;
        background: #be0a0a;
        position: absolute;
        border-radius: 50px;
    }
</style>
