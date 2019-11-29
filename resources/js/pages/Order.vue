<template>
    </div>
        <div class="wrapper">
            <div class="title">
                </br>
                </br>
                </br>
                <p class="maintext">BESTELSTATUS: {{response[0]['title'].toUpperCase()}}</p>
            </div>
            <div class="title-background"></div>
            <div class="tickets">
                <div class ="container">
                    <div v-if="!response[0]['title']">
                        <img class="center" src="https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif">
                    </div>
                    <div v-else>
                        </br>
                        <h2 style="font-weight: bold;">Bedankt voor uw bestelling! U heeft een e-mail ontvangen met uw bestelbevestiging.</h2>

                        <h4>Ticket ID: {{this.$route.query.id}}</h4>
                        <h4>Stoel(en)</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Nummer</th>
                                <th scope="col">Rij</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="info in information">
                                    <td>{{info[0]['number']}}</td>
                                    <td>{{info[0]['row']}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 v-if="food.length > 0" >Consumpties</h4>
                        <table v-if="food.length > 0" class="table">
                            <thead>
                                <tr>
                                <th scope="col">Naam product</th>
                                <th scope="col">Aantal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="f in food">
                                    <td>{{f['product_name']}}</td>
                                    <td>{{f['amount']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h4>Overige informatie</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Starttijd</th>
                                <th scope="col">Zaal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{show['startTime']}}</td>
                                    <td>{{show['room']['name'].toUpperCase()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="receipt">
                <p>Je bestelling</p>
                <img :src="show['movie']['thumbnail_img']" class="movie-poster"/>
                <p>{{show['movie']['title'].toUpperCase()}}</p>
                <hr style="height:1px;border:none;color:#333;background-color:#333;">
                <p>TOTAAL €{{response[0]['total']}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "order",
        data() {
            return {
                response: [[]],
                information: [[]],
                food: [[]],
                showId: 0
            }
        },
        methods: {
            getPaymentStatus(){
                axios.get('/getpaymentstatus', { params: { reference: this.$route.query.id} }).then(response => 
                    //this.status = response.data[0]['title']
                    {
                        this.response = response.data;
                        this.getOrderInformation();
                    }
                );
            },
            getOrderInformation(){
                axios.get('/getReservedSeatsByReservationId', { params: { reservation: this.response[0]['id']} }).then(response => 
                    //this.status = response.data[0]['title']
                    {
                        this.information = response.data;
                        this.showId = response.data[response.data.length - 1][0];
                        this.information.pop();
                        this.getFood();
                    }
                );
            },
            getFood(){
                axios.get('/getfoodbyreservationid', { params: { reservation: this.response[0]['id']} }).then(response => 
                    {
                        this.food = response.data;
                    }
                );
            }
        },
        computed: {
            show(){
                return this.$store.getters.getShowById(parseInt(this.showId))
            },
            informationn(){
                let tempArray = [];
                for(let i = 0; i < this.information.length; i++){
                    tempArray.push({ ["row" + this.information[i]['row']]: "value" });
                }
                //tempArray.push({ ["test" + 1]: "value" });
                return tempArray;
            }
        },
        mounted(){
            this.getPaymentStatus();
        }
    }
</script>

<style lang="scss">
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
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