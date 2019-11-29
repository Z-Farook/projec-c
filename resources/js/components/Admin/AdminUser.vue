<template>
  <div>
    <br>
    <!-- 
    <h3 style="color:yellow">Gebruikerstabel</h3>
    <div class="header">
      <div class="create-user">
        <button
          type="button"
          class="btn btn-warning"
          data-toggle="modal"
          data-target="#new-user-modal"
        >Voeg Gebruiker toe
          <font-awesome-icon icon="plus"/>
        </button>
      </div>
    </div>-->
    <table class="table table-striped table-hover">
      <thead>
        <tr class="bg-primary">
          <th scope="col">Naam</th>
          <th scope="col">E-mail</th>
          <th scope="col">Admin</th>
          <th scope="col">Sinds</th>
          <th scope="col">#actie</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users">
          <td>{{user.name}}</td>
          <td>{{user.email}}</td>
          <td>{{user.admin}}</td>
          <td>{{user.created_at}}</td>
          <td>
            <font-awesome-icon
              icon="pen"
              data-toggle="modal"
              data-target="#edit-user-modal"
              @click="userToEdit=user"
            />
          </td>
          <td>
            <font-awesome-icon
              icon="trash"
              data-toggle="modal"
              data-target="#delete-modal"
              @click="userToDelete=user"
            />
          </td>
        </tr>
      </tbody>
    </table>
    <!-- User Delete Modal // delete button. * [id = delete-modal] verwijst naar [data-target="#delete-modal"]  -->
    <div class="modal food" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--gives  the user Title warning when deleting -->
            <h5 class="modal-title">Verwijder {{ userToDelete.name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!--text description when deleting -->
          <div class="modal-body">
            <!-- here the description form database but how does the food description is retrieved here?  -->
            <p>weet je zeker dat "{{ userToDelete.name }}" wilt verwijderen?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="deleteUser();"
            >Ja zeker!</button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="userToDelete={}"
            >Nee!</button>
          </div>
        </div>
      </div>
    </div>

    <!--add new user-->
    <!-- <div class="modal user" id="new-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nieuwe gebruiker toevoegen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              <p>Naam</p>
              <input type="text" v-model="user.name">
            </label>
            
            <label>
              <p>E-mail</p>
              <input type="text" v-model="user.email">
            </label>
            <label>
              <p>Wachtwoord</p>
              <input type="text" v-model="user.password">
            </label>
            <label>
              <p style="color:red;">Admin ?</p>
              <input type="text" v-model="user.admin">
            </label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addNewUser" data-dismiss="modal">
              Voeg
              toe
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>-->
    <!-- can be used to eidit user-->
    <div class="modal user" id="edit-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Verwerk gebruiker</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              <p>Naam</p>
              <input type="text" v-model="userToEdit.name">
            </label>
            
            <label>
              <p>E-mail</p>
              <input type="text" v-model="userToEdit.email">
            </label>
            <!-- <label>
              <p>Wachtwoord</p>
              <input type="text" v-model="userToEdit.password">
            </label>-->
            <label>
              <p style="color:red;">Voer 1 in voor Admin en 0 voor niet</p>
              <input type="text" v-model="userToEdit.admin">
            </label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="editUser"
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
  name: "Admin-User",
  data() {
    return {
      users: [], //this is dat type of our users
      user: {}, //this used in new food model and to pull all user form db in json formate
      userToEdit: {}, // this kan be used if for edit if needed
      userToDelete: {}
    };
  },
  created() {
    let self = this;
    axios
      .get("/api/user")
      .then(res => {
        self.users = res.data;
      })
      .catch(error => {
        console.log(error);
      });
  },
  methods: {
    deleteUser() {
      console.log(
        "API aanroepen dit user te verwijderen: " + this.userToDelete.name
      );
      axios
        .delete("/api/user/" + this.userToDelete.id)
        .then(() => console.log("Deleted user"))
        .catch(() => console.log("an error has occurred"));
    },

    addNewUser() {
      console.log("Api heeft de klant:  *" + this.user.name + "* toegevoegd");
      axios
        .post("/api/user", this.user)
        .then(() => console.log("created new user"))
        .catch(() => console.log("an error has occurred"));
    },
    editUser() {
      console.log("Api heeft de klant:  *" + this.userToEdit.name);
      axios
        .put("/api/user/" + this.userToEdit.id, this.userToEdit)
        .then(() => console.log("user is Edited"))
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

