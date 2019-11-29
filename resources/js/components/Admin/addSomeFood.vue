<template>
  <div>
    <br>
    <div class="header">
      <h3>Eten tabel</h3>
      <div class="create-food">
        <button
          type="button"
          class="btn btn-warning"
          data-toggle="modal"
          data-target="#new-food-modal"
        >Voeg product toe
          <font-awesome-icon icon="plus"/>
        </button>
      </div>
    </div>

    <table class="table table-striped table-hover">
      <thead>
        <tr class="bg-primary">
          <th scope="col">Foto link</th>
          <th scope="col">Product naam</th>
          <th scope="col">Prijs €</th>
          <th>Actie</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="food in foods" :key="food.id">
          <th>{{ food.productPic }}</th>
          <td>{{ food.product_name }}</td>
          <td>{{ food.product_price }}</td>
          <td>
            <font-awesome-icon
              icon="pen"
              data-toggle="modal"
              data-target="#edit-food-modal"
              @click="foodToEdit=food"
            />
            <font-awesome-icon
              icon="trash"
              data-toggle="modal"
              data-target="#delete-modal"
              @click="foodToDelete=food"
            />
            <!--foodToDelete  ==   food geworden!!-->
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Movie Delete Modal // delete button. * [id = delete-modal] verwijst naar [data-target="#delete-modal"]  -->
    <div class="modal food" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--gives  the food Title warning when deleting -->
            <h5 class="modal-title">Verwijder {{ foodToDelete.product_name }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!--text description when deleting -->
          <div class="modal-body">
            <!-- here the description form database but how does the food description is retrieved here?  -->
            <p>weet je zeker dat {{ foodToDelete.product_name }} wilt verwijderen?</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="deleteFood();"
            >Ja zeker!</button>
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="foodToDelete={}"
            >Nee!</button>
          </div>
        </div>
      </div>
    </div>

    <!--add new products-->
    <div class="modal food" id="new-food-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Nieuwe eten toevoegen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>
              <p>Foto</p>
              <input type="text" v-model="food.productPic">
            </label>
            
            <label>
              <p>Naam</p>
              <input type="text" v-model="food.product_name">
            </label>
            
            <label>
              <p>Prijs</p>
              <input type="text" v-model="food.product_price">
            </label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="addNewfood" data-dismiss="modal">
              Voeg
              toe
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
          </div>
        </div>
      </div>
    </div>
    <!--Edit product products-->
    <div class="modal fade" id="edit-food-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Verwerk eten</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--product_name-->
            <!--product_price&ndash;&gt;-->
            <label>
              <p>Foto link</p>
              <input type="text" v-model="foodToEdit.productPic">
            </label>
            
            <label>
              <p>Product naam</p>
              <input type="text" v-model="foodToEdit.product_name">
            </label>
            
            <label>
              <p>Prijs €</p>
              <input type="text" v-model="foodToEdit.product_price">
            </label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="editFood"
              data-dismiss="modal"
            >Veranderen</button>
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
  name: "admin-food",
  data() {
    return {
      foods: [],
      food: {},
      foodToDelete: {},
      foodToEdit: {}
    };
  },
  created() {
    let self = this;
    axios
      .get("/api/foods")
      .then(res => {
        self.foods = res.data;
      })
      .catch(err => {
        console.log(err);
      });
  },
  methods: {
    addNewfood() {
      console.log(
        "API aanroepen dit food te createn: " + this.food.product_name
      );
      axios
        .post("/api/foods", this.food)
        .then(() => console.log("created new food"))
        .catch(() => console.log("an error has occurred"));
    },
    deleteFood() {
      console.log(
        "API aanroepen dit food te verwijderen: " +
          this.foodToDelete.product_name
      );
      axios
        .delete("/api/foods/" + this.foodToDelete.id)
        .then(() => console.log("Deleted food"))
        .catch(() => console.log("an error has occurred"));
    },
    editFood() {
      console.log(
        "API aanroepen dit food te verwijderen: " + this.foodToEdit.product_name
      );
      axios
        .put("/api/foods/" + this.foodToEdit.id, this.foodToEdit)
        .then(() => console.log("food is Edited"))
        .catch(() => console.log("an error has occurred"));
    }
  }
};
</script>
<style>
/*.modal {*/
/*color: black !important;*/
/*}*/
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: yellow;
}

.modal {
  color: black !important;
}
</style>