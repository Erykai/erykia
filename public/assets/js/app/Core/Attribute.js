import Model from './Model.js'
export class Attribute
{
    static data = []
    static developer
    static element
    static header
    static send
    static input
    static method
    static response
    static url

    static setData(name, value) {
        this.data[name] = value
    }
    static clearData()
    {
        delete this.data
        this.data = []
    }
    static getData() {
        return this.data
    }

    static setDeveloper(developer) {
        this.developer = developer
    }

    static getDeveloper() {
        return this.developer
    }

    static setElement(element) {
        this.developer = element
    }

    static getElement() {
        return this.element
    }

    static setHeader(header) {
        this.header = header
    }

    static getHeader() {
        return this.header
    }

    static setInput(input) {
        this.input = input
    }

    static getInput() {
        return this.input
    }

    static setSend(send) {
        this.send = send
    }

    static getSend() {
        return this.send
    }

    static setMethod(method) {
        this.method = method
    }

    static getMethod() {
        return this.method
    }

    static setResponse(data, request) {
        let model
        model = Object.keys(data)
        model = model.toString()
        this.response = Model[model].index(data, request)
    }

    static getResponse() {
        return this.response
    }

    static setUrl(url) {
        this.url = url
    }

    static getUrl() {
        return this.url
    }
}