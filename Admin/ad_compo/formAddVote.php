<style>
    #formAddVote {
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

    #formAddVote.active {
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

    #formAddVote form {
        width: 700px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    }

    #formAddVote form input:focus {
        outline: none;
    }

    #formAddVote .headerForm {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: var(--main-color);
        color: #fff;
        padding: 20px 20px 20px 30px;
    }

    #formAddVote .headerForm .formAddVote__title {
        font-size: 38px;
        font-weight: 700;
        text-transform: uppercase;
    }

    #formAddVote .headerForm img {
        width: 150px;
    }

    #formAddVote .bodyForm {
        background-color: #fff;
        padding: 30px;
    }


    #formAddVote form .form-row {
        display: flex;
        flex-direction: column;
        margin: 32px 0;
        gap: 10px;
    }

    #formAddVote form .form-row .label {
        font-weight: 18px;
        font-weight: bold;
    }

    #formAddVote form .form-row .input-data {
        width: 100%;
        height: 40px;
        position: relative;
    }

    #formAddVote form .form-row .textarea {
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
<div id="formAddVote">
    <form action="./ad_func/addCan.php" method="post">
        <div class="headerForm">
            <div class="leftSide">
                <div class="formAddVote__title">
                    Add new Vote
                </div>
                <div class="formAddVote__subTitle">
                    Fill out the form
                </div>
            </div>
            <div class="rightSide">
                <img src="./images/formUserImg.png" alt="">
            </div>
        </div>
        <div class="bodyForm">
            <div class="form-row">
            <div class="label">User</div>
                <div class="input-data">
                    <select id="province">
                        <option value="">Tỉnh đồng nai</option>
                        <option value="">Tỉnh ngọc dinh</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="label">Candidate</div>
                <div class="input-data">
                    <select id="ward">
                        <option value="">xã ngọc định</option>
                        <option value="">xã ngọc dinh</option>
                    </select>
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
    const boxForm = document.querySelector("#formAddVote");

    btnAddCan.addEventListener("click", (e) => {
        boxForm.classList.add("active");
    });

    boxForm.addEventListener("click", (e) => {
        if (e.target.id === 'formAddVote') {
            boxForm.classList.remove("active");
        }
    });
</script>