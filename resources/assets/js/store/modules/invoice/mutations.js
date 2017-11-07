export const setInvoices = (state, payload) => {
    state.invoices = payload;
};
export const setCustomer = (state, payload) => {
    state.invoice.customer = payload;
};
export const updateInvNum = (state, payload) => {
    state.invoice.inv_num = parseInt(payload);
};
export const updateDate = (state, payload) => {
    state.invoice.date = payload;
};
export const updatePo = (state, payload) => {
    state.invoice.po_num = payload;
};
export const updateCarrier = (state, payload) => {
    state.invoice.carrier = payload;
};
export const updateMemo = (state, payload) => {
    state.invoice.memo = payload;
};
export const updateComplete = (state, payload) => {
    state.invoice.complete = parseInt(payload);
};
// Line item Mutations
export const updateLineItem = (state, payload) => {
    state.invoice.line_items[payload.item].item = payload.event;
};
export const updateProduct = (state, payload) => {
    state.invoice.line_items[payload.item].product = payload.event;
};
export const updateQty = (state, payload) => {
    state.invoice.line_items[payload.item].qty = payload.event;
};
export const updateUnit = (state, payload) => {
    state.invoice.line_items[payload.item].unit = payload.event;
};
export const updateExtended = (state, payload) => {
    state.invoice.line_items[payload.item].extended = payload.ext;
};
// End of line item mutations
export const updateShipFee = (state, payload) => {
    state.invoice.ship_fee = payload;  
};
export const updateMiscChar = (state, payload) => {
    state.invoice.misc_char = payload;  
};
export const updateTotal = (state, payload) => {
    state.invoice.total = payload;  
};
// responsible for reseting the state after an invoice has been
// created. 
export const resetState = (state) => {
    for(var key in state.invoice){
        if(key == 'inv_num' || key == 'ship_fee' || key == 'misc_char' || key == 'total'){
            state.invoice[key] = 0;
        }else if(key == 'customer'){
            for(var k in state.invoice.customer){
                state.invoice.customer[k] = '';
            }
        }else if(key == 'line_items'){
            for(var i = 0; i < 7; i++){
                for(var key in state.invoice.line_items[i]){
                    if(key == 'item' || key == 'product'){
                        state.invoice.line_items[i][key] = '';
                    }else{
                        state.invoice.line_items[i][key] = 0;
                    }
                }
            }  
        }else if(key == 'complete'){
            state.invoice[key] = 0;
        }else {
            state.invoice[key] = '';
        }
    }
}; // End of resetState