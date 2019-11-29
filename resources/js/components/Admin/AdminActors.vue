<template>
  <div>
    <div class="header">
      <h3>Acteurs</h3>
      <div class="create-actor">
        <button
          type="button"
          class="btn btn-primary"
          data-toggle="modal"
          data-target="#new-actor-modal"
        >Nieuwe acteur
          <font-awesome-icon icon="plus"/>
        </button>
      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">Naam</th>
          <th scope="col">Geboortedag</th>
          <th scope="col">Geslacht</th>
          <th scope="col">Nationaliteit</th>
         <th scope="col">Acties</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="actor in actors" :key="actor.id">
          <th>{{ actor.name }} {{ actor.insertion }} {{ actor.surname }}</th>
          <td>{{ actor.birthDate }}</td>
          <td>{{ actor.gender }}</td>
          <td>{{ actor.country }}</td>
          <!-- <td>{{ actor.movies.length }}</td> -->
          <td>
            <font-awesome-icon
              icon="pen"
              data-toggle="modal"
              data-target="#edit-modal"
              @click="actorToEdit= actor"
            />
            <font-awesome-icon
              icon="trash"
              data-toggle="modal"
              data-target="#delete-modal"
              @click="deleteActorModal(actor)"
            />
          </td>
        </tr>
      </tbody>
    </table>

    <!--Actor Delete Modal-->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Weet u zeker dat u de acteur hieronder wilt verwijderen?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>"{{ modal.title}}"</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="modal.action()">Ja</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nee</button>
          </div>
        </div>
      </div>
    </div>

    <!--New actor Modal-->
    <div class="modal fade" id="new-actor-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nieuwe Acteur toevoegen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Naam
              <input type="text" v-model="actor.name">
            </label>
            <label>
              Tussenvoegsel
              <input type="text" v-model="actor.insertion">
            </label>
            <label>
              Achternaam
              <input type="text" v-model="actor.surname">
            </label>
            <label>
              Geslacht
              <input type="text" v-model="actor.gender">
            </label>
            <label>
              Geboorteland
              <input type="text" v-model="actor.country">
            </label>

            <date-picker
              v-model="actor.birthDate"
              type="datetime"
              format="YYYY-MM-DD"
              placeholder="Geboortedatum"
              lang="nl"
            />
            <label>
              Afbeelding
              <input type="text" v-model="actor.img">
            </label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="addNewActor"
              data-dismiss="modal"
            >Voeg toe</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
    <!--Edit actor Modal-->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Verwerk Acteur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              Naam
              <input type="text" v-model="actorToEdit.name">
            </label>
            <label>
              Tussenvoegsel
              <input type="text" v-model="actorToEdit.insertion">
            </label>
            <label>
              Achternaam
              <input type="text" v-model="actorToEdit.surname">
            </label>
            <label>
              Geslacht
              <input type="text" v-model="actorToEdit.gender">
            </label>
            <label>
              Geboorteland
              <input type="text" v-model="actorToEdit.country">
            </label>

            <date-picker
              v-model="actor.birthDate"
              type="datetime"
              format="YYYY-MM-DD"
              placeholder="Geboortedatum"
              lang="nl"
            />
            <label>
              Afbeelding
              <input type="text" v-model="actorToEdit.img">
            </label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="editActor"
              data-dismiss="modal"
            >Voeg toe</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import DatePicker from "vue2-datepicker";

export default {
  name: "admin-actors",
  components: { DatePicker },
  data() {
    return {
      modal: {
        title: "",
        description: "",
        action: () => console.log("test")
      },
      actor: {
        name: "",
        insertion: "",
        surname: "",
        country: "",
        birthDate: new Date(),
        img: ""
      },
      actorToEdit: {}
    };
  },
  computed: {
    actors() {
      return this.$store.getters.actors;
    }
  },
  methods: {
    deleteActorModal(actor) {
      this.modal.title = actor.name;
      this.modal.description = actor.description;
      this.modal.action = () =>
        axios
          .delete(`../../api/actors/${actor.id}`)
          .then(() => {
            console.log(`deleted actor with id: ${actor.id}`);
            this.getActors();
          })
          .catch(() => console.log(`oops something went wrong`));
    },
    addNewActor() {
      let actor = this.actor;
      actor.birthDate = moment(actor.birthDate).format("YYYY-MM-DD HH:mm:ss");
      axios
        .post("../../api/actors", actor)
        .then(() => {
          console.log("created new actor");
          this.getActors();
        })
        .catch(() => console.log("an error has occurred"));
    },

    editActor() {
      console.log("API aanroepen dit Actor te verwerken: " + this.actorToEdit);
      axios
        .put("../../api/actors/" + this.actorToEdit.id, this.actorToEdit)
        .then(() => console.log("actor is Edited"))
        .catch(() => console.log("an error has occurred"));
    },
    getActors() {
      axios
        .get("../../api/actors")
        .then(res => {
          this.$store.dispatch("addActors", res.data).then();
        })
        .catch(err => console.log(err));
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