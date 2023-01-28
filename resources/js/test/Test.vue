<script>
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
export default {
    name: 'laravel-echo',
    data() {
        return {
            echo: null
        }
    },
    computed: {
        //Add computed properties
        currentUser: {
            cache: false,
            get(){ return this.$store.getters.currentUser }
        },
        notifications: {
            cache: false,
            get(){ return this.$store.getters.notifications.reverse() }
        },
        isConnected: {
            cache: false,
            get(){
                return (this.echo &&   this.echo.connector.pusher.connection.connection !== null)
            }
        },
    },
    watch: {
        currentUser: {
            handler(currentUser){
                (currentUser !== null ? this.connect() : this.disconnect())
            }
        },
        isConnected: {
            handler(isConnected){
                this.$emit('broadcasting:status', isConnected)
            }
        }
    },
    connect(){
        if(!this.echo){
            this.echo = new Echo({
                broadcaster: 'pusher',
                key: 'XXX',
                cluster: 'us2',
                encrypted: true,
                authEndpoint: 'http://localhost/broadcasting/auth',
                auth: {
                    headers: {
                        Authorization: null
                    }
                },
                //csrfToken: null,
                //namespace: 'App',
            })
            this.echo.connector.pusher.connection.bind('connected', (event) => this.connect(event))
            this.echo.connector.pusher.connection.bind('disconnected', () => this.disconnect())
        }
        this.echo.connector.pusher.config.auth.headers.Authorization = 'Bearer ' + this.currentUser.api_token
        this.echo.connector.pusher.connect()
    }
}
</script>
<template>
    <div id="laravel-echo">
        <template v-if="isConnected">
            <ul v-for="object in notifications">
                {{ object }}
            </ul>
            <button @click="disconnect">Disconnect</button>
        </template>
        <template v-else-if="currentUser">
            <button @click="connect">Connect</button>
        </template>
    </div>
</template>
