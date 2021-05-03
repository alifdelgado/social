<template>
    <button @click="toggle()" :class="getBtnClasses">
        <i :class="getIconClasses"></i>
        {{ getText }}
    </button>
</template>
<script>
    export default {
        props: {
            model: {
                type: Object,
                required: true
            },
            url: {
                type: String,
                required: true
            }
        },
        methods: {
            toggle() {
                let method = this.model.is_liked ? 'delete' : 'post';
                axios[method](`/${this.url}/${this.model.id}/likes`).then(response => {
                    this.model.is_liked = !this.model.is_liked;
                    if(method==='delete') {
                        this.model.likes_count--;
                    } else {
                        this.model.likes_count++;
                    }
                }).catch(error => console.log(error.response.data));
            }
        },
        computed: {
            getText() {
                return this.model.is_liked ? 'Te gusta' : 'Me gusta';
            },
            getBtnClasses() {
                return [
                    this.model.is_liked ? 'font-weight-bold' : '',
                    'btn', 'btn-light', 'text-primary'
                ]
            },
            getIconClasses() {
                return [
                    this.model.is_liked ? 'fas' : 'far',
                    'fa-thumbs-up'
                ]
            }
        }
    }
</script>
<style lang="scss" scoped>
    button {
        font-size: 0.9em;
        &:hover,
        &:focus {
            background: transparent;
            border: 0px transparent;
        }
        i {
            padding-left:0px;
        }
    }
</style>
