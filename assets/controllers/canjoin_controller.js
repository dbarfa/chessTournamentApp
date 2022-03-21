import {Controller} from "@hotwired/stimulus";
import {app} from "../bootstrap";

export default class extends Controller{
    connect() {
        console.log(this.element.dataset.user)
           }
}