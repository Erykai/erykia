export class Element
{
    static tag(tag = 'div')
    {
        return document.createElement(tag)
    }
    static getId(elementId)
    {
        return document.getElementById(elementId)
    }
}