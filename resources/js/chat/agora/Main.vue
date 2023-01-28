<script setup>
import AgoraRTM from 'agora-rtm-sdk';
import { v4 as uuidv4 } from 'uuid';
import { ref, onMounted, nextTick, defineExpose } from 'vue';

const APP_ID = 'd9bf4bff067941769339d66eb61ecd58';
const CHANNEL = 'wdj';
let client = AgoraRTM.createInstance(APP_ID);
let uid = uuidv4();
let channel;

onMounted(async () => {
    // await client.login({ uid, token: null });
    // channel = await client.createChannel(CHANNEL);
    // await channel.join();


    client.login({ token: null, uid: uid.toString() }).then(function () {
        console.log('AgoraRTM client login success');
    }).catch(function (err) {
        console.log('AgoraRTM client login failure', err);
    });

});



</script>






<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        message
                    </div>
                    <div class="card-footer footer-design d-flex align-items-center">
                        <input type="text" v-model="message" placeholder="Aa" class="input-text" @input="typing"  @keyup.enter="send">
                        <button class="button" @click="send">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


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
