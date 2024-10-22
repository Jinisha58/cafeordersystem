// Function to toggle visibility of sections
function showSection(sectionId) {
    document.getElementById('orderSection').style.display = 'none';
    document.getElementById('tableSection').style.display = 'none';
    document.getElementById('takeOrderSection').style.display = 'none';
    
    // Show the selected section
    document.getElementById(sectionId).style.display = 'block';
  }
  
  //order items and update
  const orderItems = document.getElementById('orderItems');
          const totalPrice = document.getElementById('totalPrice');
          const quantity = document.getElementById('quantity');
          const increaseQty = document.getElementById('increaseQty');
          const decreaseQty = document.getElementById('decreaseQty');
  
          function updateTotalPrice() {
              const selectedItem = orderItems.options[orderItems.selectedIndex];
              const itemPrice = parseFloat(selectedItem.getAttribute('data-price'));
              const qty = parseInt(quantity.value);
              totalPrice.value = (itemPrice * qty).toFixed(2);
          }
  
          orderItems.addEventListener('change', updateTotalPrice);
          quantity.addEventListener('input', updateTotalPrice);
  
          increaseQty.addEventListener('click', () => {
              quantity.value = parseInt(quantity.value) + 1;
              updateTotalPrice();
          });
  
          decreaseQty.addEventListener('click', () => {
              if (parseInt(quantity.value) > 1) {
                  quantity.value = parseInt(quantity.value) - 1;
                  updateTotalPrice();
              }
          });
  