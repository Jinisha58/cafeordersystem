//Admin Dashboard Script
 // JavaScript function to toggle sections
 function toggleSection(section) {
    const sections = ['tables', 'menu', 'customers', 'cashiers'];
    sections.forEach(sec => {
        const element = document.getElementById(sec);
        if (sec === section) {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
        } else {
            element.style.display = 'none';
        }
    });
}


/*function toggleSection(sectionId) {
    const sections = ['tables', 'menu', 'customers', 'cashiers'];
    sections.forEach(id => {
        const section = document.getElementById(id);
        section.classList.toggle('hidden', id !== sectionId);
    });
}

function editTable(tableNumber) {
    const statusCell = document.getElementById(`status-${tableNumber}`);
    const currentStatus = statusCell.textContent;
    const newStatus = currentStatus === 'Occupied' ? 'Available' : 'Occupied';
    statusCell.textContent = newStatus;
    alert(`Table ${tableNumber} status changed to: ${newStatus}`);
}
    function editItem(itemName) {
        alert("Editing item: " + itemName);
    }

    function deleteItem(itemName) {
        alert("Deleting item: " + itemName);
    }

   // function addMenuItem() {
    // Implement functionality for adding a new menu item here
   // alert('Add Menu Item functionality goes here.');
//}
    function toggleOrders(customerId) {
    const ordersSection = document.getElementById('orders-' + customerId);
    ordersSection.classList.toggle('hidden');
}*/


