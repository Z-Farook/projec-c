<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        You are logged in, {{displayName}}!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "account",
        computed: {
            displayName() { return this.$store.getters.user.name }
        }
    }
</script>

<style scoped>

</style>