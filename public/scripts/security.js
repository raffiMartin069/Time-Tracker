/**
 * @function nullCheck - checks if the value is null or undefined
 * @param {Array} value - array of values to check
 * @throws {Error} - if null or undefined value is found
 * @returns {void} 
 */
export const nullCheck = (value=[]) => {

    if(value.length === 0){
        throw new Error('Please check all fields and try again.');
    }

    for(let i = 0; i < value.length; i++){
        if(value[i] === null || value[i] === undefined){
            throw new Error('Please check all fields and try again.');
        }
    }
    return true;
}

const filter = (value) => {
    if(!value) {
        throw new Error('Please check all fields and try again.');
    }
}

/**
 * @function formCheck - checks if the form value is null or undefined
 * @param {FormData} form - form data to check
 * @throws {Error} - if null or undefined value is found
 * @returns {void} 
 */
export const formCheck = (form) => {
    
    let identifier = true;
    let target = '';

    for(let [key, value] of form.entries()){

        if(key === 'mname') {
            continue;
        }

        if(value === null){
            identifier = false;
            target = key;
            break;
        }

        if(value === undefined) {
            identifier = false;
            target = key;
            break;
        }

        if(value === '') {
            identifier = false;
            target = key;
            break;
        }

        if(key === 'contact'){
            if(value.length < 11) {
                identifier = false;
                target = key;
                break;
            }
          }

        if(Array.isArray(value)){
            nullCheck(value);
            break;
        }
    }

    return [identifier, target];
}