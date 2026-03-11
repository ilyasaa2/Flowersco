// Homepage tombol login
document.addEventListener("DOMContentLoaded", function () {

  const loginBtn = document.getElementById("loginbtn");

  loginBtn.addEventListener("click", function () {
    window.location.href = "Login.html";
  });

});


//Tambah pesannan
let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

updateCart();

function tambahKeranjang(namaProduk) {

  keranjang.push(namaProduk);

  localStorage.setItem("keranjang", JSON.stringify(keranjang));

  updateCart();

  alert(namaProduk + " ditambahkan ke keranjang!");
}

function updateCart() {
  const cartCount = document.getElementById("cart-count");

  if(cartCount){
    cartCount.textContent = keranjang.length;
  }
}


//Tambah Favorit
function tambahFavorit(event, namaProduk){

  if(!favorit.includes(namaProduk)){
    favorit.push(namaProduk);

    localStorage.setItem("favorit", JSON.stringify(favorit));

    updateFavorite();

    event.target.classList.add("text-red-500");

    alert(namaProduk + " ditambahkan ke favorit!");

  }else{
    alert("Produk sudah ada di favorit");
  }

}