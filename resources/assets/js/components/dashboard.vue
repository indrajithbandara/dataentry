<template>
    <div>
        <div class="row">
<!--             <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">0</div>
                                <div>Open PO's</div>
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
            </div> -->
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ inv_count }}</div>
                                <div>Invoices</div>
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
<!--             <div class="col-lg-3 col-md-6">
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
            </div> -->
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ cust_count }}</div>
                                <div>Customers</div>
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
            this.customerCount();
        },
        data() {
            return {
                inv_count: 0,
                cust_count: 0
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
            customerCount(){
                axios.get('api/customers/count')
                .then((response)=>{
                    this.cust_count = response.data;
                })
                .catch((error)=>{
                    throw new Error("Something went wrong getting your Customer count.");
                });
            }
        }
    }
</script>