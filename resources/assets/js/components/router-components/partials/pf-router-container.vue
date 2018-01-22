<template>
    <div class="router-cont">
        <div>
            <span>Router: {{ routerNumber }} | Qty: {{ quantity }} </span> 
            &nbsp;&nbsp; 
            <button class="toggle-btn" @click="toggle"><i class="fa fa-caret-down" aria-hidden="true"></i></button>
        </div>
        <div class="full-width" v-if="card">
            <hr class="dashed">
            <p><strong>Part #:</strong> {{ partNumber }}</p>
            <p><strong>Qty:</strong> {{ quantity }}</p>
            <p><strong>Date:</strong> {{ date }}</p>
            <p><strong>Status:</strong> {{ status }}</p>
            <p><strong>P.O. #:</strong> {{ poNum }}</p>
            <p><strong>Customer:</strong> {{ customer }}</p>
            <p><strong>Employee:</strong> {{ employee }}</p>
            <div id="move-cont" class="full-width" v-if="move_log">
                <p class="text-center underline"><strong>Move Log</strong></p>
                <div class="full-width">
                    <p v-for="items in log">{{items.item}}</p>
                </div>
            </div>
            <div class="full-width text-center">
                <button type="button" class="btn btn-primary btn-xs">View</button> &nbsp; 
                <button type="button" class="btn btn-warning btn-xs">Edit</button> &nbsp; 
                <button @click="showlog" type="button" class="btn btn-default btn-xs">Move Log</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            routerNumber: Number,
            quantity: Number,
            department: String,
            log: Array,
            partNumber: String,
            date: String,
            status: String,
            poNum: String,
            customer: String,
            employee: String
        },
        data(){
            return {
                card: false,
                move_log: false
            }
        },
        methods: {
            toggle(){
                if(this.card == false){
                    this.card = true;
                }else{
                    this.card = false;
                }
            },
            showlog(){
                if(this.move_log == false){
                    this.move_log = true;
                }else{
                    this.move_log = false;
                }
            }
        }
    }
</script>
<style>
    .router-cont {
        width: 100%;
        min-height: 50px;
        padding: 10px;
        border-radius: 10px;
        background: #fff;
        color: #000;
        margin: 5px 0;
        display: flex;
        flex-direction: column;
    }
    .toggle-btn {
        border: 1px solid #bbb;
        border-radius: 5px;
    }
    #move-cont {
        max-height: 230px;
        overflow-y: scroll;
    }
    .actions {
        color: #25a3bc;
        text-decoration: underline;
    }
</style>