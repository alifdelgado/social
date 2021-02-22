let user = document.querySelector('meta[name="user"]');
module.exports = {
    computed: {
        currentUser(){
            return JSON.parse(user.content);
        },
        isAuthenticated() {
            return !! user.content;
        },
        guest() {
            return ! this.isAuthenticated;
        }
    },
    methods: {
        redirectIfGuest() {
            if(this.guest) {
                window.location.href = '/login';
                return;
            }
        }
    }
};
