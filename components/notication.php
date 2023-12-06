<?php
session_start();
$msg = $_SESSION['msg'];
$status = $_SESSION['status'];

if (isset($msg) && isset($status)) {
    echo "<script>let msg = '$msg';</script>";
    echo "<script>let msgStatus = '$status';</script>";
};

unset($_SESSION['msg']);
unset($_SESSION['status']);
 
?>
<style>
    #notication {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999999;
    }

    .toast {
        width: auto;
        padding: 0 10px;
        font-size: 16px;
        animation: toastAni 5s ease 1 forwards;
        margin-bottom: 20px;
        border-radius: 0.5rem;
    }

    .toast-body {
        padding: 0.75rem;
        word-wrap: break-word;
    }

    .text-bg-warning {
        color: #000;
        background-color: rgba(255,193,7,1);
    }
    .text-bg-success {
        color: #fff;
        background-color: rgba(25,135,84,1);
    }
    .text-bg-danger {
        color: #fff;
        background-color: rgba(220,53,69,1);
    }

    
    @keyframes toastAni {
        0% {
            transform: translateX(20px);
            opacity: 0;
        }

        25% {
            transform: translateX(0px);
            opacity: 1;
        }

        75% {
            transform: translateX(0px);
            opacity: 1;
        }

        100% {
            transform: translateX(-20px);
            opacity: 0;
        }
    }
</style>
<section id="notication">

</section>


<script>
    //Quản lý thông báo
    class ControlMessage {
        create(msg, status = "success") {
            let notication = document.querySelector("#notication");
            let toast = `<div class="toast align-items-center text-bg-${status} border-0 show">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${msg}
                        </div>
                    </div>
                </div>`;
            notication.insertAdjacentHTML("beforeend", toast);
        }
    }

    const controlMessage = new ControlMessage();
    if (typeof msg !== "undefined" && typeof msgStatus !== "undefined") {
        controlMessage.create(msg, msgStatus);
    }
</script>

