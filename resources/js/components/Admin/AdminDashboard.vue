<template>
  <div>
    <!-- <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Maand</th>
                    <th scope="col">Aaantal bezoekers</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="bezoeker in bezoekers">
                    <th>{{ bezoeker.maand }}</th>
                    <td>{{ bezoeker.bezoeker }}</td>
                </tr>
                </tbody>
    </table>-->
    <h1 style="color: yellow">Aantal bezoekers per maand</h1>
    <br>
    <GChart
      id="chart"
      type="ColumnChart"
      :data="chartData2"
      :options="chartOptions2"
      @ready="onChartReady"
    />
    <br>
    <h1 style="color: yellow">Aantal bestellingen per genre</h1>
    <br>
    <GChart
      id="chart"
      type="ColumnChart"
      :data="chartData1"
      :options="chartOptions1"
      @ready="onChartReady"
    />
    <br>
  </div>
</template>

<script>
import { GChart } from "vue-google-charts";
import axios from "axios";

export default {
  name: "App",
  components: {
    GChart
  },
  data() {
    return {
      modal: {
        title: "",
        description: "",
        action: () => console.log("test")
      },
      chartData1: null, // the chartData will be created once Chart is ready (needs google charts lib for this)
      chartData2: null, // the chartData will be created once Chart is ready (needs google charts lib for this)
      chartOptions1: {
        title: "Aantal bestellingen per genre"
      },
      chartOptions2: {
        title: "Aantal bezoekers per maand"
      }
    };
  },
  computed: {
    bezoekers() {
      return this.$store.getters.bezoekers;
    },
    genrebestellingen() {
      return this.$store.getters.genrebestellingen;
    }
  },
  methods: {
    onChartReady(chart, google) {
      // now we have google lib loaded. Let's create data table based using it.
      this.createDataTable(google);
    },

    createDataTable(google) {
      let jsonData = $.ajax({
        url: "'../../api/bezoekers",
        dataType: "json",
        async: false
      }).responseText;

      let jsonData2 = $.ajax({
        url: "'../../api/genrebestellingen",
        dataType: "json",
        async: false
      }).responseText;

      const data1 = new google.visualization.DataTable();
      const data2 = new google.visualization.DataTable();

      const AantalBezoekers = JSON.parse(jsonData);
      const AantalGenrebestellingen = JSON.parse(jsonData2);

      data1.addColumn("string", "genres");
      data1.addColumn("number", "Totaal bezoekers");

      data2.addColumn("string", "maanden");
      data2.addColumn("number", "Totaal bestellingen van deze genre");

      var BezoekerData = [];
      for (var index = 0; index < AantalBezoekers.length; index++) {
        BezoekerData.push([
          AantalBezoekers[index].maand,
          AantalBezoekers[index].bezoeker
        ]);
      }
      var bestellingData = [];
      for (var index = 0; index < AantalGenrebestellingen.length; index++) {
        bestellingData.push([
          AantalGenrebestellingen[index].title,
          parseInt(AantalGenrebestellingen[index].bestellingen)
        ]);
      }
      //console.log(bestellingData);
      data1.addRows(BezoekerData);
      data2.addRows(bestellingData);
      //Since the :data is reactive, we just need to update it's value

      this.chartData2 = data1;
      this.chartData1 = data2;
    }
  }
};
</script>
<style>
#chart {
  width: 1000px;
  height: 300px;
}
</style>