// Note this js file was purely used for front-end scripting, to make a textbox appear dynamically

const update = document.querySelector('#update-btn');

update.onclick = function () {
    if (document.querySelector('input[name="update"]')) {
        return;
    } else {
        const rbs = document.querySelectorAll('input[name="radio"]');
        for (const rb of rbs) {
            if (rb.checked) {
                var x = document.createElement("INPUT");
                x.setAttribute("type", "text");
                x.setAttribute("name", "update");
                x.value = rb.value;
                var y = document.createElement("INPUT");
                y.setAttribute("type", "submit");
                y.setAttribute("name", "save");
                y.setAttribute("value", "Save");
                let form = document.getElementById("radio-form");
                form.appendChild(x);
                form.appendChild(y);
                break;
            } else {
                continue;
            }
        }
    }
}