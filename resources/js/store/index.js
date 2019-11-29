import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        movies: [],
        genres: [],
        actors: [],
        shows: [],
        foods: [],
        genrebestellingen: [],
        bezoekers: [],
        inCart: [],
        user: null,
        favorites: [],
        reservations: [],
    },
    getters: {
        movies: state => state.movies,
        actors: state => state.actors,
        shows: state => state.shows,
        foods: state => state.foods,
        genres: state => state.genres,
        favorites: state => state.favorites,
        reservations: state => state.reservations,
        isMovieFavorite: (state) => (id) => {
            return state.favorites.find(fav => fav.movie_id === id)
        },
        genrebestellingen: state => state.genrebestellingen,
        bezoekers: state => state.bezoekers,
        getBezoekerById: (state) => (id) => {
            return state.bezoekers.find(bezoeker => bezoeker.id === id)
        },
        getMovieById: (state) => (id) => {
            return state.movies.find(movie => movie.id === id)
        },
        getShowById: (state) => (id) => {
            return state.shows.find(show => show.id === id)
        },
        getShowByMovieId: (state) => (id) => {
            //return state.shows.find(show => show.movie_id === id)
            return state.shows.filter(s => {
                return s.movie_id === id
            })
        },
        getMoviesByLikeTitle: (state) => (s) => {
            return state.movies.filter(m => {
                return m.title.toLowerCase().includes(s.toLowerCase())
            })
        },
        getActorById: (state) => (id) => {
            return state.actors.find(actor => actor.id === id)
        },
        user: state => state.user,
        getActorsByLikeName: (state) => (s) => {
            return state.actors.filter(a => {
                return a.name.toLowerCase().includes(s.toLowerCase()) ||
                    a.surname.toLowerCase().includes(s.toLowerCase())
            })
        },
    },
    mutations: {
        ADD_USER(state, user) {
            state.user = user;
        },
        ADD_MOVIES(state, movies) {
            state.movies = movies
        },
        ADD_SHOWS(state, shows) {
            state.shows = shows
        },
        ADD_FOODS(state, foods) {
            state.foods = foods
        },
        ADD_GENRES(state, genres) {
            state.genres = genres
        },
        ADD_ACTORS(state, actors) {
            state.actors = actors
        },
        ADD_BESTELLINGEN(state, genrebestellingen) {
            state.genrebestellingen = genrebestellingen
        },
        ADD_BEZOEKERS(state, bezoekers) {
            state.bezoekers = bezoekers
        },
        ADD_REVIEW(state, review) {
            state.movies.find(movie => movie.id === review.movie_id).reviews.push(review);
        },
        ADD_FAVORITES(state, favorites) {
            state.favorites = favorites;
        },
        ADD_RESERVATIONS(state, reservations) {
            state.reservations = reservations;
        },
        ADD_FAVORITE(state, favorite) {
            state.favorites.push(favorite);
        },
        REMOVE_FAVORITE(state, id) {
            const index = state.favorites.indexOf(state.favorites.find(fav => fav.id === id));
            if(index > -1) {
                state.favorites.splice(index, 1);
            }
        }
    },
    actions: {
        addUser(context, user) {
            context.commit('ADD_USER', user)
        },
        addMovies(context, movies) {
            context.commit('ADD_MOVIES', movies)
        },
        addShows(context, shows) {
            context.commit('ADD_SHOWS', shows)
        },
        addFoods(context, foods) {
            context.commit('ADD_FOODS', foods)
        },
        addGenres(context, genres) {
            context.commit('ADD_GENRES', genres)
        },
        addActors(context, actors) {
            context.commit('ADD_ACTORS', actors)
        },
        addGenrebestellingen(context, genrebestellingen) {
            context.commit('ADD_BESTELLINGEN', genrebestellingen)
        },
        addBezoekers(context, bezoekers) {
            context.commit('ADD_BEZOEKERS', bezoekers)
        },
        addReview(context, review) {
            context.commit('ADD_REVIEW', review)
        },
        addFavorites(context, favorites) {
            context.commit('ADD_FAVORITES', favorites)
        },
        addReservations(context, reservations) {
            context.commit('ADD_RESERVATIONS', reservations)
        },
        addFavorite(context, favorite) {
            context.commit('ADD_FAVORITE', favorite)
        },
        removeFavorite(context, id) {
            context.commit('REMOVE_FAVORITE', id)
        }
    },
});