<template>
    <div v-if="movies">
        <h1>ACTUEEL</h1>
        <div class="card-carousel-wrapper">
            <div class="card-carousel--nav__left" @click="moveCarousel(-1)" :disabled="atHeadOfList"></div>
            <div class="card-carousel">
                <div class="card-carousel--overflow-container">
                    <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
                        <div class="card-carousel--card" v-for="movie in movies">
                            <a :href="'film/'+movie.id" ><img :src="movie.thumbnail_img"/></a>
                            <div class="card-carousel--card--footer">
                                <p>{{movie.title}}</p>
                                <p v-for="genre in movie.genres" class="genre">{{genre.title}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-carousel--nav__right" @click="moveCarousel(1)" :disabled="atEndOfList"></div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        template: "movie-carousel",
        data() {
            return {
                currentOffset: 0,
                windowSize: 4,
                paginationFactor: 215,
                movies: []
            }
        },
        created () {
            this.getMovieData();
        },
        computed: {
            atEndOfList() {
                return this.currentOffset <= (this.paginationFactor * -1) * (this.movies.length - this.windowSize);
            },
            atHeadOfList() {
                return this.currentOffset === 0;
            },
        },
        methods: {
            moveCarousel(direction) {
                if (direction === 1 && !this.atEndOfList) {
                    this.currentOffset -= this.paginationFactor;
                } else if (direction === -1 && !this.atHeadOfList) {
                    this.currentOffset += this.paginationFactor;
                }
            },
            getMovieData() {
                axios.get('/api/movies')
                    .then(res => {
                        this.movies = res.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>

<style lang="scss">
    $vue-navy: #2c3e50;
    $vue-navy-light: #3a5169;
    $vue-blue: yellow;
    $vue-teal-light: #42b983;
    $gray: #666a73;
    $light-gray: #f8f8f8;
    body {
        color: $vue-navy;
        font-family: 'Hind Siliguri', sans-serif;
        min-height: 1100px;
    }
    .card-carousel-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 20px 0 40px;
        color: $gray;
    }
    .card-carousel {
        display: flex;
        justify-content: center;
        width: 870px;

        &--overflow-container {
            overflow: hidden;
        }

        &--nav__left,
        &--nav__right {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-top: 2px solid $vue-blue;
            border-right: 2px solid $vue-blue;
            cursor: pointer;
            margin: 0 10px;
            transition: transform 150ms linear;
            &[disabled] {
                opacity: 0.2;
                border-color: black;
            }
        }

        &--nav__left {
            transform: rotate(-135deg);
            &:active {
                transform: rotate(-135deg) scale(0.9);
            }
        }

        &--nav__right {
            transform: rotate(45deg);
            &:active {
                transform: rotate(45deg) scale(0.9);
            }
        }
    }
    .card-carousel-cards {
        display: flex;
        transition: transform 150ms ease-out;
        transform: translatex(0px);

        .card-carousel--card {
            margin: 0 10px;
            cursor: pointer;
            box-shadow: 0 4px 15px 0 rgba(40,44,53,.06), 0 2px 2px 0 rgba(40,44,53,.08);
            background-color: #fff;
            border-radius: 4px;
            z-index: 3;
            margin-bottom: 2px;

            &:first-child {
                margin-left: 0;
            }

            &:last-child {
                margin-right: 0;
            }

            img {
                vertical-align: bottom;
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                transition: opacity 150ms linear;

                &:hover {
                    opacity: 0.5;
                }
            }

            &--footer {
                border-top: 0;
                padding: 7px 15px;

                p {
                    padding: 3px 0;
                    margin: 0;
                    margin-bottom: 2px;
                    font-size: 19px;
                    font-weight: 500;
                    color: $vue-navy;

                    &.genre {
                        font-size: 12px;
                        font-weight: 300;
                        padding: 6px;
                        background: rgba(40,44,53,.06);
                        display: inline-block;
                        position: relative;
                        margin-left: 4px;
                        color: $gray;

                        &:before {
                            content:"";
                            float:left;
                            position:absolute;
                            top:0;
                            left: -12px;
                            width:0;
                            height:0;
                            border-color:transparent rgba(40,44,53,.06) transparent transparent;
                            border-style:solid;
                            border-width:12px 12px 12px 0;
                        }

                        &:after {
                            content:"";
                            position:absolute;
                            top:10px;
                            left:-1px;
                            float:left;
                            width:4px;
                            height:4px;
                            border-radius: 2px;
                            background: white;
                            box-shadow:-0px -0px 0px #004977;
                        }
                    }
                }
            }
        }
    }
    h1 {
        font-size: 3.6em;
        font-weight: 100;
        text-align: center;
        margin-bottom: 0;
        color: $vue-blue;
    }
</style>