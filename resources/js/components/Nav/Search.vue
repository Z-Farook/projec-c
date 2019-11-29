<template>
    <li class="nav-item dropdown">
        <form v-on:submit.prevent="onSearch()">
            <div class="input-group">
                <input type="text" placeholder="Zoeken..." v-model="search" class="form-control"
                       :class="{'active': search.length > 0 && !open}"/>
                <span class="input-group-bth">
                    <button class="btn btn-flat btn-search" :class="{'active': search.length > 0}" type="submit">
                        <font-awesome-icon icon="search"/>
                    </button>
                </span>
            </div>
        </form>
        <div class="dropdown-menu dropdown-menu-right show" v-if="actors || movies">
            Films ({{ movies.length }})
            <div v-if="movies.length > 0" class="results-container">
                <router-link v-for="m in movies.slice(0,3)"
                             el="div"
                             :key="'m' + m.id"
                             :to="{name: 'movie', params: {id: m.id}}"
                             class="dropdown-item">
                    <img :src="m.thumbnail_img" class="movie_poster">
                    {{m.title}}
                </router-link>
            </div>
            <div v-else>Geen resultaten</div>
            <div class="actors results-wrapper" v-if="actors">
                Acteurs ({{ actors.length }})
                <div v-if="actors.length > 0" class="results-container">
                    <router-link class="dropdown-item" v-for="a in actors.slice(0,6)"
                                 el="div"
                                 :key="'a' + a.id"
                                 :to="{name: 'actor', params: {id: a.id}}">
                        <img :src="a.img">
                        {{a.name + ' ' + a.surname}}
                    </router-link>
                </div>
                <div v-else>Geen resultaten</div>
            </div>
            <router-link :to="{name: 'search', params: {search: search}}" class="dropdown-item">
                Zie alle resultaten
            </router-link>
        </div>
    </li>
</template>

<script>
    import router from '../../router/index'

    export default {
        name: "search",
        data() {
            return {
                search: '',
                open: true
            }
        },
        computed: {
            actors() {
                if (this.search !== '' && this.search !== null) {
                    return this.$store.getters.getActorsByLikeName(this.search);
                } else {
                    return null
                }
            },
            movies() {
                if (this.search !== '' && this.search !== null) {
                    return this.$store.getters.getMoviesByLikeTitle(this.search);
                } else {
                    return null
                }
            }
        },
        methods: {
            onSearch() {
                const s = this.search;
                this.search = '';
                router.push({name: 'search', params: {search: s}});
            }
        }
    }
</script>

<style lang="scss" scoped>
    .btn-search {
        border-bottom-left-radius: 0;
        border-top-left-radius: 0;
        &.active {
            border-bottom-right-radius: 0;
        }
    }

    .input-group {
        input[type=text], button[type=submit] {
            background-color: #374850;
            color: rgba(255, 255, 255, 0.5);
            border: 1px solid transparent;
            &:hover {
                color: #D0D0D0;
            }
        }
        input[type=text] {
            border: 0;
            &.active {
                border-bottom-left-radius: 0;
            }
            &:focus {
                background-color: white;
                color: #212529;
                button[type=submit] {
                    background-color: white;
                }
            }
        }
    }

    .dropdown-menu {
        width: 100%;
        top: 34px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border: 0;
    }

    .dropdown-item {
        img:not(.movie_poster) {
            border-radius: 100%;
        }
        img {
            width: 30px;
        }
    }
</style>