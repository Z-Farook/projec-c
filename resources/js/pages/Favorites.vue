<template>
    <div class="container">
        <h4 class="search-category accent-color">Favorieten</h4>
        <div v-if="favorites.length > 0">
            <div class="search-item" v-for="f in favorites" v-bind:key="f.id">
                <router-link :to="{name: 'movie', params: {id: f.movie_id}}">
                    <img :src="movie(f.movie_id).thumbnail_img" width="40px;">
                    {{movie(f.movie_id).title + ' (' + movie(f.movie_id).releaseDate.slice(0,4) + ')'}}
                </router-link>
                <font-awesome-icon icon="trash" class="yellow pointer"
                                   @click="toggleFavorite(f.id)">
                </font-awesome-icon>
            </div>
        </div>
        <div class="yellow" v-else>
            Nog geen films in je favorieten
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "favorites",
        computed: {
            favorites() {
                return this.$store.getters.favorites;
            }
        },
        methods: {
            movie(id) {
                return this.$store.getters.getMovieById(id);
            },
            toggleFavorite(id) {
                axios.delete('../../api/favorites/' + id)
                    .then(() => {
                        this.$store.dispatch('removeFavorite', id)
                    })
                    .catch(res => {
                        console.log(res.data);
                    })

            }
        },
        created() {
        }
    }
</script>

<style lang="scss">
    .yellow {
        color: yellow;
    }
    .pointer {
        cursor: pointer;
    }

    .search-item {
        img {
            margin: 5px 10px 5px 5px;
        }
        border-radius: 5px;
    }

    .search-item:nth-child(odd) {
        background-color: #242424;
    }

</style>