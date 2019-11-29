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
                    <h2 style="font-weight: bold;">3. BESTELLING</h2>
                    <div class="progress" style="height: 15px;">
                        <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--<p v-for="test in tests" @click="createPayment()">{{test}}</p>-->
                    </br>
                    <input v-if="validEmail" v-model="email" id="email" class="form-control is-valid" placeholder="Vul uw email in" style="width:50%;">
                    <input v-else v-model="email" id="email" class="form-control" placeholder="Vul uw email in" style="width:50%;">
                    </br>
                    Vul het emailadres in waarmee u de factuur wilt ontvangen.
                    <button v-if="validEmail && email.length > 0" type="button" class="btn btn-primary chairs" @click="createPayment()">STAP 4: AFREKENEN</button>
                    <button v-else type="button" class="btn btn-primary chairs" disabled>STAP 4: AFREKENEN</button>
                </div>
            </div>
            <div class="receipt">
                <p>Je bestelling</p>
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
        name: "summary",
        props: ['id', 'normal', 'senior', 'seats', 'snacks', 'salad'],
        data() {
            return {
                sum: 0,
                limit: 12,
                tests: [],
                email: ''
            }
        },
        methods: {
            createPayment(){
                //axios.get('/test', { params: { title: this.title, amount: this.sum, email: document.getElementById("email").value } }).then(response => window.location.href = response.data);
                axios.get('/test', { params: { title: this.show['id'], amount: this.sum.toFixed(2), email: document.getElementById("email").value, seats: this.seats, snacks: this.salad.join(',') } }).then(response => window.location.href = response.data);
                //console.log(this.snacks[0][0]);
                //console.log(this.seats);
                //console.log('tst');
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
            //limitTickets(){
            //    this.limit = (12 - (parseInt(this.normal) + parseInt(this.senior)));
            //    this.calculateSum();
            //}
        },
        computed: {
            validEmail(){
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(this.email).toLowerCase());
            },
            show(){
                return this.$store.getters.getShowById(parseInt(this.id))
            },
            ikGeefOp(){
                //let test = JSON.parse(snacks[1]);
                let object = Object.assign({}, this.snacks);
                return object;
            }
        },
        mounted(){
            this.calculateSum();
            this.title = this.title.toUpperCase();
            axios.get('/test').then(response => this.tests = response.data);
            console.log(this.seats);
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