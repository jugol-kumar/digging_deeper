import {defineStore} from "pinia";


export let useChats = defineStore("chats", {
    state(){
        return{
            count:0
        }
    },

    actions:{
        increments(){
            this.count++;
        }
    },

    getters:{
        getRemaning(){
            return 10 - this.count;
        }
    }

})
