import Vue from "vue";
import router from "./router/index";
import store from "./store/index.js";
import axios from "axios";
import Core from "./Core";
import Search from "./components/Nav/Search";
import FavoriteNavIcon from "./components/Nav/Favorites";
import AdminMovies from "./components/admin/AdminMovies";
import AdminRooms from "./components/admin/AdminRooms";
import AdminActors from "./components/admin/AdminActors";
import AdminShows from "./components/admin/AdminShows";
import AdminDashboard from "./components/admin/AdminDashboard";

import addSomeFood from "./components/admin/addSomeFood";
import AdminUser from "./components/admin/AdminUser";

require("./font-awesome");
require("./bootstrap");

const app = new Vue({
    el: "#app",
    components: {
        Core,
        Search,
        FavoriteNavIcon,
        AdminMovies,
        AdminRooms,
        AdminActors,
        AdminShows,
        "admin-food": addSomeFood,
        AdminDashboard,
        AdminUser
    },
    router,
    store,
    created() {
        // this is define in the addsomeFood.vue file
        //get all Food data
        // let self = this;
        // axios.get('/api/foods')
        //     .then(res => {
        //         self.foods = res.data;
        //     })
        //     .catch(err => {
        //         console.log(err)
        //     })

        // Fetch all movie data
        axios
            .get("/api/movies")
            .then(res => {
                this.$store.dispatch("addMovies", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });

        // Fetch all actor data
        axios
            .get("/api/actors")
            .then(res => {
                this.$store.dispatch("addActors", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });
        
        // Fetch all show data
        axios
            .get("/api/shows")
            .then(res => {
                this.$store.dispatch("addShows", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });

        // Fetch all show data
        axios
            .get("/api/foods")
            .then(res => {
                this.$store.dispatch("addFoods", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });

        // Fetch all genre data
        axios
            .get("/api/genres")
            .then(res => {
                this.$store.dispatch("addGenres", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });
        axios
            .get("/api/bezoekers")
            .then(res => {
                this.$store.dispatch("addBezoekers", res.data).then();
            })
            .catch(err => {
                console.log(err);
            });
    }
});
