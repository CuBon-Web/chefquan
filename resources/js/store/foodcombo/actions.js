import {HTTP} from '../../core/plugins/http'

export const addFoodCombo = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/foodcombo/create', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const listFoodCombo = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/foodcombo/list', opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const deleteFoodCombo = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/foodcombo/delete/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const detailFoodCombo = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/foodcombo/edit/' + opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
