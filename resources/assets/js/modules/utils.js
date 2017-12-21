export const message = (obj, message, setting="success", timing) => {
    if(setting == 'success'){
        obj.successMessage = message;
        setTimeout(()=>{
            obj.successMessage = '';
        }, timing);
    } else if (setting == 'error'){
        obj.errorMessage = message;
        setTimeout(()=>{
            obj.errorMessage = '';
        }, timing);
    }
}
export default {
    message
}