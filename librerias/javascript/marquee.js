/**
 * Funci�n Marquesina
 * @author Jaison Ospina
 * @version 1.0 Enero 2015
 */

function scroll(oid, iid) {
    this.oCont = document.getElementById(oid)
    this.ele = document.getElementById(iid)
    this.width = this.ele.clientWidth;
    this.n = this.oCont.clientWidth;
    this.move = function () {
        this.ele.style.left = this.n + "px"
        this.n--
        if (this.n < (-this.width)) {
            this.n = this.oCont.clientWidth
        }
    }
}
var vScroll
function setup() {
    vScroll = new scroll("oScroll", "scroll");
    setInterval("vScroll.move()", 20)
}
onload = function () {
    setup()
}