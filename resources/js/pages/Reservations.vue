<template>
    <div>
        <h1>Bestelgeschiedenis</h1>
        <div v-if="reservations.length > 0">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Totaal</th>
                    <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="reservation in reservations" @click="redirect(reservation['reference'])">
                        <td>{{reservation['reference']}}</td>
                        <td>{{reservation['total']}}</td>
                        <td>{{reservation['created_at']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 v-else>U heeft nog geen bestellingen.</h2>
    </div>
</template>

<script>
    export default {
        name: "reservations",
        data() {
            return {
                reservations: []
            }
        },
        methods: {
            getReservationHistory(){
                axios.get('/getpaymenthistory').then(response => 
                    {
                        this.reservations = response.data;
                        console.log(response.data);
                    }
                );
            },
            redirect(url){
                window.location.href='http://127.0.0.1:8000/order?id=' + url;
            }
        },
        computed: {

        },
        mounted(){
            this.getReservationHistory();
        }
    }
</script>

<style lang="scss">

body{
    color:white;
}

</style>