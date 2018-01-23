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
                            <div id="nip-container" v-for="route in list" :key="route.key" class="full-width">
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
                            <div class="router-cont dotted" style="background-color:#cc8ca7;color:#fff;"></div>
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
                                <div v-for="route in list" :key="route.key" class="full-width">
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
                        <div v-for="route in list" :key="route.key" class="full-width">
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
                        <div class="router-cont dotted" style="background:#d3b687;color:#fff;"></div>
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
                dragOptions: { group: 'routers' },
                windowWidth: 0,
                routers: [
                    { router_num: 1001, part_num: '620-1-200', employee: 'Levi', dept_name: '', po_num: '88596', customer: 'Eaton', qty: 150, status: 'A', date: '2018-01-12', key: 0, placement: 1, move_log: []},
                    { router_num: 1002, part_num: '620-1-450', employee: 'Levi', dept_name: '', po_num: '88597', customer: 'Boing', qty: 50, status: 'STFI', date: '2018-01-12', key: 1, placement: 1, move_log: []},
                    { router_num: 1003, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 5, placement: 1, move_log: []},
                    { router_num: 1004, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 4, placement: 2, move_log: []},
                    { router_num: 1005, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 3, placement: 3, move_log: []},
                    { router_num: 1006, part_num: '620-1-600', employee: 'Levi', dept_name: 'Wrap', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 2, placement: 4, move_log: []},
                    { router_num: 1007, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 6, placement: 5, move_log: []},
                    { router_num: 1008, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 7, placement: 6, move_log: []},
                    { router_num: 1009, part_num: '620-1-600', employee: 'Levi', dept_name: 'Mold', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13', key: 8, placement: 7, move_log: []},
                    { router_num: 1010, part_num: '620-5-200', employee: 'Levi', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 9, placement: 8, move_log: []},
                    { router_num: 1011, part_num: '620-5-200', employee: 'Levi', dept_name: 'Grind', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 10, placement: 9, move_log: []},
                    { router_num: 1012, part_num: '620-5-200', employee: 'Levi', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 11, placement: 10, move_log: []},
                    { router_num: 1013, part_num: '620-5-200', employee: 'Levi', dept_name: 'Wash', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14', key: 12, placement: 11, move_log: []},
                    { router_num: 1015, part_num: '620-5-600', employee: 'Levi', dept_name: '', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14', key: 14, placement: 1, move_log: []},
                    { router_num: 1014, part_num: '620-5-600', employee: 'Levi', dept_name: '', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14', key: 13, placement: 2, move_log: []}
                ],
                departments: [
                    { dept_name: 'Wrap', dept_bg_color: '#f08613', dept_txt_color: '#fff', key: 1 },
                    { dept_name: 'Mold', dept_bg_color: '#b7813a', dept_txt_color: '#fff', key: 2 },
                    { dept_name: 'Grind', dept_bg_color: '#cc4567', dept_txt_color: '#fff', key: 3 },
                    { dept_name: 'Wash', dept_bg_color: '#006a84', dept_txt_color: '#fff', key: 4 },
                ],
            }
        },
        mounted() {
            this.setInProductionWidth();
            this.sortRouters();
        },
        components: {
            ErrorMessage,
            SuccessMessage,
            Draggable,
            RouterContainer
        },
        computed: {
            list(){ return this.routers; }
        },
        methods: {
            /**
             * When Element is dragged from one dropzone to another
             * get related and dragged context data and set variables.
             * This method is hevily dependant of the html dom tree where
             * the following ID's are present: 'NIP', 'IP' and 'STFI'. Do not 
             * add any more nested elements as this method traverses the dom to
             * grab those ID's and use them as data.
             *
             * @param relatedContext | Object
             * @param draggedContext | Object
             * @return void
             */
            onMove({relatedContext, draggedContext}){
                this.index = draggedContext.futureIndex;
                // Sets the id of the drop parent element which is the department name
                this.nextDept = relatedContext.component.$el.parentElement.id;
                // Set the id of the main parent container which has the Status ID
                this.nextStatus = relatedContext.component.$el.parentElement.parentElement.id;
                // Saves the element that is being moved
                this.element = draggedContext.element;
            },
            /**
             * When dragged element is drop into the dropzone, the element that 
             * was set during the onMove method (as well as the other captured data) 
             * goes under a few conditions to determine if the element needs to be pushed
             * back to the original array since the dropzone removes the element due to
             * the condition on the dropzones themseleves. The elements department, status
             * move log and key may change or stay the same depending on the dropzone. The
             * element is unshifted into the array and the array is sorted by keys which allows
             * for the element to remain in the spot of which it was dropped.
             *
             * @param evt | Event
             * @return void
             */
            onEnd(evt){
                if(this.element.dept_name !== this.nextDept && this.element.dept_name != ''){
                    this.routers.unshift(this.element);
                }else if(this.element.dept_name == '' && this.nextDept != ''){
                    this.routers.unshift(this.element);
                }
                if(this.generateMoveLogEntry(this.element) != false){
                    this.element.move_log.push(this.generateMoveLogEntry(this.element));
                }
                this.element.dept_name = this.nextDept;
                this.element.status = this.nextStatus;
                this.element.key = this.index;
                this.sortRouters();
                // this.log();
            },
            /**
             * Generates a move log entry object to be pushed to the related elements
             * move_log property.
             *
             * @param el | Object
             * @return Boolean if log = '' || Object if log != ''
             */
            generateMoveLogEntry(el){
                let log = '';
                if(el.dept_name != this.nextDept && el.status == this.nextStatus ){
                    log += 'At ';
                    log += this.convertMilitaryTime() + ' on ';
                    log += this.getDate() + ', ';
                    log += 'router moved into the ' + this.nextDept.toLowerCase() + ' department.';
                } else if (el.status != this.nextStatus){
                    log += 'At ';
                    log += this.convertMilitaryTime() + ' on ';
                    log += this.getDate() + ', ';
                    log += "router status went from '" + el.status + "' to '" + this.nextStatus + "' ";
                    if(el.dept_name == '' && this.nextDept != ''){
                        log += "and moved into the " + this.nextDept.toLowerCase() + ' department.';
                    } else if (el.dept_name != '' && this.nextDept == '') {
                        log += 'and moved out of the ' + el.dept_name.toLowerCase() + ' department.';
                    }
                }
                if(log != ''){
                    let logEntry = { item: '' }
                    logEntry.item = log;
                    return logEntry;
                }
                return false;
            },
            /**
             * Convert Military time to standard time
             *
             * @return timeValue | String
             */
            convertMilitaryTime(){
                var time = this.getNewTime();
                time = time.split(':');
                var hours = Number(time[0]);
                var minutes = Number(time[1]);
                var seconds = Number(time[2]);

                var timeValue;
                if (hours > 0 && hours <= 12){
                  timeValue= "" + hours;
                } else if (hours > 12) {
                  timeValue= "" + (hours - 12);
                } else if (hours == 0) {
                  timeValue= "12";
                }
                 
                timeValue += (minutes < 10) ? ":0" + minutes : ":" + minutes;  // get minutes
                // timeValue += (seconds < 10) ? ":0" + seconds : ":" + seconds;  // get seconds
                timeValue += (hours >= 12) ? " P.M." : " A.M.";  // get AM/PM

                return timeValue;
            },
            /**
             * Get the current date with the month, day and year
             *
             * @return 'month/day/year' | String
             */
            getDate(){
                let date = new Date();
                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                let day = date.getDate();
                return month+'/'+day+'/'+year;
            },
            /**
             * Get the current time with the hour, minutes and seconds
             *
             * @return 'hour:minutes:seconds' | String
             */
            getNewTime(){
                let date = new Date();
                let minutes = date.getMinutes();
                let hour = date.getHours();
                let seconds = date.getSeconds();
                return String(hour+':'+minutes+':'+':'+seconds);
            },
            /**
             * Set the in production containers and overall container
             *  width depending on the number of departments it needs to hold.
             *
             * @return void
             */
            setInProductionWidth(){
                let width = 0;
                this.departments.forEach((el,i,a) => {
                    if(a.length < 3){
                        width += 250;
                    }else if (a.length < 11){
                        width +=245;
                    } else {
                        width += 241;
                    }
                });
                let mainWidth = width + 550;
                this.inProdWidth = width.toString();
                this.deptMainWidth = mainWidth.toString();
            },
            /**
             * Sorts all the routers by their key and then
             * sets the keys to equal their index number as to
             * avoid duplicate values in the keys.
             *
             * @return void
             */
            sortRouters(){
                this.routers.sort((a,b) => {
                    return a.key - b.key;
                }).forEach((el,i,a) => {
                    return a[i].key = i;
                });
            },
            log(){
                console.log('============================================================');
                this.routers.forEach((el,i,a) => {
                    console.log('Index: '+i+' | '+'Router Number: '+a[i].router_num+' | '+'Key: '+a[i].key+' | '+'Dept: '+a[i].dept_name+' | '+'Status: '+a[i].status);
                });
                console.log('============================================================');
                
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
        background: #cc8ca7;
        display: inline-block;
    }
    .dept-cont {
        width: 225px;
        display: inline-block;
    }
    .dept-cont-ip {
        min-width: 260px;
        display: inline-block;
        background: #8fb0c1;
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
        background: #d3b687;
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