import {Attribute} from './Attribute.js';
import Model from "./Model.js";

export default class Database {
    static model(data, request) {
        let model
        model = Object.keys(data)
        model = model.toString()
        Model[model].index(data, request)
    }

    static request(data) {
        let header = new Headers();
        header.append("Content-Type", "application/json")
        Attribute.setHeader(header)
        let headers = {
            method: Attribute.getMethod(),
            headers: Attribute.getHeader(),
            body: data,
            redirect: 'follow'
        }
        fetch(Attribute.getUrl(), headers)
            .then(response => response.json())
            .then((data) => {
                this.model(data, 'ia')

            })
            .catch(error => console.log('error', error))
    }
}