<style>
    #formAddCan {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        opacity: 0;
        z-index: 1;
    }

    #formAddCan.active {
        display: flex;
        animation: fade 0.3s ease forwards;
    }


    @keyframes fade {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes fade2 {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            display: none;
        }
    }

    #formAddCan form {
        width: 700px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    }

    #formAddCan form input:focus {
        outline: none;
    }

    #formAddCan .headerForm {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: var(--main-color);
        color: #fff;
        padding: 20px 20px 20px 30px;
    }

    #formAddCan .headerForm .formAddCan__title {
        font-size: 38px;
        font-weight: 700;
        text-transform: uppercase;
    }

    #formAddCan .headerForm img {
        width: 150px;
    }

    #formAddCan .bodyForm {
        background-color: #fff;
        padding: 30px;
    }


    #formAddCan form .form-row {
        display: flex;
        margin: 32px 0;
    }

    #formAddCan form .form-row .input-data {
        width: 100%;
        height: 40px;
        margin: 0 20px;
        position: relative;
    }

    #formAddCan form .form-row .textarea {
        height: 70px;
    }

    .input-data input,
    .textarea textarea {
        display: block;
        width: 100%;
        height: 100%;
        border: none;
        font-size: 17px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.12);
    }

    .input-data input:focus~label,
    .textarea textarea:focus~label,
    .input-data input:valid~label,
    .textarea textarea:valid~label {
        transform: translateY(-20px);
        font-size: 14px;
        color: #3498db;
    }

    .textarea textarea {
        resize: none;
        padding-top: 10px;
    }

    .input-data label {
        position: absolute;
        pointer-events: none;
        bottom: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .textarea label {
        width: 100%;
        bottom: 40px;
        background: #fff;
    }

    .input-data .underline {
        position: absolute;
        bottom: 0;
        height: 2px;
        width: 100%;
    }

    .input-data .underline:before {
        position: absolute;
        content: "";
        height: 2px;
        width: 100%;
        background: #3498db;
        transform: scaleX(0);
        transform-origin: center;
        transition: transform 0.3s ease;
    }

    .input-data input:focus~.underline:before,
    .input-data input:valid~.underline:before,
    .textarea textarea:focus~.underline:before,
    .textarea textarea:valid~.underline:before {
        transform: scale(1);
    }

    .input-data select {
        width: 100%;
        height: 100%;
        border: 2px solid rgba(0, 0, 0, 0.12);
        font-size: 14px;
        color: #000;
    }

    textarea:focus {
        outline: none;
    }
</style>
<div id="formAddCan">
    <form action="./ad_func/addCan.php" method="post" enctype="multipart/form-data">
        <div class="headerForm">
            <div class="leftSide">
                <div class="formAddCan__title">
                    Add new Candidates
                </div>
                <div class="formAddCan__subTitle">
                    Fill out the form
                </div>
            </div>
            <div class="rightSide">
                <img src="./images/formUserImg.png" alt="">
            </div>
        </div>
        <div class="bodyForm">
            <div class="form-row">
                <div class="input-data">
                    <input type="text" name="can_id" required>
                    <div class="underline"></div>
                    <label for="can_id">Candidates ID</label>
                </div>
                <div class="input-data">
                    <input type="text" name="can_name" required>
                    <div class="underline"></div>
                    <label for="can_name">Name</label>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <select id="province">
                        <option value="">Tỉnh đồng nai</option>
                        <option value="">Tỉnh ngọc dinh</option>
                    </select>
                </div>
                <div class="input-data">
                    <select id="district">
                        <option value="">Huyện ngọc định</option>
                        <option value="">Huyện ngọc dinh</option>
                    </select>
                </div>
                <div class="input-data">
                    <select id="ward">
                        <option value="">xã ngọc định</option>
                        <option value="">xã ngọc dinh</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="file" name="can_avt" id="can_avt">
                    <div class="underline"></div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data textarea">
                    <textarea rows="3" cols="50" required name="can_desc"></textarea>
                    <br />
                    <div class="underline"></div>
                    <label for="">Write your message</label>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <input type="submit" value="Add New Candidates">
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    const btnAddCan = document.querySelector("#btnAddCan");
    const boxForm = document.querySelector("#formAddCan");

    btnAddCan.addEventListener("click", (e) => {
        boxForm.classList.add("active");
    });

    boxForm.addEventListener("click", (e) => {
        if (e.target.id === 'formAddCan') {
            boxForm.classList.remove("active");
        }
    });

    const baseUrl = "https://provinces.open-api.vn/api";

    class Http {
        get(url) {
            return fetch(url).then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error(response.statusText);
                }
            });
        }
    }

    class Store {
        constructor() {
            this.http = new Http();
        }
        //getProvinces: lấy danh sách các thành phố
        getProvinces(code = "") {
            return this.http
                .get(`${baseUrl}/p/${code}`)
                .then((provinces) => {
                    return provinces;
                })
                .catch((err) => {
                    console.log(err);
                });
        }
        //getDistrictsByProvinceCode: lấy danh sách các qận theo provinceCode
        getDistrictsByProvinceCode(provinceCode) {
            console.log(`${baseUrl}/p/${provinceCode}/?depth=2`);
            return this.http
                .get(`${baseUrl}/p/${provinceCode}/?depth=2`)
                .then((province) => {
                    return province.districts;
                })
                .catch((err) => {
                    console.log(err);
                });
        }
        //getWardsByDistrictCode: lấy danh sách các Wards theo DistrictCode
        getWardsByDistrictCode(districtCode) {
            return this.http
                .get(`${baseUrl}/d/${districtCode}?depth=2`)
                .then((district) => {
                    return district.wards;
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }

    class RenderUI {
        //renderProvinces: render giao diện danh sách các provinces
        renderProvinces(provinces) {
            let content = "";
            provinces.forEach((province) => {
                const {
                    code,
                    name
                } = province;
                content += `<option value="${code}">${name}</option>`;
                document.querySelector("#formAddCan #province").innerHTML = content;
            });
        }
        //renderDistricts: render giao diện danh sách các districts
        renderDistricts(districts) {
            let content = "";
            districts.forEach((district) => {
                const {
                    code,
                    name
                } = district;
                content += `<option value="${code}">${name}</option>`;
                document.querySelector("#formAddCan #district").innerHTML = content;
            });
        }
        //renderWards: render giao diện danh sách các wards
        renderWards(wards) {
            let content = "";
            wards.forEach((ward) => {
                const {
                    code,
                    name
                } = ward;
                content += `<option value="${code}">${name}</option>`;
                document.querySelector("#formAddCan #ward").innerHTML = content;
            });
        }

        // renderInfo
        renderInfo(info) {
            const {
                ward,
                district,
                province
            } = info;
            let content = `${ward}, ${district}, ${province}`;
            return content;
        }
    }


    //sự kiện load trang
    document.addEventListener("DOMContentLoaded", (event) => {
        let store = new Store();
        let ui = new RenderUI();
        store
            .getProvinces()
            .then((provinces) => {
                //render lên ui
                ui.renderProvinces(provinces);
                //lấy provinceCode
                let provinceCode = document.querySelector("#formAddCan #province").value;
                //dùng provinceCode lấy danh sách các districs
                return store.getDistrictsByProvinceCode(provinceCode);
            })
            .then((districts) => {
                ui.renderDistricts(districts);
                let districtCode = document.querySelector("#formAddCan #district").value;
                //dùng districtCode lấy danh sách các wards
                return store.getWardsByDistrictCode(districtCode);
            })
            .then((wards) => {
                ui.renderWards(wards);
            });
    });

    // sự kiện khi change province
    document.querySelector("#formAddCan #province").addEventListener("change", (event) => {
        let store = new Store();
        let ui = new RenderUI();

        let provinceCode = document.querySelector("#formAddCan #province").value;
        //dùng provinceCode lấy danh sách các districs
        store
            .getDistrictsByProvinceCode(provinceCode)
            .then((districts) => {
                ui.renderDistricts(districts);
                let districtCode = document.querySelector("#formAddCan #district").value;
                //dùng districtCode lấy danh sách các wards
                return store.getWardsByDistrictCode(districtCode);
            })
            .then((wards) => {
                ui.renderWards(wards);
            });
    });

    // sự kiện khi change district
    document.querySelector("#formAddCan #district").addEventListener("change", (event) => {
        let store = new Store();
        let ui = new RenderUI();

        let districtCode = document.querySelector("#formAddCan #district").value;
        //dùng districtCode lấy danh sách các wards
        store.getWardsByDistrictCode(districtCode).then((wards) => {
            ui.renderWards(wards);
        });
    });

    document.querySelector("#formAddCan form").addEventListener("submit", (event) => {
        event.preventDefault();
        let province = document.querySelector("#formAddCan #province option:checked").textContent;
        let district = document.querySelector("#formAddCan #district option:checked").textContent;
        let ward = document.querySelector("#formAddCan #ward option:checked").textContent;
        let info = {
            ward,
            district,
            province
        }
        //renderInfo
        let ui = new RenderUI();
        address = ui.renderInfo(info);
        let can_adr = `<input type="hidden" name="can_adr" value="${address}">`;
        event.currentTarget.insertAdjacentHTML("beforeend", can_adr);
        event.currentTarget.submit();
    });
</script>