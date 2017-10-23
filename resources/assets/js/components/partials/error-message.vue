<template>
    <div v-if="errorMes">
        <p class="alert alert-danger text-center">{{ errorMes }} <span class="pull-right" @click="hideMes()">X</span></p>
    </div>
</template>
<script>
    export default {
        props: {
            errorMes: String
        },
        methods: {
            hideMes(){
                this.errorMes = '';
            }
        }
    }
</script>
<style scoped>
    span {
        cursor: pointer;
    }
</style>