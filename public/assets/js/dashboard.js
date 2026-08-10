// ==========================================
// Notebook Borrow System
// Real-time Dashboard
// A7.3.4
// ==========================================

document.addEventListener("DOMContentLoaded", () => {

    refreshDashboard();

    setInterval(refreshDashboard, 5000);

});


// ==========================================
// Refresh Dashboard
// ==========================================

function refreshDashboard() {

    fetch("../process/get_dashboard_status.php")

        .then(res => res.json())

        .then(data => {

            updateStatistics(data.statistics);

            updateNotebook(data.notebooks);

        })

        .catch(err => {

            console.error(err);

        });

}


// ==========================================
// Statistics
// ==========================================

function updateStatistics(stat) {

    const total =
        document.getElementById("stat-total");

    const available =
        document.getElementById("stat-available");

    const borrowed =
        document.getElementById("stat-borrowed");

    const mine =
        document.getElementById("stat-mine");

    if(total) total.textContent = stat.total;

    if(available) available.textContent = stat.available;

    if(borrowed) borrowed.textContent = stat.borrowed;

    if(mine) mine.textContent = stat.my_request;

}


// ==========================================
// Notebook
// ==========================================

function updateNotebook(notebooks){

    notebooks.forEach(nb=>{

        updateCard(nb);

    });

}


// ==========================================
// Update Card
// ==========================================

function updateCard(nb){

    const image =
        document.getElementById(
            "image-"+nb.id
        );

    const action =
        document.getElementById(
            "action-"+nb.id
        );

    const badge =
        image.querySelector(".status-badge");

    // ===============================
    // Badge
    // ===============================

    badge.className = "status-badge";

    switch(nb.current_status){

        case "available":

            badge.classList.add("available");

            badge.textContent =
            "Available";

            break;

        case "pending":

            badge.classList.add("pending");

            badge.textContent =
            "Pending";

            break;

        case "borrowed":

            badge.classList.add("borrowed");

            badge.textContent =
            "Borrowed";

            break;

    }

    // ===============================
    // Overlay
    // ===============================

    if(nb.current_status==="available"){

        image.classList.remove("disabled");

    }

    else{

        image.classList.add("disabled");

    }

    // ===============================
    // Action
    // ===============================

    switch(nb.action){

        case "request":

            action.innerHTML=`

<form
action="../../process/request_borrow.php"
method="POST">

<input
type="hidden"
name="notebook_id"
value="${nb.id}">

<button
class="btn btn-primary w-100">

Request Borrow

</button>

</form>

`;

        break;

        case "pending_me":

            action.innerHTML=`

<div class="d-grid gap-2">

<button
class="btn btn-warning"
disabled>

Pending Approval

</button>

<a

href="../../process/cancel_request.php?notebook_id=${nb.id}"

class="btn btn-outline-danger"

data-title="Cancel Request?"

data-text="Do you want to cancel this request?"

data-confirm="Yes"

data-icon="warning">

Cancel Request

</a>

</div>

`;

        break;

        case "pending_other":

            action.innerHTML=`

<button
class="btn btn-warning w-100"
disabled>

Pending Approval

</button>

`;

        break;

        case "borrowed":

            action.innerHTML=`

<button
class="btn btn-danger w-100"
disabled>

Borrowed

</button>

`;

        break;

        case "limit":

            action.innerHTML=`

<button
class="btn btn-secondary w-100"
disabled>

Maximum 2 Notebooks

</button>

`;

        break;

    }

}