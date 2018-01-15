<template>
    <div>
        <!-- table_routers = true  -->
        <h1 class="text-center">Routers</h1>
        <!-- Start of Routers Table -->
        <div>
            <!-- Routers Table -->
            <div id="routers-table" v-if="list.length > 0" class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Router #</th>
                            <th>Part #</th>
                            <th>Status</th>
                            <th>Po #</th>
                            <th>Customer</th>
                            <th>Qty</th>
                            <th>Date</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="router in list">
                            <td>{{ router.router_num }}</td>
                            <td>{{ router.part_num }}</td>
                            <td v-if="router.status == 'NIP'" class="nip-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'IP'" class="ip-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'II'" class="ii-item text-center">{{ router.status }}</td>
                            <td v-else-if="router.status == 'A'" class="a-item text-center">{{ router.status }}</td>
                            <td>{{ router.po_num }}</td>
                            <td>{{ router.customer }}</td>
                            <td>{{ router.qty }}</td>
                            <td>{{ router.date }}</td>
                            <td><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></td>
                            <td><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></td>
                            <td><button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else> 
                <p class="alert alert-info text-center">You currently have no routers to show.</p>
            </div>
            <!-- end of Routers table -->
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                list: [
                    { router_num: 1001, part_num: '620-1-200', po_num: '88596', customer: 'Eaton', qty: 150, status: 'A', date: '2018-01-12' },
                    { router_num: 1002, part_num: '620-1-450', po_num: '88597', customer: 'Boing', qty: 50, status: 'II', date: '2018-01-12' },
                    { router_num: 1003, part_num: '620-1-600', po_num: '88598', customer: 'Eaton', qty: 20, status: 'IP', date: '2018-01-13' },
                    { router_num: 1004, part_num: '620-5-200', po_num: '88599', customer: 'Hankifang', qty: 250, status: 'IP', date: '2018-01-14' },
                    { router_num: 1005, part_num: '620-5-600', po_num: '88600', customer: 'Boing', qty: 500, status: 'NIP', date: '2018-01-14' },
                ]
            }
        },
        mounted() {

        },
        components: {

        },
        computed: {

        },
        methods: {

        }
    }
</script>
<style scoped>
    #routers-table { 
        max-height: 565px; 
        overflow: scroll; 
    }
    .nip-item {
        background: #af366c;
        color: #fff;
    }
    .ip-item {
        background: #c58e32;
        color: #fff;
    }
    .ii-item {
        background: #29a77a;
        color: #fff;
    }
    .a-item {
        background: #423939;
        color: #fff;
    }
</style>