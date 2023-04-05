if (localStorage.getItem("cart") == null) {
    let cart = [];
    let string = JSON.stringify(cart);
    localStorage.setItem("cart", string);
} else {
    let cart = JSON.parse(localStorage.getItem("cart"));
}