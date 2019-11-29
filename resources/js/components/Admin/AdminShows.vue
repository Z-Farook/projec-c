<template>
  <div>
    <div class="header">
      <h3>Voorstellingen</h3>
      <div class="create-actor">
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#new-show-modal"
        >Nieuwe voorstelling
          <font-awesome-icon icon="plus"/>
        </button>
      </div>
    </div>

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">Film</th>
          <th scope="col">Zaal</th>
          <th scope="col">Starttijd</th>
          <th scope="col">Acties</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="show in shows">
          <th>{{ show.id }}</th>
          <td>{{ show.movie.title }}</td>
          <td>{{ show.room.name }}</td>
          <td>{{ show.startTime }}</td>
          <td>
            <font-awesome-icon
              icon="pen"
              data-toggle="modal"
              data-target="#edit-modal"
              @click="showToEdit = show"
            />
            <font-awesome-icon
              icon="trash"
              data-toggle="modal"
              data-target="#delete-modal"
              @click="deleteShowModal(show)"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <!--edit room Modal-->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Verwerk show</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Film
              <select v-model.integer="showToEdit.movie_id">
                <option v-for="movie in movies" :value="movie.id">{{ movie.title }}</option>
              </select>
            </label>
            <label>
              Zaal
              <select v-model.integer="showToEdit.room_id">
                <option v-for="room in rooms" :value="room.id">{{ room.name }}</option>
              </select>
            </label>
            <label>Kies niewe starttijd
              <date-picker
                v-model="showToEdit.startTime"
                type="datetime"
                format="YYYY-MM-DD HH:mm:ss"
                :time-picker-options="{ start: '00:00', step: '00:30', end: '23:30' }"
                placeholder="Starttijd"
                lang="nl"
                :not-before="selectedMovie.releaseDate"
              />
            </label>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                @click="editShow"
                data-dismiss="modal"
              >Voeg toe</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--Show Delete Modal-->
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
            <p>{{ modal.description }}</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="modal.action()"
              data-dismiss="modal"
            >Ja</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
          </div>
        </div>
      </div>
    </div>

    <!--New Show Modal-->
    <div class="modal fade" id="new-show-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nieuwe voorstelling toevoegen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Film
              <select v-model="selectedMovie">
                <option v-for="movie in movies" :value="movie">{{ movie.title }}</option>
              </select>
            </label>
            <label>
              Zaal
              <select v-model.integer="show.room_id">
                <option v-for="room in rooms" :value="room.id">{{ room.name }}</option>
              </select>
            </label>
            <date-picker
              v-model="show.startTime"
              type="datetime"
              format="YYYY-MM-DD HH:mm:ss"
              :time-picker-options="{ start: '00:00', step: '00:30', end: '23:30' }"
              placeholder="Starttijd"
              lang="nl"
              :not-before="selectedMovie.releaseDate"
            />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addNewShow" data-dismiss="modal">
              Voeg
              toe
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import DatePicker from "vue2-datepicker";
import moment from "moment";
export default {
  name: "admin-shows",
  components: { DatePicker },
  data() {
    return {
      modal: {
        title: "",
        description: "",
        action: () => console.log("it works")
      },
      selectedMovie: {},
      show: {},
      rooms: [],
      shows: [],
      showToEdit: {}
    };
  },
  computed: {
    movies() {
      return this.$store.getters.movies;
    }
  },
  methods: {
    deleteShowModal(show) {
      this.modal.title =
        "Weet u zeker dat u de volgende voorstelling wilt verwijderen?";
      this.modal.description = `Film: ${show.movie.title};  Zaal: ${
        show.room.name
      };  Tijd: ${show.startTime}`;
      this.modal.action = () =>
        axios
          .delete(`../../api/shows/${show.id}`)
          .then(() => {
            console.log(`deleted show with id: ${show.id}`);
            this.getShows();
          })
          .catch(() => console.log(`oops something went wrong`));
    },
    addNewShow() {
      let show = this.show;
      show.movie_id = this.selectedMovie.id;
      show.startTime = moment(show.startTime).format("YYYY-MM-DD HH:mm:ss");
      console.log("show", show);
      axios
        .post("../../api/shows", show)
        .then(() => {
          console.log("created new show");
          this.getShows();
        })
        .catch(() => console.log("an error has occurred"));
    },
    editShow() {
      console.log("test for edit show");
      axios
        .put("/api/shows/" + this.showToEdit.id, this.showToEdit)
        .then(() =>
          console.log("Now the show is on: *" + this.showToEdit.startTime)
        )
        .catch(() => console.log("an error has occurred"));
    },
    getShows() {
      axios
        .get("../../api/shows")
        .then(res => {
          this.shows = res.data;
        })
        .catch(err => console.log(err));
    },
    getRooms() {
      axios
        .get("../../api/rooms")
        .then(res => {
          this.rooms = res.data;
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.getRooms();
    this.getShows();
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