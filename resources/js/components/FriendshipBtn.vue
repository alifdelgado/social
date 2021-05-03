<template>
    <button type="button" id="request-friendship" @click="sendFriendshipRequest" v-text="textBtn"></button>
</template>
<script>
    export default {
        props: {
            recipient: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                textBtn: "Send friendship request"
            }
        },
        methods: {
            sendFriendshipRequest() {
                axios.post(`friendships/${this.recipient.name}`).then(response => {
                    console.log(response.data)
                    this.textBtn = "The request have been sent";
                }).catch(error => console.log(error));
            }
        }
    }
</script>
