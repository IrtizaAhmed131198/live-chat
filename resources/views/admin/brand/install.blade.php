@extends('admin.layout.app')

@section('title', 'Install Widget')

@section('content')

<style>
.install-card {
    background: #1e1e2f;
    border-radius: 15px;
    padding: 40px;
    color: #fff;
}

.script-box {
    background: #2a2a40;
    border-radius: 10px;
    padding: 20px;
    font-size: 14px;
    color: #bfc7ff;
    cursor: pointer;
    transition: 0.3s;
    position: relative;
}

.script-box:hover {
    background: #32325a;
    box-shadow: 0 0 15px rgba(100, 108, 255, 0.4);
}

.copy-btn {
    background: linear-gradient(45deg, #6366f1, #8b5cf6);
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    color: #fff;
    font-weight: 500;
    transition: 0.3s;
}

.copy-btn:hover {
    opacity: 0.9;
}

.copy-toast {
    position: absolute;
    top: 10px;
    right: 15px;
    background: #4ade80;
    color: #000;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    display: none;
}
</style>

<div class="container mt-5">
    <div class="install-card shadow-lg">

        <h2 class="mb-3 fw-bold">Install Widget</h2>

        <p class="text-light mb-4">
            To install <strong>Live Chat</strong>, place this code before the
            <code>&lt;/body&gt;</code> tag on every page of your website.
        </p>

        <div class="script-box" onclick="copyScript()">
            <span class="copy-toast" id="toast">Copied!</span>
            <pre id="liveChatScript" class="mb-0">{{ $script }}</pre>
        </div>

        <button onclick="copyScript()" class="copy-btn mt-4">
            Copy Script
        </button>

    </div>
</div>

<script>
function copyScript() {
    let text = document.getElementById("liveChatScript").innerText;

    navigator.clipboard.writeText(text).then(function() {
        let toast = document.getElementById("toast");
        toast.style.display = "inline-block";

        setTimeout(() => {
            toast.style.display = "none";
        }, 1500);
    });
}
</script>

@endsection
