<template>
    <li class="nav-item dropdown">
        <router-link :to="{name: 'favorites'}" class="nav-link">
            <font-awesome-icon icon="heart" />
        </router-link>
    </li>
</template>

<script>
    export default {
        name: "favorite-nav-icon"
    }
</script>

<style>
</style>