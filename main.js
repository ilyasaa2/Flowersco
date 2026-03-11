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

//Reset Keranjang
function resetKeranjang(){

  keranjang = [];

  localStorage.setItem("keranjang", JSON.stringify(keranjang));

  updateCart();

  alert("Keranjang dikosongkan");

}




//Page Pesanan
const produkList = {
    "Pink Rose Bouqet": {
        harga: "$15.99",
        gambar: "images/PinkRoseBouqet.jpg",
        kategori: "ROMANTIS"
    },
    "Calla Lily Bouqet": {
        harga: "$15.99",
        gambar: "images/CallaLilyBouquet.jpg",
        kategori: "MINIMALIS"
    },
    "Cherry Blossom": {
        harga: "$15.99",
        gambar: "images/CherryBlossom.jpg",
        kategori: "ELEGAN"
    },
    "Lavender": {
        harga: "$15.99",
        gambar: "images/LavenderBouquet.jpg",
        kategori: "SUCI"
    }
};
