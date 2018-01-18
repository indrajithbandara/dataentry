<template>
    <div>
        <h1 class="text-center">Part Flow</h1>
        <!-- Error and Success Messages -->
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- Start of Departments Table -->
        <!-- ========= Start of Main Column Container ========== -->
        <div id="scroll-container">
            <div class="dept-main">
                <!-- Start of 'NIP' Container -->
                <div class="dept-cont" id="nip-cont">
                    <h4 class="text-center">Not In Production</h4>
                    <Draggable 
                        v-model="routers"
                        class="full-width" 
                        :element="'div'"
                        :options="dragOptions"
                        :move="onMove"
                        @end="onEnd" 
                        >
                        <div id="nip-container" v-for="route in routers" :key="route.key" class="full-width">
                            <RouterContainer
                                v-if="route.status == 'NIP'"
                                :routerNumber="route.router_num" 
                                :quantity="route.qty" 
                            ></RouterContainer>
                        </div>
                    </Draggable>
                </div>
                <!-- End of 'NIP' Container -->

                <!-- Start of 'IP' Container -->
                <div class="dept-cont-ip">
                    <h4 class="text-center">In Production</h4>
                    <div id="ip-cont">
                        <div :id="dept.dept_name" class="dept-cont-inner-ip" v-for="dept in departments">
                            <h5 class="text-center">{{ dept.dept_name }}</h5>
                            <Draggable 
                                v-model="routers"
                                class="full-width" 
                                :element="'div'"
                                :options="dragOptions" 
                                :move="onMove"
                                @end="onEnd" 
                                >
                                <div v-for="route in routers" :key="route.key" class="full-width">
                                    <RouterContainer 
                                        v-if="route.dept_name == dept.dept_name && route.status == 'IP'"
                                        :routerNumber="route.router_num" 
                                        :quantity="route.qty"
                                    ></RouterContainer>
                                </div>
                            </Draggable>
                        </div>
                    </div>
                </div>
                <!-- Start of 'IP' Container -->

                <!-- Start of 'II' Container -->
                <div class="dept-cont" id="ii-cont">
                    <h4 class="text-center">To Inventory</h4>
                    <div class="full-width" id="ii-inner-cont">
                        <RouterContainer></RouterContainer>
                    </div>
                    <button class="btn btn-success full-width">Submit</button>
                </div>
                <!-- End of 'II' Container -->
            </div>
        </div>
        <!-- ========= End of Main Column Container ========== -->
    </div>
</template>
<script>
    import ErrorMessage from '../../components/partials/error-message.vue';
    import SuccessMessage from '../../components/partials/success-message.vue';
    import RouterContainer from '../../components/router-components/partials/pf-router-container.vue';
    import Draggable from 'vuedraggable';

    export default {
        data(){
            return {
                errorMessage: '',
                successMessage: '',
                nextDept: '',
                dragOptions: {
                    group: 'routers',
                    sort: true
                },
                routers: [
                    { router_num: 1001, part_num: '620-1-200', dept_name: '', po_num: '88596', customer: 'Eaton', qty: 150, status: 'A', date: '2018-01-12', key: 1, placement: 1 },
                    { router_num: 1002, part_num: '620-1-450', dept_name: '', po_num: '88597', customer: 'Boing', qty: 50, status: 'II', date: '2018-01-12', key: 2, placement: 1 },
                    { router_num: 1003, part_num: '620-1-600', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 3, placement: 1 },
                    { router_num: 1004, part_num: '620-1-600', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 4, placement: 2 },
                    { router_num: 1005, part_num: '620-1-600', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 5, placement: 3 },
                    { router_num: 1006, part_num: '620-1-600', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 6, placement: 4 },
                    { router_num: 1007, part_num: '620-1-600', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 7, placement: 5},
                    { router_num: 1008, part_num: '620-1-600', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 8, placement: 6 },
                    { router_num: 1009, part_num: '620-1-600', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 9, placement: 7 },
                    { router_num: 1010, part_num: '620-5-200', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 10, placement: 8 },
                    { router_num: 1011, part_num: '620-5-200', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 11, placement: 9 },
                    { router_num: 1012, part_num: '620-5-200', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 12, placement: 10 },
                    { router_num: 1013, part_num: '620-5-200', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 13, placement: 11 },
                    { router_num: 1014, part_num: '620-5-600', dept_name: '', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14', key: 14, placement: 1 },
                ],
                departments: [
                    { dept_name: 'Wrap', dept_bg_color: '#af366c', dept_txt_color: '#fff', key: 1 },
                    { dept_name: 'Mold', dept_bg_color: '#74875f', dept_txt_color: '#fff', key: 2 },
                    { dept_name: 'Grind', dept_bg_color: '#29a77a', dept_txt_color: '#fff', key: 3 },
                    { dept_name: 'Wash', dept_bg_color: '#006a84', dept_txt_color: '#fff', key: 4 }
                ]
            }
        },
        mounted() {

        },
        components: {
            ErrorMessage,
            SuccessMessage,
            Draggable,
            RouterContainer
        },
        computed: {

        },
        methods: {
            onMove(evt){
                this.nextDept = evt.srcElement.parentElement.id;
                console.log(evt.srcElement.parentElement.id);
                console.log(evt.relatedContext);
                var index = evt.relatedContext.index -1;
                console.log(index);
                this.routers[index].dept_name = this.nextDept;
                console.log(this.routers[index].dept_name);
                /*
                trying to capture the next department name so that item can be moved into it. 
                */
            },
            onEnd(evt){
                evt
                console.log(evt.srcElement.parentElement.id);
                console.log(evt.item);
            }
        }
    }
</script>
<style scoped>
    h4 {
        color: #fff;
    }
    #scroll-container {
        overflow: scroll;
        width: 100%;
        height: 600px;
        background: #ddd;
        margin: 0;
        border-radius: 10px;
        border: 1px dashed #bbb;
    }
    .dept-main {
        display: flex;
        width: 1350px;
    }
    .dept-cont, .dept-cont-ip, .dept-cont-inner-ip {
        border-radius: 10px;
        height: 580px;
        margin: 5px .5%;
        padding: .5%;
        overflow: scroll;
    }
    .dept-cont {
        width: 225px;
    }
    .dept-cont-ip {
        width: 900px;
        background: #be832c;
    }
    .dept-cont-inner-ip {
        background: #ddd;
        height: 520px;
        width:24%;
    }
    #nip-cont {
        background: #a62f61;
    }
    #ip-cont {
        display: flex;
        flex-wrap: wrap;
    }
    #ii-cont {
        background: #29a77a;
    }
    #ii-inner-cont {
        height: 480px;
        overflow-y: scroll;
        margin-bottom: 5px;
    }
</style>