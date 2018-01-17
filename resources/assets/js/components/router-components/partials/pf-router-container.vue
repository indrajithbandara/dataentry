<template>
    <div class="router-cont">
        {{ routerNumber }} | {{ quantity }}
    </div>
</template>
<script>
    export default {
        props: {
            routerNumber: Number,
            quantity: Number
        },
        data(){
            return {
                //
            }
        },
        methods: {
            //
        }
    }
</script>
<style scoped>
    .router-cont {
        width: 100%;
        height: 50px;
        border-radius: 10px;
        background: #fff;
        margin: 5px 0;
    }
</style>