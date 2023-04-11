/* eslint-disable radix */
/*  sort of a copy of script.js
    every first block is for the shopping cart, every second for the site
*/
let cart = [];
if (localStorage.getItem("cart") == null) {
    let string = JSON.stringify(cart);
    localStorage.setItem("cart", string);
} else {
    cart = JSON.parse(localStorage.getItem("cart"));
}

function add(id) {
    let done = 0;
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id == id) {
            cart[i].amount++;
            done = 1;
        }
    }
    if (done == 0) {
        let obj = {
            id: id,
            amount: 1,
        };
        cart.push(obj);
    }
    let string = JSON.stringify(cart);
    localStorage.setItem("cart", string);
    reloadCart();
}

function reloadCart() {
    let divsc = document.querySelectorAll("div.scelem");
    for (let i = 0; i < divsc.length; i++) {
        divsc[i].remove();
    }
    let divcs = document.querySelectorAll("div.cselem");
    for (let i = 0; i < divcs.length; i++) {
        divcs[i].remove();
    }
    inflateCart();
}

function inflateCart() {
    let itemconfirm = 0;
    for (let i = 0; i < cart.length; i++) {
        const scmaindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        scmaindiv.append(scelem);

        const csmaindiv = document.querySelector("div.cscontent");
        let cselem = document.createElement("div");
        cselem.classList.toggle("cselem");
        csmaindiv.append(cselem);

        let scimg = document.createElement("img");
        ajaxGet(cart[i].id, "foto", scimg);
        scimg.alt = "itemimg";
        scelem.appendChild(scimg);

        let csimg = document.createElement("img");
        ajaxGet(cart[i].id, "foto", csimg);
        scimg.alt = "itemimg";
        cselem.appendChild(csimg);

        let scdiv1 = document.createElement("div");
        scelem.appendChild(scdiv1);

        let csdiv1 = document.createElement("div");
        cselem.appendChild(csdiv1);

        let sch4 = document.createElement("h4");
        ajaxGet(cart[i].id, "naam", sch4);
        scdiv1.appendChild(sch4);

        let csh4 = document.createElement("h4");
        ajaxGet(cart[i].id, "naam", csh4);
        csdiv1.appendChild(csh4);

        let scp1 = document.createElement("p");
        scp1.textContent = "€";
        let scspan1 = document.createElement("span");
        ajaxGet(cart[i].id, "prijs", scspan1);
        scdiv1.appendChild(scp1);
        scp1.appendChild(scspan1);

        let csp1 = document.createElement("p");
        csp1.textContent = "€";
        let csspan1 = document.createElement("span");
        ajaxGet(cart[i].id, "prijs", csspan1);
        csdiv1.appendChild(csp1);
        csp1.appendChild(csspan1);

        let scp2 = document.createElement("p");
        scp2.textContent = "In winkelwagen: " + cart[i].amount;
        scdiv1.appendChild(scp2);

        let csp2 = document.createElement("p");
        csp2.textContent = "In winkelwagen: " + cart[i].amount;
        csdiv1.appendChild(csp2);

        let scp3 = document.createElement("p");
        const scxmlhttp = new XMLHttpRequest();
        scxmlhttp.onload = function () {
            scp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
        };
        scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
        scxmlhttp.send();
        scdiv1.appendChild(scp3);

        let csp3 = document.createElement("p");
        const csxmlhttp = new XMLHttpRequest();
        csxmlhttp.onload = function () {
            csp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
        };
        csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
        csxmlhttp.send();
        csdiv1.appendChild(csp3);

        let scbtndiv = document.createElement("div");
        scbtndiv.classList.toggle("scbtns");
        scelem.appendChild(scbtndiv);

        let csbtndiv = document.createElement("div");
        csbtndiv.classList.toggle("csbtns");
        cselem.appendChild(csbtndiv);

        let scbtndivinside = document.createElement("div");
        scbtndiv.appendChild(scbtndivinside);

        let csbtndivinside = document.createElement("div");
        csbtndiv.appendChild(csbtndivinside);

        let scbtnp = document.createElement("button");
        scbtnp.textContent = "+";
        scbtnp.addEventListener("click", () => {
            scxmlhttp.onload = function () {
                if (cart[i].amount >= this.responseText) {
                    let sctimer = setInterval(() => {
                        scp2.textContent = "In winkelwagen: " + cart[i].amount;
                        scp2.style.color = "inherit";
                        clearInterval(sctimer);
                    }, 3000);
                    scp2.textContent = "Er zijn niet meer op voorraad";
                    scp2.style.color = "lightcoral";
                } else {
                    cart[i].amount++;
                    scp2.textContent = "In winkelwagen: " + cart[i].amount;
                    let scstring = JSON.stringify(cart);
                    localStorage.setItem("cart", scstring);
                    scxmlhttp.onload = function () {
                        scp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
                    };
                    scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
                    scxmlhttp.send();
                    csp2.textContent = "In winkelwagen: " + cart[i].amount;
                    let csstring = JSON.stringify(cart);
                    localStorage.setItem("cart", csstring);
                    csxmlhttp.onload = function () {
                        csp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
                    };
                    csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
                    csxmlhttp.send();
                    updateTotal();
                }
            };
            scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=voorraad`);
            scxmlhttp.send();
        });
        scbtndivinside.appendChild(scbtnp);

        let csbtnp = document.createElement("button");
        csbtnp.textContent = "+";
        csbtnp.addEventListener("click", () => {
            csxmlhttp.onload = function () {
                if (cart[i].amount >= this.responseText) {
                    let cstimer = setInterval(() => {
                        csp2.textContent = "In winkelwagen: " + cart[i].amount;
                        csp2.style.color = "inherit";
                        clearInterval(cstimer);
                    }, 3000);
                    csp2.textContent = "Er zijn niet meer op voorraad";
                    csp2.style.color = "lightcoral";
                } else {
                    cart[i].amount++;
                    scp2.textContent = "In winkelwagen: " + cart[i].amount;
                    let scstring = JSON.stringify(cart);
                    localStorage.setItem("cart", scstring);
                    scxmlhttp.onload = function () {
                        scp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
                    };
                    scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
                    scxmlhttp.send();
                    csp2.textContent = "In winkelwagen: " + cart[i].amount;
                    let csstring = JSON.stringify(cart);
                    localStorage.setItem("cart", csstring);
                    csxmlhttp.onload = function () {
                        csp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
                    };
                    csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
                    csxmlhttp.send();
                    updateTotal();
                }
            };
            csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=voorraad`);
            csxmlhttp.send();
        });
        csbtndivinside.appendChild(csbtnp);

        let scbtnm = document.createElement("button");
        scbtnm.textContent = "-";
        scbtnm.addEventListener("click", () => {
            cart[i].amount--;
            scp2.textContent = "In winkelwagen: " + cart[i].amount;
            scxmlhttp.onload = function () {
                scp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
            };
            scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
            scxmlhttp.send();
            csp2.textContent = "In winkelwagen: " + cart[i].amount;
            csxmlhttp.onload = function () {
                csp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
            };
            csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
            csxmlhttp.send();
            if (cart[i].amount == 0) {
                cart.splice(i, 1);
                reloadCart();
            }
            let scstring = JSON.stringify(cart);
            localStorage.setItem("cart", scstring);
            updateTotal();
        });
        scbtndivinside.appendChild(scbtnm);

        let csbtnm = document.createElement("button");
        csbtnm.textContent = "-";
        csbtnm.addEventListener("click", () => {
            cart[i].amount--;
            scp2.textContent = "In winkelwagen: " + cart[i].amount;
            scxmlhttp.onload = function () {
                scp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
            };
            scxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
            scxmlhttp.send();
            csp2.textContent = "In winkelwagen: " + cart[i].amount;
            csxmlhttp.onload = function () {
                csp3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
            };
            csxmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
            csxmlhttp.send();
            if (cart[i].amount == 0) {
                cart.splice(i, 1);
                reloadCart();
            }
            let csstring = JSON.stringify(cart);
            localStorage.setItem("cart", csstring);
            updateTotal();
        });
        csbtndivinside.appendChild(csbtnm);

        let scbtnrm = document.createElement("button");
        scbtnrm.textContent = "verwijder";
        scbtnrm.addEventListener("click", () => {
            cart.splice(i, 1);
            let scstring = JSON.stringify(cart);
            localStorage.setItem("cart", scstring);
            reloadCart();
            updateTotal();
        });
        scbtndiv.appendChild(scbtnrm);

        let csbtnrm = document.createElement("button");
        csbtnrm.textContent = "verwijder";
        csbtnrm.addEventListener("click", () => {
            cart.splice(i, 1);
            let csstring = JSON.stringify(cart);
            localStorage.setItem("cart", csstring);
            reloadCart();
            updateTotal();
        });
        csbtndiv.appendChild(csbtnrm);

        itemconfirm = 1;
    }
    if (itemconfirm == 0) {
        const scmaindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        scmaindiv.append(scelem);

        const csmaindiv = document.querySelector("div.cscontent");
        let cselem = document.createElement("div");
        cselem.classList.toggle("cselem");
        csmaindiv.append(cselem);

        let scp = document.createElement("p");
        scp.classList.toggle("noitem");
        scp.textContent = "Er is geen item in je winkelwagen...";
        scelem.appendChild(scp);

        let csp = document.createElement("p");
        csp.classList.toggle("noitem");
        csp.textContent = "Er is geen item in je winkelwagen...";
        cselem.appendChild(csp);
    } else {
        const scmaindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        scelem.classList.toggle("checkoutelem");
        scmaindiv.append(scelem);
        let scp = document.createElement("p");
        scp.textContent = "Totaal: €";
        scelem.appendChild(scp);
        let scspan2 = document.createElement("span");
        scspan2.setAttribute("id", "sctotal");
        scp.appendChild(scspan2);

        const csmaindiv = document.querySelector("div.cscontent");
        let cselem = document.createElement("div");
        cselem.classList.toggle("cselem");
        cselem.classList.toggle("cscheckoutelem");
        csmaindiv.append(cselem);
        let csp = document.createElement("p");
        csp.textContent = "Totaal: €";
        cselem.appendChild(csp);
        let csspan2 = document.createElement("span");
        csspan2.setAttribute("id", "cstotal");
        csp.appendChild(csspan2);

        updateTotal();

        let scbtn = document.createElement("button");
        scbtn.textContent = "Naar afrekenen";
        scbtn.addEventListener("click", () => { window.location.href = "checkout.php"; });
        scelem.appendChild(scbtn);

        let csbtn = document.createElement("button");
        csbtn.textContent = "Afrekenen";
        csbtn.addEventListener("click", () => {
            for (let i = 0; i < cart.length; i++) {
                console.log("yeet");
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function () {
                    let final = parseInt(this.responseText) - cart[i].amount;
                    console.log(final);
                    const cmlhttp = new XMLHttpRequest();
                    cmlhttp.onload = function () {
                        window.location.href = "error.php?errors=ordered";
                        localStorage.setItem("cart", '[]');
                    };
                    cmlhttp.open("GET", `scripts/setdata.php?id=${cart[i].id}&voorraad=${final}`);
                    cmlhttp.send();
                };
                xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=voorraad`);
                xmlhttp.send();
            }
        });
        cselem.appendChild(csbtn);
    }
}

function ajaxGet(id, data, element) {
    const xmlhttp = new XMLHttpRequest();
    if (data == "foto") {
        xmlhttp.onload = function () {
            element.src = 'media/itemimg/' + this.responseText;
        };
    } else {
        xmlhttp.onload = function () {
            element.textContent = this.responseText;
        };
    }
    xmlhttp.open("GET", `scripts/getdata.php?id=${id}&data=${data}`);
    xmlhttp.send();
}

window.onload = () => {
    reloadCart();
};

function updateTotal() {
    document.getElementById("sctotal").textContent = 0;
    document.getElementById("cstotal").textContent = 0;
    for (let i = 0; i < cart.length; i++) {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function () {
            if (document.getElementById("sctotal").textContent == "") {
                document.getElementById("sctotal").textContent = 0;
            }
            if (document.getElementById("cstotal").textContent == "") {
                document.getElementById("cstotal").textContent = 0;
            }
            let existingMoney = parseFloat(document.getElementById("sctotal").textContent);
            let calc = ((parseFloat(this.responseText) * cart[i].amount) + existingMoney).toFixed(2);
            document.getElementById("sctotal").textContent = calc;
            document.getElementById("cstotal").textContent = calc;
        };
        xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
        xmlhttp.send();
    }
}