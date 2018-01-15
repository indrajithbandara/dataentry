<template>
    <div>
        <RouterNavBtns
            :toRouters="switchToRouters"
            :toDepartments="switchToDepartments"
            :toPartFlow="switchToPartFlow"
        ></RouterNavBtns>
        <hr>
        <div v-show="table_routers">
            <Routers></Routers>
        </div><!-- End of table_routers = true container -->
        <div v-show="table_departments">
            <Departments></Departments>
        </div><!-- End of table_departments = true contrainer -->
        <div v-show="table_part_flow">
            <PartFlow></PartFlow>
        </div><!-- End of table_part_flow = true container -->
    </div>
</template>
<script>
    // imports
    import RouterNavBtns from '../components/router-components/router-nav-btns.vue';
    import Departments from '../components/router-components/departments.vue';
    import PartFlow from '../components/router-components/partflow.vue';
    import Routers from '../components/router-components/routers.vue';
    export default {
        data(){
            return {
                table_routers: true,
                table_departments: false,
                table_part_flow: false
            }
        },
        mounted() {

        },
        components: {
            RouterNavBtns,
            Departments,
            PartFlow,
            Routers
        },
        computed: {

        },
        methods: {
            switchToRouters(){
                this.table_departments = false;
                this.table_part_flow = false;
                this.table_routers = true;
            },
            switchToDepartments(){
                this.table_routers = false;
                this.table_part_flow = false;
                this.table_departments = true;
            },
            switchToPartFlow(){
                this.table_departments = false;
                this.table_routers = false;
                this.table_part_flow = true;
            }
        }
    }
</script>
<style scoped>

</style>