<template>
    <div>
        <!-- watch this from 7 -8th min at: https://www.youtube.com/watch?v=Zflo2-s4768&list=PL4cUxeGkcC9gQcYgjhBoeQH7wiAyZNrYa&index=40 -->
        <router-view></router-view>
        <app-footer></app-footer>
    </div>
</template>

<script>
    import AppFooter from './components/AppFooter'
    export default {
        name: "core",
        components: {AppFooter},
        props: ['user'],
        created() {
            // Add the user to the store, so every component can access it
            this.$store.dispatch('addUser', this._user)
                .then();

            if(this.$store.state.user){
                axios.get("/api/favorites/" + this.$store.state.user.id)
                    .then(res => {
                        this.$store.dispatch("addFavorites", res.data)
                    })
                    .catch(err => {
                        console.log("!Error", err);
                    })
            }
        },
        computed: {
            _user() {
                if(this.user) {
                    return JSON.parse(this.user)
                } else {
                    return null
                }
            }
        }
    }
</script>

<style>

</style>