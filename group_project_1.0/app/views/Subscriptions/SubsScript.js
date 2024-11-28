function toggleBilling() {
    const prices = document.querySelectorAll(".price-amount");
    const isAnnual = document.getElementById("billing-switch").checked;
  
    if (isAnnual) {
      prices[0].textContent = "12"; // Lite plan (monthly)
      prices[1].textContent = "28"; // Pro plan (monthly)
    } else {
      prices[0].textContent = "16"; // Lite plan (annually)
      prices[1].textContent = "35"; // Pro plan (annually)
    }
  }

  function addLite(){
    alert("Lite plan added to cart");
  }

  function addPro(){
    alert("Pro plan added to cart");
  }
  