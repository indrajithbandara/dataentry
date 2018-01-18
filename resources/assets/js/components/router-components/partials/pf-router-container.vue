<template>
    <div class="router-cont">
        <span>Router: {{ routerNumber }} | Qty: {{ quantity }} </span> 
        &nbsp;&nbsp; 
        <i class="fa fa-caret-down" aria-hidden="true"></i>
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
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>