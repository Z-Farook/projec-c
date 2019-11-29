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
                    <h2 style="font-weight: bold;">1. TICKETS EN ETEN/DRINKEN KIEZEN</h2>
                    <div class="progress" style="height: 15px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--<p v-for="test in tests" @click="createPayment()">{{test}}</p>-->
                    <p>Je kunt maximaal 12 tickets bestellen, alle combinaties zijn mogelijk.</p>
                    <h4>Tickets</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">TYPE</th>
                            <th scope="col">PRIJS</th>
                            <th scope="col">AANTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Normaal</th>
                                <td>€ 10,95</td>
                                <td>
                                    <select class="form-control" v-model="normal">
                                        <option @click="limitTickets();">0</option>
                                        <option id="normal" v-for="index in normalLimit" @click="limitTickets();">{{index}}</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Senior</th>
                                <td style="width:25%;">€ 9,-</td>
                                <td style="width:25%;">
                                    <select class="form-control" v-model="senior">
                                        <option @click="limitTickets();">0</option>
                                        <option id="senior" v-for="index in seniorLimit" @click="limitTickets();">{{index}}</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4>Consumpties</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">NAAM PRODUCT</th>
                            <th scope="col">PRIJS</th>
                            <th scope="col">AANTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="food in foods">
                                <th scope="row">{{food['product_name']}}</th>
                                <td style="width:25%;">€{{food['product_price']}}</td>
                                <td style="width:25%;">
                                    <input @change="calculateSum();" class="form-control" style="width:100%;" type="number" min="0" v-model="snacks[food['id']][0]"></input>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <router-link v-if="normal > 0 || senior > 0" tag="button" class="btn btn-primary chairs" id="button" :to="{name: 'seat', params: {id: this.id, normal: normal, senior: senior, snacks: this.snacks, salad: this.potatoSalad}}">STAP 2: STOEL KIEZEN</router-link>
                    <button v-else type="button" class="btn btn-primary chairs" disabled>STAP 2: STOEL KIEZEN</button>
                </div>
            </div>
            <div class="receipt">
                <p>Je bestelling</p>
                <img :src="show['movie']['thumbnail_img']" class="movie-poster"/>
                <p>{{show['movie']['title'].toUpperCase()}}</p>
                <div v-if="sum > 0">
                    <hr style="height:1px;border:none;color:#333;background-color:#333;">
                    <p v-if="normal > 0">{{normal}} X NORMAAL € {{(this.normal * 10.95).toFixed(2)}}</p>
                    <p v-if="senior > 0">{{senior}} X SENIOR € {{(this.senior * 9).toFixed(2)}}</p>
                    <div v-for="snack in snacks">
                        <p v-if="snack[0] > 0">{{snack[0]}} X {{snack[2]}} € {{snack[0] * snack[1]}}</p>
                    </div>
                    <p v-if="(parseFloat(normal) + parseFloat(senior)) > 1">TOTAAL € {{sum}}</p>
                    <p v-else>TOTAAL € {{sum}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "order",
        props: ['id'],
        data() {
            return {
                sum: 0,
                normal: 0,
                senior: 0,
                normalLimit: 12,
                seniorLimit: 12,
                tests: [],
                potatoSalad: []
            }
        },
        methods: {
            createPayment(){
                axios.get('/test').then(response => window.location.href = response.data);
            },
            calculateSum(){
                let ticketsTotal = ((this.normal * 10.95) + (this.senior * 9)).toFixed(2);
                let snacksTotal = 0;
                for(let i = 0; i < this.snacks.length; i++){
                    if(this.snacks.includes(this.snacks[i]) && this.snacks[i][0] !== undefined){
                        snacksTotal = snacksTotal + (this.snacks[i][0] * this.snacks[i][1]);
                        if(this.snacks[i][0] > 0){
                            if(!this.inArray(this.snacks[i][3], this.snacks[i][0])){
                                this.potatoSalad.push([this.snacks[i][0],this.snacks[i][3]]);
                            }
                        }
                        else if(this.inArray(this.snacks[i][3], this.snacks[i][0])){
                            if(this.snacks[i][0] === 0){
                                var index = this.potatoSalad.indexOf([this.snacks[i][0],this.snacks[i][3]]);
                                this.potatoSalad.splice(index, 1);
                            }
                        }
                        for(let i = 0; i < this.potatoSalad.length; i++){
                            console.log((parseInt(this.potatoSalad[0]) === 0));
                            if(parseInt(this.potatoSalad[0]) === 0){
                                console.log('test');
                                this.potatoSalad.splice(i, 1);
                            }
                        }
                    }
                }
                this.sum = parseFloat(ticketsTotal) + parseFloat(snacksTotal);
                // this.sum = ticketsTotal;
            },
            inArray(key, amount){
                //console.log(amount);
                for(let i = 0; i < this.potatoSalad.length; i++){
                    if(this.potatoSalad[i][1] === key){
                        this.potatoSalad[i][0] = amount;
                        return true;
                    }
                }
                return false;
            },
            limitTickets(){
                this.seniorLimit = (12 - (parseInt(this.normal)));
                this.normalLimit = (12 - (parseInt(this.senior)));
                this.calculateSum();
            },
            isLoggedIn(){
                axios.get('/isloggedin').then(response => {
                    return response.data
                });
            }
        },
        computed: {
            show(){
                return this.$store.getters.getShowById(parseInt(this.id))
            },
            foods(){
                return this.$store.getters.foods;
            },
            snacks(){
                let tempArray = [[]];
                for(let i = 0; i < this.foods.length; i++){
                    tempArray[this.foods[i]['id']] = [0,parseFloat(this.foods[i]['product_price']),this.foods[i]['product_name'],this.foods[i]['id']];
                }
                return tempArray;
            }
        },
        mounted(){
            axios.get('/test').then(response => this.tests = response.data);
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