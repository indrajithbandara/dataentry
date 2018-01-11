/**
 * Comments
 *
 * @param state | vuex invoices state
 * @param payload | payload commited from dispatcher
 * @return void
 */
export const setInvoices = (state, payload) => {
    state.stateName = payload;
};