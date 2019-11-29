<template>
    <div v-if="actor">
        <div class="content-wrapper">
            <div class="container">
                <div class="general-actor-info">
                    <div class="general-info-main">
                        <img :src="actor.img" class="actor-image" width="200" height="200"/>
                        <div class="actor-info">
                            <h1 class="actor-name">{{ actor.name + " " + actor.surname}}</h1>
                            <hr width="350px" color="yellow">
                            <div class="actor-bday">Datum en tijd van geboorte: {{ actor.birthDate }}</div>
                            <div class="actor-country">Land van geboorte: {{ actor.country }}</div>
                        </div>
                    </div>
                </div>
                <div class="actor-movies-info">
                    <h2 class="title">Speelt in deze film(s):</h2>
                    <div class="actor-movies-wrapper">
                        <div class="actor-movie" v-for="m in actor.movies.slice(0, moviesLoaded)">
                            <div class="left">
                                <img class="movie-thumbnail" :src="m.movie.thumbnail_img">
                                <div class="movie-title">{{ m.movie.title }}
                                    <div class="movie_reviews">
                                    <font-awesome-icon icon="star" v-for="i in 5" :key="'key' + i"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button v-if="actor.movies.length > 5" @click="loadMoreMovies()">
                        {{ moreMovies ? 'Laad minder' : 'Laad meer' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template> 

<script>
export default {
        name: "actor",
        props: ['id'],
        data() {
            return {
                moreActors: false
            }
        },
        computed: 
        {
            actor() 
            {
                return this.$store.getters.getActorById(parseInt(this.id))
            },
            moviesLoaded() {
                return this.moreMovies ? this.actor.movies.length : 5;
            }
        },
        methods: {
            loadMoreMovies() {
                this.moreMovies ? this.moreMovies = false : this.moreMovies = true;
            },
        }
}
</script>

<style lang="scss">
    .content-wrapper {
        background-color: #918f8f;
        color: yellow;
        
        .container {
            z-index: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
            .actor-image{
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-top: 80px;
            }
            h1{
                font-family: myFirstFont;
            }
            .general-actor-info {
                height: 600px;
                background-image: url("https://image.freepik.com/vrije-photo/schijnwerper-schijnt-naar-beneden-in-een-interieur-van-de-grunge_1048-6921.jpg");
                background-color: #918f8f;
                background-repeat: no-repeat;
                background-position: center;
                text-align: center;
                display: flex;
                flex-direction: column;
                &-main {
                    display: flex;
                }
                &-footer {
                    display: flex;
                    justify-content: space-between;
                }
            }
            .actor-movies-info {
                margin-top: 80px;
                margin-bottom: 20px;
                .actor-movies-wrapper {
                    padding: 10px;
                    .actor-movie {
                        display: flex;
                        margin-bottom: 10px;
                        .movie-thumbnail {
                            width: 100px;
                            height: 120px;
                            margin-right: 10px;
                            vertical-align: middle;
                        }
                        .left, .right {
                            width: 50%;
                            display: flex;
                        }
                        .right {
                            justify-content: space-between;
                        }
                    }
                }
            }
        }
    }

</style>
