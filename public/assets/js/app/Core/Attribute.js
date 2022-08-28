export class Attribute
{
    static data = []
    static developer
    static header
    static input
    static method
    static send
    static url

    static setData(name, value) {
        this.data[name] = value
    }
    static clearData() {
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
    static setMethod(method) {
        this.method = method
    }
    static getMethod() {
        return this.method
    }
    static setSend(send) {
        this.send = send
    }
    static getSend() {
        return this.send
    }
    static setUrl(url) {
        this.url = url
    }
    static getUrl() {
        return this.url
    }
}