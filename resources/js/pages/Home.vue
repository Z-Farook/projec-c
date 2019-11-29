<template>
    <div>
        <home-header />
        <div class="container">
            <movie-carousel />
        </div>
    </div>
</template>

<script>
    import HomeHeader from '../components/HomeHeader'
    import MovieCarousel from '../components/MovieCarousel'
    export default {
        name: "home",
        components: {HomeHeader, MovieCarousel},
        data() {
            return {

            }
        }
    }
</script>

<style>

</style>