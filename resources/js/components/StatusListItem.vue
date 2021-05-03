<template>
    <div class="card my-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex mb-3">
                <img :src="status.user.avatar" :alt="status.user.name" class="rounded-circle" width="40px" height="40px">
                <div class="ml-3">
                    <h5><a :href="status.user.link" v-text="status.user.name"></a></h5>
                    <span class="small text-muted" v-text="status.ago"></span>
                </div>
            </div>
            <p class="card-text" v-text="status.body"></p>
        </div>
        <div class="card-footer p-2 d-flex justify-content-between align-items-center">
            <like-btn :model="status" :url="'statuses'" dusk="like-btn"></like-btn>
            <div class="mr-2 text-secondary">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer p-2">
            <div v-for="comment in comments" :key="comment.id" class="mb-3">
                <div class="d-flex">
                    <img :src="comment.user.avatar" :alt="comment.user.name" class="rounded mr-2" width="34px" height="34px">
                    <div class="flex-grow-1">
                        <div class="card border-0">
                            <div class="card-body py-2 text-secondary">
                                <a :href="comment.user.link" class="font-weight-bold">{{comment.user.name}}</a>
                                {{comment.body}}
                            </div>
                        </div>
                        <span dusk="comment-likes-count" class="float-right badge badge-primary badge-pill py-1 px-2 mt-2">
                            <i class="fas fa-thumbs-up"></i>
                            {{ comment.likes_count }}
                        </span>
                        <like-btn :model="comment" :url="'comments'" dusk="comment-like-btn"></like-btn>
                    </div>
                </div>
            </div>
            <form @submit.prevent="addComment" class="form-group" v-if="isAuthenticated">
                <div class="d-flex align-align-items-center">
                    <img src="https://i.picsum.photos/id/724/200/300.jpg?hmac=MwcEnqDDOgKg6U3WYPytBPH_jurNEK2_2kcknpgP6wg" :alt="currentUser.name" class="rounded float-left mr-2" width="34px" height="34px">
                    <div class="input-group">
                        <textarea name="comment" class="form-control border-0 shadow-sm" v-model="newComment" rows="1" placeholder="Escribe un comentario"></textarea>
                        <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" dusk="comment-btn">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
                comments: this.status.comments
            };
        },
        methods: {
            addComment() {
                axios.post(`/statuses/${this.status.id}/comments`, {body:this.newComment}).then(response => {
                    this.newComment = '';
                    this.comments.push(response.data.data);
                }).catch(error => console.log(error.response.data));
            }
        }
    }
</script>
