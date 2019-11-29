<template>
  <div>
    <br>
    <br>
    <h1>Snack- en drankmenu</h1>
    <br>
    <table>
      <th>Foto</th>
      <th>Naam</th>
      <th>Prijs</th>
      <tr v-for="food in foods" :key="food.id">
        <td>
          <img width="100" :src="food.productPic">
        </td>
        <td>{{ food.product_name }}</td>
        <td>€{{ food.product_price }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "food",
  data() {
    return {
      foods: []
    };
  },
  created() {
    axios.get("../../api/foods").then(res => {
      this.foods = res.data;
    });
  }
};
</script>

<style>
table,
td,
th {
  background-color: yellow;
  margin: 25px 50px 75px 300px;
  border-collapse: collapse;
  border: 1px solid black;
  font-size: larger;
  color: red;
}

table td {
  border: 1px solid black;
  padding: 5px;
}
h1 {
  color: yellow;
  text-align: center;
}
</style>