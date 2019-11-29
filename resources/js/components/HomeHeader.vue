<template>
    <div class="wrapper">
        <div class="banner-text">
            <p>de nieuwste
                <transition name="slide-fade">
                    <span class="genre_text" v-if="show">{{ items[test] }}</span>
                </transition>
                films
            </p>
        </div>
        <div class="banner"></div>
    </div>
</template>

<script>
    export default {
        name: "home-header",
        data() {
            return {
                show: true,
                test: 0,
                items: [
                    'actie',
                    'horror',
                    'komedie',
                    'drama',
                    'thriller',
                    'avontuur',
                    'misdaad',
                    'fantasy',
                    'romantische',
                    'science fiction'
                ]
            }
        },
        mounted() {
            setInterval(() => {
                this.show = !this.show;
            }, 1000);
            setInterval(() => {
                if (this.test === (this.items.length - 1)) {
                    this.test = 0;
                }
                else {
                    this.test++;
                }
            }, 2000);
        }
    }
</script>

<style lang="scss">
    .wrapper {
        background-color: black;
        margin: 0 auto;
    }

    .wrapper > div {
        padding: 1em;
    }

    .wrapper {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        grid-auto-rows: minmax(100px, auto);
    }

    .genre_text {
        display: inline-block;
        color: yellow;
    }

    .slide-fade-enter-active {
        transition: all 1s ease;
    }

    .slide-fade-leave-active {
        transition: all 1s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-enter {
        transform: translateY(10px);
        opacity: 0;
    }

    .slide-fade-leave-to {
        transform: translateY(-10px);
        opacity: 0;
    }

    .banner-text {
        color: white;
        text-align: center;
        font-size: 3.5vw;
        line-height: 300px;
        grid-column: 1 / 11;
        grid-row: 1 / 5;
    }

    .banner {
        background: #333 url("https://media.giphy.com/media/4wd7ewHjC2HUk/source.gif") no-repeat center;
        background-size: cover;
        grid-column: 1 / 11;
        grid-row: 1 / 5;
        z-index: 5;
        opacity: 0.4;
    }
</style>