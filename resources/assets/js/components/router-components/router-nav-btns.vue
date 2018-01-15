<template>
    <div class="row"> 
        <div class="col-xs-12 col-sm-4 col-md-4"><button @click="toRouters" class="btn btn-primary btn-lg full-width"><i class="fa fa-arrows" aria-hidden="true"></i>  Routers</button></div>
        <div class="col-xs-12 col-sm-4 col-md-4"><button @click="toDepartments" class="btn btn-primary btn-lg full-width"><i class="fa fa-wrench" aria-hidden="true"></i>  Departments</button></div>
        <div class="col-xs-12 col-sm-4 col-md-4"><button @click="toPartFlow" class="btn btn-primary btn-lg full-width"><i class="fa fa-columns" aria-hidden="true"></i>  Part Flow</button></div>
    </div>
</template>
<script>
    export default {
        props: {
            toRouters: Function,
            toDepartments: Function,
            toPartFlow: Function
        }
    }
</script>