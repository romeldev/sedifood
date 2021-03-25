import Vue from 'vue'
import BaseForm from 'vform'
import { objectToFormData } from 'object-to-formdata';

class FileForm extends BaseForm {
    constructor(data = {}){
        super(data)
    }

    startProcessing() {
        super.startProcessing()
        this.progress = 0
    }

    finishProcessing() {
        super.finishProcessing()
        this.progress = null
    }

    failProcessing() {
        this.progress = null
    }

    clear() {
        super.clear()
        this.progress = null
    }

    async req(url, action, config){
        return this.submit('post', url, config, action);
    }

    async submit(method, url, config = {}, action = null) {
        const newConfig = Object.assign(config, {
          transformRequest: [function(data, headers) {
            console.log('data', data);
            console.log('data_object', objectToFormData(data));

            return objectToFormData(data);
          }],

          onUploadProgress: e => {
            this.progress = Math.round((e.loaded * 100) / e.total);
          },
        });

        const data = method === 'get'
        ? { params: this.data }
        : this.data();

        let newUrl = url;
        if (data.id != null && (action === 'edit' || action === 'delete')) {
            newUrl += `/${data.id}`;
            data._method = action === 'edit' ? 'PUT' : 'DELETE';
        }
        // WHEN USE TOKEN (ej. jwt)
        // const token = isLogged();
        // if (token) {
        //   newConfig.headers = { Authorization: 'Bearer ' + token }; // Set JWT token
        // }

        return new Promise((resolve, reject) => {
            this.startProcessing();

            window.axios.request({
                url: process.env.MIX_BASE_API + this.route(newUrl), method, data, ...newConfig,
            })
            .then(response => {
                this.finishProcessing();
                resolve(response);
            })
            .catch(error => {
                this.busy = false;
                this.failProcessing()
                if (error.response && error.response.status === 422) {
                    this.errors.set(this.extractErrors(error.response));
                }
                reject(error);
            });
        });
    }
}

FileForm.ignore.push('progress');
window.FileForm = FileForm;

export default FileForm;