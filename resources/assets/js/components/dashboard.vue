<template>
    <div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Open Purchase Orders</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ inv_count }}</div>
                                <div>Incomplete Invoices</div>
                            </div>
                        </div>
                    </div>
                    <a href="/invoices">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-arrows fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Open Routers</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ inventory_count }}</div>
                                <div>Unapproved Inventory Ship Tickets</div>
                            </div>
                        </div>
                    </div>
                    <a href="/customers">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>

</template>

<script>
    export default {
        beforeMount(){
            this.invoiceCount();
        },
        data() {
            return {
                po_count: 0,
                inv_count: 0,
                router_count: 0,
                inventory_count: 0
            }
        },
        methods: {
            invoiceCount(){
                axios.get('api/invoices/count')
                .then((response)=>{
                    this.inv_count = response.data;
                })
                .catch((error)=>{
                    throw new Error("Something went wrong getting your Invoice count.");
                });
            },
            // purchaseorderCount(){
            //     axios.get('api/purchaseorders/count')
            //     .then((response)=>{
            //         this.po_count = response.data;
            //     })
            //     .catch((error)=>{
            //         throw new Error("Something went wrong getting your purchaseorder count.");
            //     });
            // },
            // routerCount(){
            //     axios.get('api/routers/count')
            //     .then((response)=>{
            //         this.router_count = response.data;
            //     })
            //     .catch((error)=>{
            //         throw new Error("Something went wrong getting your router count.");
            //     });
            // },
            // inventoryCount(){
            //     axios.get('api/inventory/count')
            //     .then((response)=>{
            //         this.inventory_count = response.data;
            //     })
            //     .catch((error)=>{
            //         throw new Error("Something went wrong getting your inventory count.");
            //     });
            // }
        }
    }
</script>