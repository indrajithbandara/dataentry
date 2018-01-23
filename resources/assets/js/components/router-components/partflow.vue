<template>
    <div>
        <h1 class="text-center">Part Flow</h1>
        <!-- Error and Success Messages -->
        <ErrorMessage :errorMes="errorMessage"></ErrorMessage>
        <SuccessMessage :successMes="successMessage"></SuccessMessage>
        <!-- Start of Search Froms -->
        <div class="row">
            <!-- Start of Search by Router Number Form -->
            <div class="col-xs-12 col-md-6 col-lg-4">
                <form action="#" @submit.prevent="">
                    <div class="row">
                        <div class="col-xs-8 col-sm-8">
                            <div class="form-group">
                                <input v-model="search_router_num" type="text" name="search" class="form-control" placeholder="Router Number">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <button @click="" v-show="search_router" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
            </div>
            <!-- End of Search by Router Number Form -->
            <!-- Start of Search by Part Number Form -->
            <div class="col-xs-12 col-md-6 col-lg-4">
                <form action="#" @submit.prevent="">
                    <div class="row">
                        <div class="col-xs-8 col-sm-8">
                            <div class="form-group">
                                <input v-model="search_pn_num" type="text" name="search" class="form-control" placeholder="Part Number">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <button @click="" v-show="search_pn" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
            </div>
            <!-- End of Search by Part Number Form -->
            <!-- Start of Search by PO Number Form -->
            <div class="col-xs-12 col-md-6 col-lg-4">
                <form action="#" @submit.prevent="">
                    <div class="row">
                        <div class="col-xs-8 col-sm-8">
                            <div class="form-group">
                                <input v-model="search_po_num" type="text" name="search" class="form-control" placeholder="P.O Number">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-default full-width"><i class="fa fa-search" aria-hidden="true"></i>  Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <button @click="" v-show="search_po" class="btn btn-danger full-width btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Cancel Search</button>
            </div>
            <!-- End of Search by PO Number Form -->
        </div>
        <!-- End of Search Forms -->
        <!-- Start of Departments Table -->
        <!-- ========= Start of Main Column Container ========== -->
        <div id="scroll-container">
            <div class="dept-main" :style="'width:'+deptMainWidth+'px;'">
                <!-- Start of 'NIP' Container -->
                <div class="dept-cont nip-cont" id="NIP">
                    <div>
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
                                    :department="route.dept_name" 
                                    :log="route.move_log" 
                                    :partNumber="route.part_num" 
                                    :date="route.date" 
                                    :status="route.status" 
                                    :poNum="route.po_num" 
                                    :customer="route.customer"
                                    :employee="route.employee" 
                                ></RouterContainer>
                            </div>
                            <div class="router-cont dotted" style="background-color:#a62f61;color:#fff;"></div>
                        </Draggable>
                    </div>
                </div>
                <!-- End of 'NIP' Container -->

                <!-- Start of 'IP' Container -->
                <div class="dept-cont-ip" :style="'width:'+inProdWidth+'px;'">
                    <h4 class="text-center" style="margin-top: 4px;">In Production</h4>
                    <div class="ip-cont" id="IP">
                        <div :id="dept.dept_name" v-for="dept in departments" class="dept-cont-inner-ip" :style="'background-color:'+dept.dept_bg_color+';'+'color:'+dept.dept_txt_color+';'">
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
                                        v-if="dept.dept_name == route.dept_name && route.status == 'IP'"
                                        :routerNumber="route.router_num" 
                                        :quantity="route.qty" 
                                        :log="route.move_log" 
                                        :partNumber="route.part_num" 
                                        :date="route.date" 
                                        :status="route.status" 
                                        :poNum="route.po_num" 
                                        :customer="route.customer"
                                        :employee="route.employee" 
                                    ></RouterContainer>
                                </div>
                                <div class="router-cont dotted" :style="'background-color:'+dept.dept_bg_color+';'+'color:'+dept.dept_txt_color+';'"></div>
                            </Draggable>
                        </div>
                    </div>
                </div>
                <!-- Start of 'IP' Container -->

                <!-- Start of 'STFI' Container -->
                <div class="dept-cont ii-cont" id="STFI">
                    <h4 class="text-center">Staged For Inventory</h4>
                    <div class="full-width ii-inner-cont">
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
                                v-if="route.status == 'STFI'"
                                :routerNumber="route.router_num" 
                                :quantity="route.qty" 
                                :log="route.move_log" 
                                :partNumber="route.part_num" 
                                :date="route.date" 
                                :status="route.status" 
                                :poNum="route.po_num" 
                                :customer="route.customer"
                                :employee="route.employee" 
                            ></RouterContainer>
                        </div>
                        <div class="router-cont dotted" style="background:#c58e32;color:#fff;"></div>
                    </Draggable>
                    </div>
                    <button class="btn btn-warning full-width">Submit</button>
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
                nextStatus: '',
                element: {},
                inProdWidth: '',
                deptMainWidth: '',
                search_pn_num: '',
                search_pn: false,
                search_router_num: '',
                search_router: false,
                search_po_num: '',
                search_po: false,
                dragOptions: {
                    group: 'routers'
                },
                nip_items: [],
                ip_items: [],
                stfi_items: [],
                ii_items: [],
                routers: [
                    { router_num: 1001, part_num: '620-1-200', employee: 'Levi', dept_name: '', po_num: '88596', customer: 'Eaton', qty: 150, status: 'A', date: '2018-01-12', key: 0, placement: 1, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1002, part_num: '620-1-450', employee: 'Levi', dept_name: '', po_num: '88597', customer: 'Boing', qty: 50, status: 'STFI', date: '2018-01-12', key: 1, placement: 1, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1003, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 2, placement: 1, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1004, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 3, placement: 2, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1005, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 4, placement: 3, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1006, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 5, placement: 4, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1007, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 6, placement: 5, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1008, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 7, placement: 6, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1009, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 8, placement: 7, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1010, part_num: '620-5-200', employee: 'Levi', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 9, placement: 8, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1011, part_num: '620-5-200', employee: 'Levi', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 10, placement: 9, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1012, part_num: '620-5-200', employee: 'Levi', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 11, placement: 10, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1013, part_num: '620-5-200', employee: 'Levi', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 12, placement: 11, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1014, part_num: '620-5-600', employee: 'Levi', dept_name: '', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14', key: 13, placement: 1, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                    { router_num: 1015, part_num: '620-5-600', employee: 'Levi', dept_name: '', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14', key: 14, placement: 2, move_log: [{ item: 'At 3:00 PM on January, 17th 2018, this router moved into the Wrap department.'}, { item: 'At 3:45 PM on January, 18th 2018, this router moved into the Mold department.'}, { item: 'At 4:15 PM on January, 18th 2018, this router moved into the Grind department.'}, { item: 'At 4:30 PM on January, 18th 2018, this router moved into the Visual department.'} ]},
                ],
                departments: [
                    { dept_name: 'Wrap', dept_bg_color: '#f08613', dept_txt_color: '#fff', key: 1 },
                    { dept_name: 'Mold', dept_bg_color: '#74875f', dept_txt_color: '#fff', key: 2 },
                    { dept_name: 'Grind', dept_bg_color: '#29a77a', dept_txt_color: '#fff', key: 3 },
                    { dept_name: 'Wash', dept_bg_color: '#006a84', dept_txt_color: '#fff', key: 4 },
                    { dept_name: 'Visual', dept_bg_color: '#10cc83', dept_txt_color: '#fff', key: 5 },
                    { dept_name: 'Dip', dept_bg_color: '#00cd44', dept_txt_color: '#fff', key: 6 },
                    { dept_name: 'In Process', dept_bg_color: '#cc014d', dept_txt_color: '#fff', key: 7 },
                ],
                windowWidth: 0,
            }
        },
        mounted() {
            this.setInProductionWidth();
            console.log(this.routers);
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
            onMove({relatedContext, draggedContext}){
                console.log('Related:',relatedContext);
                console.log('Dragged:',draggedContext);
                this.index = draggedContext.futureIndex;
                // Sets the id of the drop parent element which is the department name
                this.nextDept = relatedContext.component.$el.parentElement.id;
                // Set the id of the main parent container which has the Status ID
                this.nextStatus = relatedContext.component.$el.parentElement.parentElement.id;
                // Saves the element that is being moved
                this.element = draggedContext.element;
            },
            onEnd(evt){
                if(this.element.dept_name !== this.nextDept && this.element.dept_name != ''){
                    this.routers.unshift(this.element);
                }else if (this.element.dept_name == '' && this.nextDept == ''){
                    // Do not push element
                }else if(this.element.dept_name == '' && this.nextDept != ''){
                    this.routers.unshift(this.element);
                }
                this.element.dept_name = this.nextDept;
                this.element.status = this.nextStatus;
                this.sortRouter();
                console.log(this.routers);
                console.log()
                // console.log('At 4:30 PM on January, 18th 2018, this router moved into the Visual department.')
            },
            getNewtime(){
                // time function in scratch js
            },
            setInProductionWidth(){
                let width = 0;
                for(var i = 0; i < this.departments.length; i++){
                    if(this.departments.length < 3){
                        width += 250;
                    }else if (this.departments.length < 11){
                        width +=242;
                    } else {
                        width += 241;
                    }
                }
                let mainWidth = width + 550;
                this.inProdWidth = width.toString();
                this.deptMainWidth = mainWidth.toString();
            },
            sortRouter(){
                for(var i = 0; i < this.routers.length; i++){
                    this.routers[i].key = i;
                }
                this.routers.sort(function(a,b){
                    return a.key - b.key;
                });
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
        width: 2000px;
    }
    .dept-cont, .dept-cont-ip, .dept-cont-inner-ip {
        border-radius: 10px;
        height: 580px;
        margin: 5px 7px;
        padding: 10px;
        overflow: scroll;
    }
    .nip-cont {
        background: #a62f61;
        display: inline-block;
    }
    .dept-cont {
        width: 225px;
        display: inline-block;
    }
    .dept-cont-ip {
        min-width: 260px;
        display: inline-block;
        background: #208ca4;
    }
    .dept-cont-inner-ip {
        background: #ddd;
        display: inline-block;
        height: 520px;
        width: 225px;
    }
    .ip-cont {

    }
    .ii-cont {
        background: #c58e32;
    }
    .ii-inner-cont {
        height: 480px;
        overflow-y: scroll;
        margin-bottom: 5px;
    }
    .dotted {
        border: 2px dotted #fff;
        color: #aaa;
    }
    #main-search {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    @media(max-width:1345px){
        .fa-search {
            display: none;
        }
    }
</style>