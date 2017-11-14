// This function is responsible for retrieving invoice 
// data and parsing the parts that need json parsing.
// These parts specificlly are the customer information
// and the line item information. This data is commited
// to the setInvoices mutations function.
export const commitInvoices = ({ commit }) => {
    axios.get('api/invoices')
    .then((response) => {
        var newData = () => {
            var data = response.data;
            for(var i = 0; i < data.length; i++){
                for(var key in data[i]){
                    if(key === 'customer'){
                        data[i].customer = JSON.parse(JSON.parse(data[i].customer));
                    }
                }
            }
            return data;
        }
        commit('setInvoices', newData());
    }).catch((error) => {
        throw new Error('commitInvoices action failed!!! ' + error);
    });
}; // End of commitInvoices



// This function is responsible for retrieving the data for
// the customer that was chosen by the user to be stored
// with the invoice. This function commits the data to the
// setCustomer mutations function.
export const commitOneCustomer = ( { commit }, payload ) => {
    axios({
        method: 'get',
        url: 'api/customers/' + parseInt(payload[0]),
        validateStatus(status) {
            return status >= 200 && status < 300;
        }
    }).then((response) => {
        commit('setCustomer', response.data);
    }).catch((error) => {
        throw new Error('commitOneCustomer action failed' + error);
    });
}; // End of commitOneCustomer


/*
payload = {
    item: type=Number | 0-6 traversing an array,
    event: input event.target.value,
    set: type=Number | 0 = qty, 1 = unit
}
Action responsible for adding up the extended prices of each line item
*/
export const commitMath = (context, payload) => {
    if(payload.set === 0){
        context.commit('updateQty', {item: payload.item, event: payload.event});
    } else if(payload.set === 1){
        context.commit('updateUnit', {item: payload.item, event: payload.event});
    } else {
        throw new Error('Unexpected:' + payload.set + '. Expecting 0 or 1 for commitMath action.');
    }
    let extended = context.state.invoice.line_items[payload.item].qty * 
                   context.state.invoice.line_items[payload.item].unit;
    context.commit('updateExtended', {item: payload.item, ext: extended});
}; // End of commitMath

// Action responible for adding up all the extended prices, the shipping
// fee and the misc charges. 
export const commitTotal = context => {
    let total = () => {
        let t = 0;
        for(let i = 0; i < 7; i++){
            t += context.state.invoice.line_items[i].extended;
        }
        t += parseFloat(context.state.invoice.ship_fee);
        t += parseFloat(context.state.invoice.misc_char);
        return t;
    }
    let totalToFloat = total();
    context.commit('updateTotal', totalToFloat.toFixed(2));
}; // End of commitTotal


// Responsible for createing a new invoice and then committing 
// the resetState mutations function. Promise Added due to component 
// methods needing execution after promise is finished.
export const createNewInvoice = context => {
    return new Promise((resolve, reject) => {
        let params = Object.assign({}, context.state.invoice);
        axios({
            method: 'post',
            url: 'api/invoices/store',
            data: params,
            validateStatus(status) {
                return status >= 200 && status < 300;
            }
        }).then((response) => {
            context.commit('resetState');
            resolve();
        }).catch((error) => {
            throw new Error('createNewInvoice action failed!' + error);
            reject();
        }); 
    });
}; // End of createNewInvoice

// responsible for pull invoice info to be edited
// Promise Added due to component methods needing execution 
// after promise is finished.
export const showInvoice = ( { commit }, payload ) => { // get request to show an invoice for editing
    return new Promise((resolve, reject) => {
        axios({
            method: 'get',
            url: 'api/invoices/' + payload,
            validateStatus(status) {
                return status >= 200 && status < 300;
            }
        }).then((response) => {
            commit('setInvoiceData', response);
            resolve();
        }).catch((error) => {
            throw new Error('show invoice action failed!' + error);
            reject();
        });
    });
};

export const updateInvoice = (context, payload) => { // patch request to update an invoice
    return new Promise((resolve, reject) => {
        let params = Object.assign({}, context.state.invoice);
        axios({
            method: 'patch',
            url: 'api/invoices/' + payload,
            data: params,
            validateStatus(status) {
                return status >= 200 && status < 300;
            }
        }).then(() => {
            context.commit('resetState');
            resolve();
        }).catch((error) => {
            throw new Error('updateInvoice failed! ' + error);
            reject();
        });
    });
};

export const deleteInvoice = (context, payload) => { // delete request to delete an invoice, only permision level 1 users can make this request as the button is only visable for them.
    return new Promise((resolve, reject) => {
        if(confirm('Are you sure you want to delete this invoice?')){
            axios.delete('api/invoices/' + payload)
            .then(() => {
                resolve();
            }).catch((error) => {
                throw new Error('deleteInvoice failed! ' + error);
                reject();
            });
        }else{
            return;
        }
    });
};

export const dateRangeSearch = ({ commit }, payload) => {
    return new Promise((resolve, reject) => {
        axios({
            method: 'get',
            url: 'api/invoices/report/' + payload.start + '/' + payload.end,
            validateStatus(status) {
                return status >= 200 && status < 300;
            }  
        })
        .then((response) => {
            var newData = () => {
                var data = response.data;
                for(var i = 0; i < data.length; i++){
                    for(var key in data[i]){
                        if(key === 'customer'){
                            data[i].customer = JSON.parse(JSON.parse(data[i].customer));
                        }
                    }
                }
                return data;
            }
            commit('setInvoices', newData());
        }).catch((error) => {
            throw new Error('commitInvoices action failed!!! ' + error);
        });
    });
};

export const searchInv = ({ commit }, payload) => {
    return new Promise((resolve, reject) => {
        axios({
            method: 'get',
            url: 'api/invoices/search/' + payload,
            validateStatus(status) {
                return status >= 200 && status < 300;
            }
        }).then((response) => {
            var newData = () => {
                var data = response.data;
                for(var i = 0; i < data.length; i++){
                    for(var key in data[i]){
                        if(key === 'customer'){
                            data[i].customer = JSON.parse(JSON.parse(data[i].customer));
                        }
                    }
                }
                return data;
            }
            commit('setInvoices', newData());
        }).catch((error) => {
            throw new Error('searchInv failed!' + error);
        });
    });
}