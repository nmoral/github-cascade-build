import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * workflow_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        this.url = this.element.attributes.route.nodeValue;
    }
    refresh(event) {
        console.log(event)
        let params = new URLSearchParams(event.detail)
        fetch(this.url+'?'+params.toString())
    }
}
