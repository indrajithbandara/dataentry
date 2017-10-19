<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6" v-if="disabled === true">
            <button class="btn btn-disabled full-width" type="button" v-show="btnNum" disabled>Line Items Limit Reached</button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6" v-else>
            <button class="btn btn-success full-width" @click="liShow(numOne)" type="button" v-show="btnNum">{{ changeText() }}</button>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <button class="btn btn-danger full-width" @click="liHide(numOne - 1)" type="button" v-show="btnNum">Remove A Line Item</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            numOne: Number,
            btnNum: Boolean,
            disabled: Boolean,
            liShow: Function,
            liHide: Function
        },
        methods: {
            changeText(){
                if(this.numOne == 2){
                    return 'Add A Third Line Item';
                } else if (this.numOne === 3){
                    return 'Add A Fourth Line Item';
                } else if (this.numOne === 4){
                    return 'Add A Fifth Line Item';
                } else if (this.numOne === 5){
                    return 'Add A Sixth Line Item';
                } else if (this.numOne === 6) {
                    return 'Add A Seventh Line Item';
                }
            }
        }
    }
</script>