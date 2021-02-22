<template>
    <div>
        <div v-if="isAuthenticated">
            <div class="form-group">
                <label for="my-input">Status</label>
                <textarea name="body" class="form-control border-0" :placeholder="`¿En que piensas ${currentUser.name}?`" v-model="body"></textarea>
            </div>
            <button type="button" class="btn btn-primary" id="create-status" @click="saveStatus()" :disable="!loading">
                <i class="fas fa-paper-plane"></i>
                Publicar
            </button>
        </div>
        <div v-else>
            <a href="/login" text="You must be authenticated"></a>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            body: '',
            loading: false
        };
    },
    methods: {
        saveStatus() {
            this.loading = true;
            axios.post(`/statuses`, {'body':this.body}).then(response => {
                EventBus.$emit('status-created', response.data.data);
                this.body = '';
            }).catch(errors => {
                console.log(errors.response.data);
            }).then(() => this.loading = false);
        }
    }
}
</script>
