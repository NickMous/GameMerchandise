/* eslint-disable radix */
let cart = [];
if (localStorage.getItem("cart") == null) {
    let string = JSON.stringify(cart);
    localStorage.setItem("cart", string);
} else {
    cart = JSON.parse(localStorage.getItem("cart"));
}

// adds product to cart, runs on detail.php when add to cart is clicked

function add(id) {
    document.querySelector("p.added").classList.remove("notyet");
    let timer = setInterval(() => {
        document.querySelector("p.added").classList.add("notyet");
        clearInterval(timer);
    }, 5000);
    let done = 0;
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id == id) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function () {
                if (cart[i].amount >= this.responseText) {
                    document.querySelector(".cartbtn").toggleAttribute("disabled");
                }
                if (cart[i].amount > this.responseText) {
                    document.querySelector(".cartbtn").toggleAttribute("disabled");
                } else {
                    console.log("yes");
                    cart[i].amount++;
                    let string = JSON.stringify(cart);
                    localStorage.setItem("cart", string);
                    reloadCart();
                }
            };
            done = 1;
            xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=voorraad`);
            xmlhttp.send();
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

// reloads everyting in the cart when cart is updated

function reloadCart() {
    let div = document.querySelectorAll("div.scelem");
    for (let i = 0; i < div.length; i++) {
        div[i].remove();
    }
    inflateCart();
}

// inflates the cart with all products

function inflateCart() {
    let itemconfirm = 0;
    for (let i = 0; i < cart.length; i++) {
        const maindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        maindiv.append(scelem);

        let img = document.createElement("img");
        ajaxGet(cart[i].id, "foto", img);
        scelem.appendChild(img);

        let div1 = document.createElement("div");
        scelem.appendChild(div1);

        let h4 = document.createElement("h4");
        ajaxGet(cart[i].id, "naam", h4);
        div1.appendChild(h4);

        let p1 = document.createElement("p");
        p1.textContent = "€";
        let span1 = document.createElement("span");
        ajaxGet(cart[i].id, "prijs", span1);
        div1.appendChild(p1);
        p1.appendChild(span1);

        let p2 = document.createElement("p");
        p2.textContent = "In winkelwagen: " + cart[i].amount;
        div1.appendChild(p2);

        let p3 = document.createElement("p");
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function () {
            p3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
        };
        xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
        xmlhttp.send();
        div1.appendChild(p3);

        let btndiv = document.createElement("div");
        btndiv.classList.toggle("scbtns");
        scelem.appendChild(btndiv);

        let btndivinside = document.createElement("div");
        btndiv.appendChild(btndivinside);

        let btnp = document.createElement("button");
        btnp.textContent = "+";
        btnp.addEventListener("click", () => {
            xmlhttp.onload = function () {
                if (cart[i].amount >= this.responseText) {
                    let timer = setInterval(() => {
                        p2.textContent = "In winkelwagen: " + cart[i].amount;
                        p2.style.color = "inherit";
                        clearInterval(timer);
                    }, 3000);
                    p2.textContent = "Er zijn niet meer op voorraad";
                    p2.style.color = "lightcoral";
                } else {
                    cart[i].amount++;
                    p2.textContent = "In winkelwagen: " + cart[i].amount;
                    let string = JSON.stringify(cart);
                    localStorage.setItem("cart", string);
                    xmlhttp.onload = function () {
                        p3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
                    };
                    xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
                    xmlhttp.send();
                    updateTotal();
                }
            };
            xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=voorraad`);
            xmlhttp.send();
        });
        btndivinside.appendChild(btnp);

        let btnm = document.createElement("button");
        btnm.textContent = "-";
        btnm.addEventListener("click", () => {
            if (document.querySelector(".cartbtn") != null) {
                document.querySelector(".cartbtn").toggleAttribute("disabled");
            }
            cart[i].amount--;
            p2.textContent = "In winkelwagen: " + cart[i].amount;
            xmlhttp.onload = function () {
                p3.textContent = "Totaal: €" + (this.responseText * cart[i].amount).toFixed(2);
            };
            xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
            xmlhttp.send();
            if (cart[i].amount == 0) {
                cart.splice(i, 1);
                reloadCart();
            }
            let string = JSON.stringify(cart);
            localStorage.setItem("cart", string);
            updateTotal();
        });
        btndivinside.appendChild(btnm);

        let btnrm = document.createElement("button");
        btnrm.textContent = "verwijder";
        btnrm.addEventListener("click", () => {
            if (document.querySelector(".cartbtn") != null) {
                document.querySelector(".cartbtn").removeAttribute("disabled");
            }
            cart.splice(i, 1);
            let string = JSON.stringify(cart);
            localStorage.setItem("cart", string);
            reloadCart();
            updateTotal();
        });
        btndiv.appendChild(btnrm);
        itemconfirm = 1;
    }
    if (itemconfirm == 0) {
        const maindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        maindiv.append(scelem);

        let p = document.createElement("p");
        p.classList.toggle("noitem");
        p.textContent = "Er is geen item in je winkelwagen...";
        scelem.appendChild(p);
    } else {
        const maindiv = document.querySelector("div.sccontent");
        let scelem = document.createElement("div");
        scelem.classList.toggle("scelem");
        scelem.classList.toggle("checkoutelem");
        maindiv.append(scelem);
        let p = document.createElement("p");
        p.textContent = "Totaal: €";
        scelem.appendChild(p);
        let span2 = document.createElement("span");
        span2.setAttribute("id", "total");
        p.appendChild(span2);

        updateTotal();

        let btn = document.createElement("button");
        btn.textContent = "Afrekenen";
        btn.addEventListener("click", () => { window.location.href = "checkout.php"; });
        scelem.appendChild(btn);
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

// loads when the page fully loads

window.onload = () => {
    reloadCart();
};

// update all total checkout money

function updateTotal() {
    document.getElementById("total").textContent = 0;
    for (let i = 0; i < cart.length; i++) {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function () {
            if (document.getElementById("total").textContent == "") {
                document.getElementById("total").textContent = 0;
            }
            let existingMoney = parseFloat(document.getElementById("total").textContent);
            let calc = ((parseFloat(this.responseText) * cart[i].amount) + existingMoney).toFixed(2);
            document.getElementById("total").textContent = calc;
        };
        xmlhttp.open("GET", `scripts/getdata.php?id=${cart[i].id}&data=prijs`);
        xmlhttp.send();
    }
}

function expand() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}