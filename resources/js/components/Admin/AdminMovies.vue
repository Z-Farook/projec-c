<template>
  <div>
    <div class="header">
      <h3>Movies</h3>
      <div class="create-movie">
        <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#new-movie-modal"
        >Nieuwe film
          <font-awesome-icon icon="plus"/>
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
      <tr>
        <th scope="col">Titel</th>
        <th scope="col"># Acteurs</th>
        <th scope="col">Release Date</th>
        <th scope="col">Taal</th>
        <th scope="col">Regisseur</th>
        <th scope="col">Acties</th>
      </tr>
      </thead>
      <tbody>
      <!-- movies warped in Variable * movie -->
      <tr v-for="movie in movies">
        <th>{{ movie.title }}</th>
        <td>{{ movie.actors.length }}</td>
        <td>{{ movie.releaseDate }}</td>
        <td>{{ movie.spokenLang }}</td>
        <td>{{ movie.director }}</td>
        <td>
          <font-awesome-icon
                  icon="pen"
                  data-toggle="modal"
                  data-target="#edit-movie-modal"
                  @click="movieToEdit = movie"
          />
          <font-awesome-icon
                  icon="trash"
                  data-toggle="modal"
                  data-target="#delete-modal"
                  @click="deleteMovieModal(movie)"
          />
        </td>
      </tr>
      </tbody>
    </table>

    <!-- Movie Delete Modal // delete button -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ modal.title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- how does the movie description is retrieved here  -->
            <p>{{ modal.description }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="modal.action()">Ja zeker!</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Oh nee toch niet!</button>
          </div>
        </div>
      </div>
    </div>

    <!--New Movie Modal-->
    <div class="modal fade" id="new-movie-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nieuwe film toevoegen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Title
              <input type="text" v-model="movie.title">
            </label>
            <label>
              Description
              <textarea v-model="movie.description"/>
            </label>
            <label>
              Release Date
              <input v-model="movie.releaseDate">
            </label>
            <label>
              Taal
              <input v-model="movie.spokenLang">
            </label>
            <label>
              Leeftijdsgrens
              <input v-model.integer="movie.ageRestriction">
            </label>
            <label>
              Trailer link
              <input v-model="movie.trailerLink">
            </label>
            <label>
              Duur
              <input v-model="movie.duration">
            </label>
            <label>
              Regisseur
              <input v-model="movie.director">
            </label>
            <label>
              Header Afbeelding
              <input v-model="movie.header_img">
            </label>
            <label>
              Thumbnail Afbeelding
              <input v-model="movie.thumbnail_img">
            </label>
          </div>
          <div class="modal-footer">
            <button
                    type="button"
                    class="btn btn-primary"
                    @click="addNewMovie"
                    data-dismiss="modal"
            >Voeg toe</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- edit Movie Modal-->
    <div class="modal fade" id="edit-movie-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Film verwerken</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Title
              <input type="text" v-model="movieToEdit.title">
            </label>
            <label>
              Description
              <textarea v-model="movieToEdit.description"/>
            </label>
            <label>
              Release Date
              <input v-model="movieToEdit.releaseDate">
            </label>
            <label>
              Taal
              <input v-model="movieToEdit.spokenLang">
            </label>
            <label>
              Leeftijdsgrens
              <input v-model.integer="movieToEdit.ageRestriction">
            </label>
            <label>
              Trailer link
              <input v-model="movieToEdit.trailerLink">
            </label>
            <label>
              Duur
              <input v-model="movieToEdit.duration">
            </label>
            <label>
              Regisseur
              <input v-model="movieToEdit.director">
            </label>
            <label>
              Header Afbeelding
              <input v-model="movieToEdit.header_img">
            </label>
            <label>
              Thumbnail Afbeelding
              <input v-model="movieToEdit.thumbnail_img">
            </label>
          </div>
          <div class="modal-footer">
            <button
                    type="button"
                    class="btn btn-primary"
                    @click="editMovie"
                    data-dismiss="modal"
            >Verwerk</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import axios from "axios";
    export default {
        name: "admin-movies",
        data() {
            return {
                modal: {
                    title: "",
                    description: "",
                    action: () => console.log("it works")
                },
                movie: {},
                movieToEdit: {}
            };
        },
        computed: {
            movies() {
                return this.$store.getters.movies;
            }
        },
        methods: {
            // it will delete all movies via  <tr v-for="movie in movies">
            deleteMovieModal(movie) {
                this.modal.title = movie.title;
                this.modal.description = movie.description;
                this.modal.action = () =>
                    axios
                        .delete(`../../api/movies/${movie.id}`)
                        .then(() => console.log(`deleted movie with id: ${movie.id}`))
                        .catch(() => console.log(`oops something went wrong`));
            },
            addNewMovie() {
                axios
                    .post("../../api/movies", this.movie)
                    .then(() => console.log("created new movie"))
                    .catch(() => console.log("an error has occurred"));
            },
            editMovie() {
                console.log("API aanroepen dit Movie te verwerken: " + this.movieToEdit);
                axios
                    .put("/api/movies/" + this.movieToEdit.id, this.movieToEdit)
                    .then(() => console.log("movie is Edited?"))
                    .catch(() => console.log("an error has occurred"));
            }
        }
    };
</script>

<style>
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .modal {
    color: black !important;
  }
  .modal-body {
    display: flex;
    flex-direction: column;
  }
</style>