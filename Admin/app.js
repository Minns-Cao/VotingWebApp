const userRows = document.querySelectorAll("#userTable tr");

function fillOutForm(username, role, password, email) {
    inputUsername = document.querySelector("#formUpdateUser [name='username']");
    inputUsernameOld = document.querySelector(
        "#formUpdateUser [name='usernameOld']"
    );
    inputRole = document.querySelector("#formUpdateUser [name='role']");
    inputPassword = document.querySelector("#formUpdateUser [name='password']");
    inputEmail = document.querySelector("#formUpdateUser [name='email']");
    inputUsername.value = username;
    inputUsernameOld.value = username;
    inputRole.value = role;
    inputPassword.value = password;
    inputEmail.value = email;
}

function fillOutForm_can(can_id, can_name, can_desc) {
    inputCan_id = document.querySelector("#formUpdateCan [name='can_id']");
    inputCan_id_old = document.querySelector(
        "#formUpdateCan [name='can_id_old']"
    );

    inputCan_name = document.querySelector("#formUpdateCan [name='can_name']");
    inputCan_desc = document.querySelector("#formUpdateCan [name='can_desc']");
    inputCan_id.value = can_id;
    inputCan_id_old.value = can_id;
    inputCan_name.value = can_name;
    inputCan_desc.value = can_desc;
}

userRows.forEach((userRow) => {
    userRow.addEventListener("contextmenu", (e) => {
        e.preventDefault();
        // xoá các active đi
        userRows.forEach((_userRow) => {
            _userRow.classList.remove("active");
        });
        let x = e.clientX - userRow.offsetLeft - 10;
        const btnControls = userRow.querySelector(".btnControls");
        btnControls.style.setProperty("--x", `${x}px`);
        userRow.classList.add("active");
    });

    userRow.addEventListener("mouseleave", (e) => {
        userRow.classList.remove("active");
    });
});

//sự kiện click vào nút update
const btnUpdateList = document.querySelectorAll("a[data-email]");
const btnUpdateList_can = document.querySelectorAll("a[data-id]");

btnUpdateList.forEach((btnUpdate) => {
    btnUpdate.addEventListener("click", (event) => {
        let email = event.currentTarget.dataset.email;
        console.log("click nè");
        fetch(
            `http://localhost/voting/admin/ad_func/getInfoUser.php?email=${email}`
        )
            .then((res) => {
                if (res.ok) {
                    return res.json();
                } else {
                    throw new Error(res.statusText);
                }
            })
            .then((data) => {
                fillOutForm(
                    data.username,
                    data.role,
                    data.password,
                    data.email
                );
            })
            .catch((err) => {
                console.log(err);
            });
    });
});

let store = new Store2();
let ui = new RenderUI2();
btnUpdateList_can.forEach((btnUpdate) => {
    btnUpdate.addEventListener("click", (event) => {
        let id = event.currentTarget.dataset.id;
        fetch(
            `http://localhost/voting/admin/ad_func/getInfoCan.php?can_id=${id}`
        )
            .then((res) => {
                if (res.ok) {
                    return res.json();
                } else {
                    throw new Error(res.statusText);
                }
            })
            .then((data) => {
                fillOutForm_can(data.can_id, data.can_name, data.can_desc);
            })
            .catch((err) => {
                console.log(err);
            });
    });
});

// sự kiện thông báo khi xoá
let btnDelete_List = document.querySelectorAll(".btnDelete");
btnDelete_List.forEach((btn_delete) => {
    btn_delete.addEventListener("click", (e) => {
        e.preventDefault();
        if (confirm("bạn có chắc chắc muốn xoá user này ?")) {
            window.location = e.currentTarget.href;
        }
    });
});
