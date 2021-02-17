<template>
    <div>
        <div class="form-group">
            <label for="my-input">Status</label>
            <textarea name="body" class="form-control border-0" placeholder="¿En que piensas?" v-model="body"></textarea>
        </div>
        <button type="button" class="btn btn-primary btn-block" id="create-status" @click="saveStatus()" :disable="!loading">Guardar estado</button>
        <div v-for="status in statuses" :key="status.id" v-text="status.body"></div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            body: '',
            loading: false,
            statuses: [],
        };
    },
    methods: {
        saveStatus() {
            this.loading = true;
            axios.post(`/statuses`, {'body':this.body}).then(response => {
                this.statuses.push(response.data);
                this.body = '';
            }).catch(errors => {
                console.log(errors.response.data);
            }).then(() => this.loading = false);
        }
    }
}
</script>
