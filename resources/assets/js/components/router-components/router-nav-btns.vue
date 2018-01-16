<template>
    <ul class="nav nav-tabs nav-justified">
        <li @click="toRouters" class="text-center md-font cursor-pointer"><i class="fa fa-arrows" aria-hidden="true"></i>  Routers</li>
        <li @click="toDepartments" class="text-center md-font cursor-pointer"><i class="fa fa-wrench" aria-hidden="true"></i>  Departments</li>
        <li @click="toPartFlow" class="text-center md-font cursor-pointer"><i class="fa fa-columns" aria-hidden="true"></i>  Part Flow</li>
    </ul>
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
<style scoped>
    .md-font{ font-size: 16px;}
    .cursor-pointer {cursor: pointer;}
    li {padding: 8px;border: 1px solid #bbb;border-radius: 20px 20px 0 0;background: #eee;}
    li:hover {background: #ddd;}
    @media(max-width:768px){li {border-radius: 0;}}
</style>