<template>
    <button v-if="status.is_liked" @click="unlike(status)" class="btn btn-link" dusk="unlike-btn">
        <i class="fas fa-thumbs-up"></i>
        Te gusta
    </button>
    <button v-else @click="like(status)" class="btn btn-link" dusk="like-btn">
        <i class="far fa-thumbs-up"></i>
        Me gusta
    </button>
</template>
<script>
    export default {
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        methods: {
            like(status) {
                axios.post(`/statuses/${status.id}/likes`).then(response => {
                    status.is_liked = true;
                    status.likes_count++;
                }).catch(error => console.log(error.response.data));
            },
            unlike(status) {
                axios.delete(`/statuses/${status.id}/likes`).then(response => {
                    status.is_liked = false;
                    status.likes_count--;
                }).catch(error => console.log(error.response.data));
            }
        }
    }
</script>
