<template>
    <div class="card my-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex mb-3">
                <img src="https://i.picsum.photos/id/724/200/300.jpg?hmac=MwcEnqDDOgKg6U3WYPytBPH_jurNEK2_2kcknpgP6wg" alt="" class="rounded-circle" width="40px" height="40px">
                <div class="ml-3">
                    <h5 v-text="status.user_name"></h5>
                    <span class="small text-muted" v-text="status.ago"></span>
                </div>
            </div>
            <p class="card-text" v-text="status.body"></p>
        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">
            <like-btn :status="status"></like-btn>
            <div class="mr-2 text-secondary">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <form @submit.prevent="addComment" class="form-group">
            <textarea name="comment" class="form-control" v-model="newComment"></textarea>
            <button type="submit" class="btn btn-primary" dusk="comment-btn">Enviar</button>
        </form>
        <div v-for="comment in comments" :key="comment.id">{{comment.body}}</div>
    </div>
</template>
<script>
    import LikeBtn from './LikeBtn'
    export default {
        components: { LikeBtn },
        props: {
            status: {
                type: Object,
                required: true
            },
        },
        data() {
            return {
                newComment: '',
                comments: []
            };
        },
        methods: {
            addComment() {
                axios.post(`/statuses/${this.status.id}/comments`, {body:this.newComment}).then(response => {
                    this.newComment = '';
                    this.comments.push(response.data.data);
                }).catch(error => console.log(error));
            }
        }
    }
</script>
