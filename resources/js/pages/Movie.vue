<template>
    <div v-if="movie">
        <div class="header">
            <img class="header-img" :src="movie.header_img"/>
        </div>
        <div class="content-wrapper">
            <div class="container">
                <div class="general-info">
                    <div class="general-info-main">
                        <img :src="movie.thumbnail_img" class="movie-poster"/>
                        <div class="movie-info">
                            <h1 class="movie-title">{{ movie.title }}</h1>
                            </br>
                            <div class="movie-description">{{ movie.description }}</div>
                            </br>
                            <div class="movie-director">Regisseur: {{ movie.director }}</div>
                            </br>
                            Selecteer de showtijd van deze film.
                            </br>
                            <div v-if="shows.length > 0">
                                <select id="selected" class="form-control" v-model="showDate">
                                    <option v-for="show in shows" id="showDate" :value="show['id']">{{show['startTime']}}</option>
                                </select>
                            </div>
                            
                            <div v-else>
                                <select class="form-control">
                                    <option id="showDate" >Er zijn geen tijden voor deze film beschikbaar</option>
                                </select>
                            </div>
                            <router-link v-if="shows.length > 0 && selected > 0" tag="button" class="buy-tickets-btn" :to="{name: 'ticket', params: {id: showDate }}">Koop tickets</router-link>
                            <div v-if="user">
                                <div v-if="!userReviewed">
                                </br>
                                    Laat een review achter:
                                    <div>
                                        <font-awesome-icon icon="star"
                                                           v-for="i in 5"
                                                           :key="'key' + i"
                                                           @click="review(i)"/>
                                    </div>
                                </div>
                                <div v-else>
                                    </br>
                                    Je hebt een beoordeling achtergelaten ({{userReviewed.amount}} sterren)

                                </div>
                                </br>
                                <font-awesome-icon v-if="favorite" icon="trash"
                                    @click="toggleFavorite">

                                </font-awesome-icon>

                                <font-awesome-icon v-else icon="heart"
                                                   @click="toggleFavorite">
                                </font-awesome-icon>
                            </div>
                            <div v-else>
                                Log in om een review achter te laten en toe te voegen aan favorieten!
                            </div>
                        </div>
                    </div>
                    </br></br>
                    <div class="general-info-footer">
                        </br>
                        <div class="movie-age_restriction">{{ movie.ageRestriction }}+</div>
                        <div class="movie-spoken_lang">{{ movie.spokenLang }}</div>
                        <div class="movie-time">{{ movie.duration }}</div>
                        <div class="movie_reviews">
                            Stars: {{ rated }}
                            <font-awesome-icon icon="star" v-for="i in rated" :key="'key' + i"/>
                        </div>
                    </div>
                </div>
                </br>
                </br>
                <div class="movie-trailer">
                    <iframe id="ytplayer" type="text/html" width="640" height="360"
                            :src="movie.trailerLink"
                            frameborder="0" ></iframe>
                </div>
                </br>
                <div class="movie-actors-info">
                    <h2 class="title">Acteurs</h2>
                    <div class="movie-actors-wrapper">
                        <div class="movie-actor" v-for="a in movie.actors.slice(0, actorsLoaded)">
                            <div class="left">
                                <img class="actor-img" :src="a.actor.img">
                                <div class="actor-name">{{ a.actor.name + ' ' + a.actor.surname }}</div>
                            </div>
                            <div class="right">
                                <div class="actor-as">als: {{ a.role.name }}</div>
                            </div>
                        </div>
                    </div>
                    <button v-if="movie.actors.length > 5" @click="loadMoreActors()">
                        {{ moreActors ? 'Laad minder' : 'Laad meer' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "movie",
        props: ['id'],
        data() {
            return {
                moreActors: false,
                showDate: "",
            }
        },
        computed: {
            favorite() {
                return this.$store.getters.isMovieFavorite(parseInt(this.id))
            },
            movie() {
                return this.$store.getters.getMovieById(parseInt(this.id))
            },
            user() {
                return this.$store.getters.user;
            },
            shows() {
                return this.$store.getters.getShowByMovieId(parseInt(this.id))
                //return this.$store.getters.shows.find(show => show.movie_id === parseInt(this.id));
            },
            actorsLoaded() {
                return this.moreActors ? this.movie.actors.length : 5;
            },
            comDate(){
                return this.showDate;
            },
            userReviewed() {
                if(this.user){
                    return this.movie.reviews.find(rev => rev.user_id === this.user.id);
                } else {
                    return false
                }
            },
            rated() {
                let sum = 0;
                for(let i = 0; i < this.movie.reviews.length; i++) {
                    sum += this.movie.reviews[i].amount;
                }
                return Math.ceil(sum / this.movie.reviews.length);
            },
            selected(){
                return this.showDate;
            }
        },
        methods: {
            loadMoreActors() {
                this.moreActors ? this.moreActors = false : this.moreActors = true;
            },
            review(amt) {
                let rev = {
                    amount: amt,
                    user_id: this.user.id,
                    movie_id: this.movie.id
                };
                console.log('review', rev);
                axios.post('../../api/reviews', rev)
                    .then(res => {
                        console.log(res.data);
                        this.$store.dispatch('addReview', res.data)
                            .then(() => console.log('review added to store state'));
                        console.log('successfully added review');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            toggleFavorite(){
                const fav = this.favorite;
                if(fav){
                    axios.delete('../../api/favorites/' + fav.id)
                        .then(() => {
                            this.$store.dispatch('removeFavorite', fav.id)
                        })
                        .catch(res => {
                            console.log(res.data);
                        })
                } else {
                    axios.post('../../api/favorites/' + this.user.id, {'movie_id': this.movie.id})
                        .then(res => {
                            this.$store.dispatch('addFavorite', res.data);
                        })
                }
            }
        }
    }
</script>

<style lang="scss">
    .yellow {
        color: yellow;
    }
    .header {
        width: 100vw;
        .header-img {
            width: 100%;
            z-index: -1;
        }
    }

    .content-wrapper {
        background-color: #918f8f;
        color: yellow;
        .container {
            z-index: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
            .general-info {
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
            .movie-actors-info {
                .movie-actors-wrapper {
                    padding: 10px;
                    .movie-actor {
                        display: flex;
                        margin-bottom: 10px;
                        .actor-img {
                            width: 30px;
                            height: 30px;
                            border-radius: 100%;
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