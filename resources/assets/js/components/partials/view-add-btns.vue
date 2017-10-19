<template>
    <div class="row"> 
        <div class="col-xs-6 col-sm-6 col-md-6"><button @click="toTable" class="btn btn-primary btn-lg full-width">View Invoices</button></div>
        <div class="col-xs-6 col-sm-6 col-md-6"><button @click="toForm" class="btn btn-success btn-lg full-width">Add An Invoice</button></div>
    </div>
</template>
<script>
    export default {
        props: {
            toTable: Function, // prop from invoices.vue & customers.vue
            toForm: Function // prop from invoices.vue & customers.vue
        }
    }
</script>