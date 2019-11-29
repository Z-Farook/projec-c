<template>
    <div>
        <home-header/>
        <!--filter-->
        <div class="wrapper">
            <div class="filter">
                <button data-toggle="collapse" data-target="#filmgenre">Filmgenre</button>
                <div id="filmgenre" class="collapse">
                    <div v-if="genres && genres.length > 0">
                        <div v-for="g in genres">
                            <label><input type="checkbox" @click="updateMovieGenre(g.id)">{{g.title}}</label>
                        </div>
                    </div>
                </div>
                </br>
                <button data-toggle="collapse" data-target="#kijkwijzerleeftijd">Kijkwijzerleeftijd</button>
                <div id="kijkwijzerleeftijd" class="collapse">
                    <div class="checkbox">
                        <label><input type="checkbox" value="0" @click="updateAgeRestriction(0)">Alle leeftijden</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="6" @click="updateAgeRestriction(6)">Vanaf 6 jaar</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="12" @click="updateAgeRestriction(12)">Vanaf 12 jaar</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="16" @click="updateAgeRestriction(16)">Vanaf 16 jaar</label>
                    </div>
                </div>
                </br>
                <button data-toggle="collapse" data-target="#releaseDates">Verschijningsjaar</button>
                <div id="releaseDates" class="collapse">
                    <div v-if="releaseDates && releaseDates.length > 0">
                        <div v-for="r in releaseDates">
                            <label><input type="checkbox" @click="updateReleaseDates(r.value)">{{r.value}}</label>
                        </div>
                    </div>
                </div>
                </br>
                <button data-toggle="collapse" data-target="#spokenLanguages">Originele gesproken taal</button>
                <div id="spokenLanguages" class="collapse">
                    <div v-if="spokenLang && spokenLang.length > 0">
                        <div v-for="s in spokenLang">
                            <label><input type="checkbox" @click="updateSpokenLanguages(s.value)">{{s.value}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <!--filter-->
            <div style="color:white;" class="searchResult">
                <form v-on:submit.prevent="onSearch()">
                    <input type="text" v-model="search" value="test" class="form-control search-input" style="width:40%;"/>
                    <div v-if="actors || movies">
                        <h4>Er zijn {{ movies.length + actors.length }} resultaten voor "{{ search }}"</h4>
                         </br>
                        <h4 class="search-category accent-color">Movie title:</h4>
                        <div v-if="movies.length > 0">
                            <div class="search-item" v-for="m in movies.slice(0,49)">
                                <router-link :to="{name: 'movie', params: {id: m.id}}">
                                    <div v-if="inFilter(m)">
                                        <img :src="m.thumbnail_img" width="40px;">
                                        {{m.title + ' (' + m.releaseDate.slice(0,4) + ')'}}
                                    </div>
                                </router-link>
                            </div>
                        </div>
                        <div v-else>Geen resultaten</div>
                        <div v-if="actors">
                             </br>
                            <h4 class="search-category accent-color">Acteur naam:</h4>
                            <div v-if="actors.length > 0">
                                <div class="search-item" v-for="a in actors.slice(0,49)">
                                    <router-link :to="{name: 'actor', params: {id: a.id}}">
                                        <div>
                                            <img :src="a.img" width="40px;">
                                            {{a.name + ' ' + a.surname}}
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                            <div v-else>Geen resultaten</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import HomeHeader from '../components/HomeHeader'

    export default {
        name: "search",
        props: ['search'],
        components: {HomeHeader},
        data() {
            return {
                filteringAgeRestriction: false,
                filteringMovieGenre: false,
                filteringMovieReleaseDates: false,
                filteringSpokenLanguages: false,
                movieGenres: [],
                releaseDatesArray: [],
                movieReleaseDates: [],
                spokenLanguagesArray: [],
                spokenLanguages: [],
                ageRestrictions: []
            }
        },
        computed: {
            notSearchPage() {
                return this.$route.name !== 'search'
            },
            actors() {
                if (this.search !== '' && this.search !== null) {
                    return this.$store.getters.getActorsByLikeName(this.search);
                } else {
                    return this.$store.getters.actors;
                }
            },
            movies() {
                if (this.search !== '' && this.search !== null) {
                    return this.$store.getters.getMoviesByLikeTitle(this.search);
                } else {
                    return this.$store.getters.movies;
                }
            },
            genres() {
                return this.$store.getters.genres;
            },
            releaseDates() {
                this.movieReleaseDates = [];
                var array = this.$store.getters.getMoviesByLikeTitle(this.search).map(item => item.releaseDate);
                for (let i = 0; i < array.length; i++) {
                    if(!this.inArray(this.movieReleaseDates,array[i].slice(0,4))){
                        this.movieReleaseDates.push({value: array[i].slice(0,4)});
                    }
                }
                return this.movieReleaseDates;
            },
            spokenLang() {
                this.spokenLanguages = [];
                var array = this.$store.getters.getMoviesByLikeTitle(this.search).map(item => item.spokenLang);
                for (let i = 0; i < array.length; i++) {
                    if(!this.inArray(this.spokenLanguages,array[i])){
                        this.spokenLanguages.push({value: array[i]});
                    }
                }
                return this.spokenLanguages;
            }
        },
        methods: {
            updateMovieGenre(genre) {
                if (this.inArray(this.movieGenres, genre)) {
                    for (let i = 0; i < this.movieGenres.length; i++) {
                        if (this.movieGenres[i].value === genre) {
                            this.movieGenres.splice(i, 1);
                        }
                    }
                }
                else {
                    this.movieGenres.push({value: genre});
                }
                this.movieGenres.length > 0 ? this.filteringMovieGenre = true : this.filteringMovieGenre = false;
            },
            updateReleaseDates(year) {
                if (this.inArray(this.releaseDatesArray, year)) {
                    for (let i = 0; i < this.releaseDatesArray.length; i++) {
                        if (this.releaseDatesArray[i].value === year) {
                            this.releaseDatesArray.splice(i, 1);
                        }
                    }
                }
                else {
                    this.releaseDatesArray.push({value: year});
                }
                this.releaseDatesArray.length > 0 ? this.filteringMovieReleaseDates = true : this.filteringMovieReleaseDates = false;
            },
            updateSpokenLanguages(lang) {
                if (this.inArray(this.spokenLanguagesArray, year)) {
                    for (let i = 0; i < this.spokenLanguagesArray.length; i++) {
                        if (this.spokenLanguagesArray[i].value === year) {
                            this.spokenLanguagesArray;
                        }
                    }
                }
                else {
                    this.spokenLanguagesArray.push({value: year});
                }
                this.spokenLanguagesArray.length > 0 ? this.filteringSpokenLanguages = true : this.filteringSpokenLanguages = false;
            },
            updateAgeRestriction(age) {
                if (this.inArray(this.ageRestrictions, age)) {
                    for (let i = 0; i < this.ageRestrictions.length; i++) {
                        if (this.ageRestrictions[i].value === age) {
                            this.ageRestrictions.splice(i, 1);
                        }
                    }
                }
                else {
                    this.ageRestrictions.push({value: age});
                }
                this.ageRestrictions.length > 0 ? this.filteringAgeRestriction = true : this.filteringAgeRestriction = false;
            },
            inFilter(m) {
                var filterAmount = 0;
                var matchesFilter = 0;
                if(this.filteringAgeRestriction) {
                    filterAmount++;
                    if(this.inArray(this.ageRestrictions, m.ageRestriction)){
                        matchesFilter++;
                    }
                }
                if(this.filteringMovieGenre){
                    filterAmount++;
                    if(this.inArrayArray(this.movieGenres, m.genres)){
                        matchesFilter++;
                    }
                }
                if(this.filteringMovieReleaseDates){
                    filterAmount++;
                    if(this.inArray(this.releaseDatesArray, m.releaseDate.slice(0,4))){
                        matchesFilter++;
                    }
                }
                if(this.filteringSpokenLanguages){
                    filterAmount++;
                    if(this.inArray(this.spokenLanguagesArray, m.spokenLang)){
                        matchesFilter++;
                    }
                }
                return filterAmount === matchesFilter;
            },
            inArray(array, value) {
                for (let i = 0; i < array.length; i++) {
                    if (array[i].value === value) {
                        return true
                    }
                }
                return false
            },
            inArrayArray(array, value) {
                for (let i = 0; i < value.length; i++) {
                    for (let j = 0; j < array.length; j++) {
                        if (array[j].value === value[i]['id']) {
                            return true
                        }
                    }
                }
                return false
            }
        }
    }
</script>

<style lang="scss">
    .filter{
        grid-column: 1 / 3;
        grid-row: 1 / 3;
        color: white;
        background-color: #242424;
    }
    
    .searchResult{
        grid-column: 3 / 11;
        grid-row: 1 / 3;
        background-color: #918f8f;
            a:link, hover, active {
                color: white;
            }

            a:visited {
                color: white;
            }
    }

    .search-input {
        margin-top: 20px;
        margin-bottom: 20px;
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