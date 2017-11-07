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
                        data[i].customer = JSON.parse(data[i].customer);
                    } else if (key === 'line_items') {
                        data[i].line_items = JSON.parse(data[i].line_items);
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
export const commitMath = ( { commit }, payload ) => {
    if(payload.set === 0){
        commit('updateQty', {item: payload.item, event: payload.event});
    } else if(payload.set === 1){
        commit('updateUnit', {item: payload.item, event: payload.event});
    } else {
        throw new Error('Unexpected:' + payload.set + '. Expecting 0 or 1 for commitMath action.');
    }
    let extended = state.invoice.line_items[payload.item].qty * 
                   state.invoice.line_items[payload.item].unit;
    commit('updateExtended', {item: payload.item, ext: extended});
}; // End of commitMath

// Action responible for adding up all the extended prices, the shipping
// fee and the misc charges. 
export const commitTotal = ({ commit }) => {
    let total = () => {
        let t = 0;
        for(let i = 0; i < 7; i++){
            t += state.invoice.line_items[i].extended;
        }
        t += parseFloat(state.invoice.ship_fee);
        t += parseFloat(state.invoice.misc_char);
        return t;
    }
    let totalToFloat = total();
    commit('updateTotal', totalToFloat.toFixed(2));
}; // End of commitTotal


// Responsible for createing a new invoice and then committing 
// the resetState mutations function. 
export const createNewInvoice = ({ commit }) => {
    let params = Object.assign({}, state.invoice);
    axios({
        method: 'post',
        url: 'api/invoices/store',
        data: params,
        validateStatus(status) {
            return status >= 200 && status < 300;
        }
    }).then((response) => {
        commit('resetState');
    }).catch((error) => {
        throw new Error('createNewInvoice action failed!' + error);
    }); 
}; // End of createNewInvoice