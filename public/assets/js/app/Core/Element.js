export class Element {
    static getId(elementId) {
        return document.getElementById(elementId)
    }
    static tag(tag = 'div') {
        return document.createElement(tag)
    }
}