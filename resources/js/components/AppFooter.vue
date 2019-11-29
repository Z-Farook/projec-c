<template>
    <div class="navbar navbar-expand-md navbar-dark navbar-laravel">
        <div class="container">
            <ul>
                <li><span style="color:yellow">locaties</span></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Wijnhaven 107, 3011WN Rotterdam</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Kralingse zoom 91, 3063 ND Rotterdam</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Burgemeester S'jacobplein 1, 3015 CA Rotterdam</a></li>
            </ul>
            <ul>
                <li><span style="color:yellow">Technologie</span></li>
                <li><a href="/" style="color:yellow" text-decoration="none">2D</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">3D</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Imax</a></li>
            </ul>
            <ul>
                <li><router-link :to="{name: 'contact'}" style="color:yellow">Contact</router-link></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Klanten service</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">Werken bij Vue</a></li>
                <li><a href="/" style="color:yellow" text-decoration="none">FAQ</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "app-footer"
    }
</script>

<style>

</style>