<template>
    </div>
        <div class="wrapper">
            <div class="title">
                </br>
                </br>
                <p class="maintext">TICKETS: {{show['movie']['title'].toUpperCase()}}</p>
                <h4 class="subtext">{{show['startTime']}} VUE WIJNHAVEN {{show['room']['name'].toUpperCase()}}</h4>
            </div>
            <div class="title-background"></div>
            <div class="tickets">
                <div class ="container">
                    </br>
                    <h2 style="font-weight: bold;">2. STOELEN SELECTEREN</h2>
                    <div class="progress" style="height: 15px;">
                        <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p style="top:20px;position:relative;">Voor deze voorstelling kan je zelf stoelen kiezen. Selecteer je stoelen door met de muis op de gewenste stoelen te klikken. </p>
                    <img src="https://www.pathe.nl/assets/img/seatselector/background.png" style="top:100px;width:50%;left:25%;position:relative;">
                    <div v-for="row in rows" class="seats" style="position:relative;left:35%;top:-100px;">
                        <div v-for="seat in row">
                            <img v-if="!isReserved(seat)" :id="seat"  style="width: 20px;float:left;" src="https://www.pathe.nl/assets/img/seatselector/seat-available.svg" v-on:mouseover="mouseOver($event)" v-on:mouseleave="mouseLeave($event)" v-on:click="registerSeat($event)">
                            <img v-else style="width: 20px;float:left;" src="https://www.pathe.nl/assets/img/seatselector/seat-occupied.svg">
                        </div>
                        </br>
                    </div>
                    </br>
                    <div style="top:50px;position:relative;"><img style="width: 20px;" src="https://www.pathe.nl/assets/img/seatselector/seat-selected.svg"> Je selectie</div>
                    <div style="top:50px;position:relative;"><img style="width: 20px;" src="https://www.pathe.nl/assets/img/seatselector/seat-occupied.svg"> Bezet</div>
                    <div style="top:50px;position:relative;"><img style="width: 20px;" src="https://www.pathe.nl/assets/img/seatselector/seat-available.svg"> Beschikbaar</div>
                    <!--<p v-for="test in tests" @click="createPayment()">{{test}}</p>-->
                    </br>
                    <router-link v-if="difference === 0" tag="button" class="btn btn-primary chairs" style="margin:20px;" id="button" :to="{name: 'summary', params: {id: this.id, normal: normal, senior: senior, seats: selectedSeats, snacks: this.snacks, salad: this.salad}}">STAP 3: BESTELLING</router-link>
                    <button v-else type="button" class="btn btn-primary chairs" disabled>STAP 3: BESTELLING</button>
                </div>
            </div>
            <div class="receipt">
                <p>Je bestelling {{difference}}</p>
                <img :src="show['movie']['thumbnail_img']" class="movie-poster"/>
                <p>{{show['movie']['title'].toUpperCase()}}</p>
                    <hr style="height:1px;border:none;color:#333;background-color:#333;">
                    <p v-if="normal > 0">{{normal}} X NORMAAL € {{(this.normal * 10.95).toFixed(2)}}</p>
                    <p v-if="senior > 0">{{senior}} X NORMAAL € {{(this.senior * 9).toFixed(2)}}</p>
                    <div v-for="snack in snacks">
                        <p v-if="snack[0] > 0">{{snack[0]}} X {{snack[2]}} € {{snack[0] * snack[1]}}</p>
                    </div>
                    <p v-if="(parseFloat(normal) + parseFloat(senior)) > 1">TOTAAL € {{sum}}</p>
                    <p v-else>TOTAAL {{parseInt(normal) + parseInt(senior)}} TICKET € {{sum}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "seat",
        props: ['id', 'normal', 'senior', 'snacks', 'salad'],
        data() {
            return {
                sum: 0,
                limit: 12,
                chosenSeats: 0,
                maxSeats: 0,
                selectedSeats: [],
                reservedSeats: [],
                seats: []
            }
        },
        methods: {
            mouseOver: function (event){
                if(!this.inArray(event.target.id)){
                    document.getElementById(event.target.id).src="https://www.pathe.nl/assets/img/seatselector/seat-selected.svg";
                }
            },
            mouseLeave: function (event){
                if(!this.inArray(event.target.id)){
                    document.getElementById(event.target.id).src="https://www.pathe.nl/assets/img/seatselector/seat-available.svg";
                }
            },
            registerSeat: function (event){
                if(!this.inArray(event.target.id)){
                    this.selectedSeats.push(event.target.id)
                    document.getElementById(event.target.id).src="https://www.pathe.nl/assets/img/seatselector/seat-selected.svg";
                    this.chosenSeats++;
                }
                else{
                    this.selectedSeats.splice(this.selectedSeats.indexOf(event.target.id),1);
                    document.getElementById(event.target.id).src="https://www.pathe.nl/assets/img/seatselector/seat-available.svg";
                    this.chosenSeats = this.chosenSeats - 1;
                }
                //console.log(this.chosenSeats);
                console.log(this.selectedSeats);
            },
            isReserved (seat){
                return this.reservedSeats.includes(seat);
            },
            inArray(value) {
                for (let i = 0; i < this.selectedSeats.length; i++) {
                    if (this.selectedSeats[i] === value) {
                        return true
                    }
                }
                return false
            },
            getSeats(){
                axios.get('/getseats', { params: { room_id: this.show['room_id']} }).then(response => 
                    this.seats = response.data
                );
            },
            getReservedSeats(){
                axios.get('/getreservedseats', { params: { show: this.id} }).then(response => 
                    this.reservedSeats = response.data
                );
            },
            calculateSum(){
                let ticketsTotal = ((this.normal * 10.95) + (this.senior * 9)).toFixed(2);
                let snacksTotal = 0;
                for(let i = 0; i < this.snacks.length; i++){
                    if(this.snacks.includes(this.snacks[i]) && this.snacks[i][0] !== undefined){
                        snacksTotal = snacksTotal + (this.snacks[i][0] * this.snacks[i][1]);
                    }
                }
                this.sum = parseFloat(ticketsTotal) + parseFloat(snacksTotal);
            },
            uniq(a) {
                var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

                return a.filter(function(item) {
                    var type = typeof item;
                    if(type in prims)
                        return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
                    else
                        return objs.indexOf(item) >= 0 ? false : objs.push(item);
                });
            },
            //limitTickets(){
            //    this.limit = (12 - (parseInt(this.normal) + parseInt(this.senior)));
            //    this.calculateSum();
            //}
        },
        computed: {
            rows () {
                let row = 0;
                let lastSeat = 0;
                let tempArray = [[]];
                for(let i = 0; i < this.seats.length; i++){
                    if(row !== this.seats[i]['row']){
                        row = this.seats[i]['row'];
                        tempArray[row] = [this.seats[i]['id']];
                    }
                    tempArray[row].push(this.seats[i]['id']);
                }
                for(let i = 0; i < tempArray.length; i++){
                    tempArray[i] = tempArray[i].filter(function(item, pos, self) {
                        return self.indexOf(item) == pos;
                    })
                }
                return tempArray;
            },
            show(){
                return this.$store.getters.getShowById(parseInt(this.id))
            },
            difference(){
                return (parseInt(this.normal) + parseInt(this.senior)) - this.selectedSeats.length;
            },
            // reserved () {
            //     axios.get('/getreservedseats', { params: { show: 1 } }).then(response => {
            //         this.reservedSeats = response.data
            //     });
            // }
        },
        mounted(){
            this.calculateSum();
            this.getSeats();
            this.getReservedSeats();
            this.maxSeats = (parseInt(this.normal) + parseInt(this.senior));
        }
    }
</script>

<style lang="scss">
    .wrapper {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        grid-auto-rows: minmax(100px, auto);
        background-color: #f5f5f5;
    }
    .title{
        grid-column: 3 / 11;
        grid-row: 1 / 3;
        color: #ffc426;
        font-family: "Trade Gothic Bold Condensed 20",Arial,Helvetica,sans-serif;
        background-color: #4f4e4e;
    }
    .title-background{
        grid-column: 1 / 11;
        grid-row: 1 / 3;
        background-color: #4f4e4e;
    }
    .tickets{
        grid-column: 3 / 7;
        grid-row: 3 / 5;
        color: black;
        background-color: #f5f5f5;
    }
    .receipt{
        grid-column: 7 / 9;
        grid-row: 3 / 5;
        color: black;
        background-color: white;
    }
    .maintext{
        position: relative;
        font-size: 40px;
        font-weight: bold;
        margin: 10px;
    }
    .subtext{
        position: relative;
        font-size: 15px;
        bottom: 20px;
        color: grey;
        font-weight: bold;
        margin: 10px;
    }
    .chairs{
        float: right;
        margin: 20px;
    }
</style>